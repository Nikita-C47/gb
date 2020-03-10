<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryUpdateFormRequest;
use App\Models\Entry;
use App\Models\EntryImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Класс, представляющий контроллер для работы с пользовательскими записями.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class EntriesController extends Controller
{
    /**
     * Отображает список записей текущего пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var \App\User $user */
        $user = Auth::user();
        // Получаем количество выводимых записей
        // Так как тут нет других настроек, засунем это свойство прямо в модель пользователя, без создания объекта профиля
        $count = filled($user->rows_count) ? $user->rows_count : config('app.default_rows_count');
        // Получаем записи пользователя
        $entries = $user->entries()->with('images')->orderBy('id', 'desc')->paginate($count);
        // Возвращаем представление
        return view('entries.index', ['entries' => $entries]);
    }

    /**
     * Отображает форму редактирования записи для пользователя.
     *
     * @param int $id ID записи в БД.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var Entry $entry */
        $entry = Entry::findOrFail($id);
        // Проверяем, правильную ли запись запросил пользователь
        Gate::authorize('entry', $entry);
        // Возвращаем представление
        return view('entries.edit', [
            'entry' => $entry
        ]);
    }

    /**
     * Обновляет указанную запись в БД.
     *
     * @param EntryUpdateFormRequest $request запрос на обновление записи.
     * @param int $id ID записи в БД.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException исключение если файл изображения не найден.
     */
    public function update(EntryUpdateFormRequest $request, $id)
    {
        /** @var Entry $entry */
        $entry = Entry::findOrFail($id);
        // Проверяем, правильную ли запись запросил пользователь
        Gate::authorize('entry', $entry);
        // Обновляем запись
        $entry->content = $request->get('content');
        $entry->save();

        // Если нужно сохранить новые изображения - сохраняем
        if($request->hasFile('images')) {
            /** @var UploadedFile $image */
            foreach ($request->file('images') as $image) {
                $newImage = new EntryImage([
                    'entry_id' => $entry->id,
                    'name' => Str::random(),
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $image->getClientOriginalExtension()
                ]);
                $newImage->save();
                $newImage->saveInFileSystem($image);
            }
        }
        // Если нужно удалить изображения
        if($request->has('removed_images')) {
            // Выбираем их среди изображений этой записи
            $images = $entry->images()->whereIn('id', $request->get('removed_images'))->get();
            // Перебираем
            /** @var EntryImage $image */
            foreach ($images as $image) {
                // Удаляем из файловой системы
                $image->removeFromFileSystem();
                // Удаляем
                $image->delete();
            }
        }
        // Отправляем на страницу с записями с уведомлением
        return redirect()->route('my-entries')->with('alert', [
            'type' => 'success',
            'text' => 'Запись успешно обновлена'
        ]);
    }

    /**
     * Удаляет указанную запись из БД.
     *
     * @param int $id ID записи в БД.
     * @return \Illuminate\Http\Response
     * @throws \Exception исключение при неудачном удалении.
     */
    public function delete($id)
    {
        /** @var Entry $entry */
        $entry = Entry::findOrFail($id);
        // Проверяем, правильную ли запись запросил пользователь
        Gate::authorize('entry', $entry);
        // Удаляем запись
        $entry->delete();
        // Удаляем папку с вложениями
        Storage::disk('public')->deleteDirectory('images/'.$entry->id);
        // Отправляем на страницу с записями с уведомлением
        return redirect()->route('my-entries')->with('alert', [
            'type' => 'success',
            'text' => 'Запись успешно удалена'
        ]);
    }
}
