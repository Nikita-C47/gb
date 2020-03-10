<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Класс, представляющий запрос на обновление профиля.
 * @package App\Http\Requests Запросы приложения.
 */
class ProfileFormRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнять этот запрос.
     *
     * @return bool
     */
    public function authorize()
    {
        // Выполнять запрос может только авторизованный пользователь
        return Auth::check();
    }

    /**
     * Возвращает правила валидации.
     *
     * @return array массив с правилами валидации.
     */
    public function rules()
    {
        return [
            // Имя пользователя
            'name' => 'required',
            // Email пользователя
            'email' => [
                'required',
                'email',
                // Игнорируем в unique ткуущего пользователя
                Rule::unique('users')->ignore(Auth::user()->getAuthIdentifier())
            ],
            // Пароль
            'password' => 'nullable|string|min:8|confirmed',
            // Количество записей
            'rows_count' => 'nullable|integer|min:1'
        ];
    }
}
