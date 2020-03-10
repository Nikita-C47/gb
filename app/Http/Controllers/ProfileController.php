<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Класс, представляющий контроллер профиля пользователя.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class ProfileController extends Controller
{
    /**
     * Отображает форму редактирования профиля пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Обновляет профиль пользователя.
     *
     * @param ProfileFormRequest $request запрос на обновление пользователя.
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileFormRequest $request)
    {
        // Получаем текущего пользователя
        /** @var \App\User $user */
        $user = Auth::user();
        // Обновляем данные
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->rows_count = $request->get('rows_count');
        // Если есть пароль - его нужно обновить
        if(filled($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }
        // Сохраняем модель
        $user->save();
        // Если было изменено имя
        if($user->wasChanged('name')) {
            // Обновляем его в связанных записях
            $user->entries()->update(['author' => $user->name]);
        }
        // Перенаправляем пользователя на главную с уведомлением
        return redirect()->route('home')->with('alert', [
            'type' => 'success',
            'text' => 'Ваш профиль успешно сохранен'
        ]);
    }
}
