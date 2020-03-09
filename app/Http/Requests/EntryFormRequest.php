<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс, представляющий запрос на добавление записи.
 * @package App\Http\Requests Запросы приложения.
 */
class EntryFormRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнять этот запрос.
     *
     * @return bool
     */
    public function authorize()
    {
        // Выполнять запрос может любой пользователь
        return true;
    }

    /**
     * Возвращает правила валидации.
     *
     * @return array массив с правилами валидации.
     */
    public function rules()
    {
        return [
            'author' => 'required',
            'content' => 'required',
            'g-recaptcha-response' => 'required'
        ];
    }
}
