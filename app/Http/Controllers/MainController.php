<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryFormRequest;
use App\Models\Entry;
use GuzzleHttp\Client;

/**
 * Класс, представляющий основной контроллер приложения.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class MainController extends Controller
{
    /**
     * Отображает список записей в гостевой книге.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем список записей с постраничной разбивкой
        $entries = Entry::paginate(10);
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
     * Сохраняет запись в БД.
     *
     * @param EntryFormRequest $request запрос на добавление записи.
     * @return \Illuminate\Http\Response
     */
    public function saveEntry(EntryFormRequest $request)
    {
        if($this->verifyCaptcha($request->get('g-recaptcha-response'))) {
            $entry = new Entry([
                'author' => $request->get('author'),
                'content' => $request->get('content')
            ]);
            $entry->save();
            // Генерируем алерт
            $alert = [
                'type' => 'success',
                'text' => 'Ваша запись успешно добавлена'
            ];
        } else {
            // Иначе указываем что есть проблемы
            $alert = [
                'type' => 'danger',
                'text' => 'Подтвердите, что вы не робот!'
            ];
        }
        // Возвращаем редирект на главную с уведомлением
        return redirect()->route('home')->with('alert', $alert);
    }

    /**
     * Проверяет ответ Google captcha.
     *
     * @param string $response ответ google captcha.
     * @return bool флаг успешности проверки.
     */
    private function verifyCaptcha(string $response)
    {
        // Заводим клиент Guzzle
        $client = new Client();
        // Делаем запрос
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('app.google_recaptcha.secret'),
                'response' => $response
            ]
        ]);
        // Если ответ не успешен, возвращаем ложь
        if($result->getStatusCode() !== 200) {
            return false;
        }
        // Получаем контент ответа и декодируем его из JSON
        $content = json_decode($result->getBody()->getContents());
        // Возвращаем статус проверки
        return $content->success;
    }
}
