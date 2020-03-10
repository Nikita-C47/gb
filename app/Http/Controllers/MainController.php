<?php

namespace App\Http\Controllers;

use App\Components\Helpers\CaptchaHelper;
use App\Http\Requests\EntryFormRequest;
use App\Models\Entry;
use App\Models\EntryImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Класс, представляющий основной контроллер приложения.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class MainController extends Controller
{
    use CaptchaHelper;

    /**
     * Отображает список записей в гостевой книге.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Устанавливаем количество выбираемых записей по-умолчанию
        $count = config('app.default_rows_count');
        // Если пользователь авторизован
        if(Auth::check()) {
            /** @var \App\User $user */
            $user = Auth::user();
            // Если заполнено количество строк - устанавливаем его
            if (filled($user->rows_count)) {
                $count = $user->rows_count;
            }
        }
        // Получаем список записей с постраничной разбивкой
        $entries = Entry::with('images')->orderBy('id', 'desc')->paginate($count);
        // Возвращаем представление
        return view('main.index', [
            'entries' => $entries
        ]);
    }

    /**
     * Отображает форму добавления записи.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEntry()
    {
        return view('main.add-entry');
    }

    /**
     * Обрабатывает сохранение записи в БД.
     *
     * @param EntryFormRequest $request запрос на добавление записи.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException исключение если файл изображения не найден.
     */
    public function saveEntry(EntryFormRequest $request)
    {
        // Если пользователь авторизован - просто сохраняем статью
        if(Auth::check()) {
            // Сохраняем запись в БД
            $alert = $this->storeEntry($request);
        } else {
            // Если пользователь не авторизован - надо добавить капчу
            if($this->verifyCaptcha($request->get('g-recaptcha-response'))) {
                // Сохраняем запись в БД если капча успешно пройдена
                $alert = $this->storeEntry($request);
            } else {
                // Иначе указываем что есть проблемы
                $alert = [
                    'type' => 'danger',
                    'text' => 'Подтвердите, что вы не робот!'
                ];
            }
        }
        // Возвращаем редирект на главную с уведомлением
        return redirect()->route('home')->with('alert', $alert);
    }

    /**
     * Сохраняет запись в БД.
     *
     * @param EntryFormRequest $request запрос на добавление записи.
     * @return array массив с данными для уведомления об успешном сохранении записи.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException исключение если файл изображения не найден.
     */
    private function storeEntry(EntryFormRequest $request)
    {
        // Собираем базовые данные
        $data = [
            'author' => $request->get('author'),
            'content' => $request->get('content')
        ];
        // Если пользователь авторизован
        if(Auth::check()) {
            // Указываем его
            /** @var \App\User $user */
            $user = Auth::user();
            $data['user_id'] = $user->id;
            $data['author'] = $user->name;
        }
        // Сохраняем запись
        $entry = new Entry($data);
        $entry->save();
        // Если есть прикрепленные изображения
        if($request->hasFile('images')) {
            // Перебираем их
            /** @var UploadedFile $image */
            foreach ($request->file('images') as $image) {
                // Сохраняем файл
                $newImage = new EntryImage([
                    'entry_id' => $entry->id,
                    'name' => Str::random(),
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $image->getClientOriginalExtension()
                ]);
                // Сохраняем файл
                $newImage->save();
                // Сохраняем его в файловой системе
                $newImage->saveInFileSystem($image);
            }
        }
        // Возвращаем данные для уведомления
        return [
            'type' => 'success',
            'text' => 'Ваша запись успешно добавлена'
        ];
    }
}
