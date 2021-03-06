<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        // Общие правила валидации
        $rules = [
            // Текст записи
            'content' => 'required',
            // Прикрепленные картинки
            'images' => 'nullable|array',
            'images.*' => 'image'
        ];
        // Если пользователь не авторизован
        if(!Auth::check()) {
            // Нужно заполнить автора
            $rules['author'] = 'required';
            // И ответ капчи
            $rules['g-recaptcha-response'] = 'required';
        }
        // Возвращаем правила
        return $rules;
    }
}
