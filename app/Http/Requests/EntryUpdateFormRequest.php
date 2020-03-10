<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Класс, представляющий запрос на обновление записи.
 * @package App\Http\Requests Запросы приложения.
 */
class EntryUpdateFormRequest extends FormRequest
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
            // Текст записи
            'content' => 'required',
            // Прикрепленные картинки
            'images' => 'nullable|array',
            'images.*' => 'image',
            // Изображения, подлежащие удалению
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'exists:entry_images,id'
        ];
    }
}
