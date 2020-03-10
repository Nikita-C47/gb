@extends('layouts.app')

@section('title', 'Редактировать профиль')

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            <form method="post">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold" for="name">
                        Имя: <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ $user->name }}"
                           required
                           autocomplete="name"
                           autofocus
                           name="name"
                           id="name" />
                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="email">
                        Email: <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ $user->email }}"
                           required
                           autocomplete="email"
                           autofocus
                           name="email"
                           id="email" />
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="password">
                        Новый пароль:
                    </label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           autocomplete="password"
                           autofocus
                           aria-describedby="passwordHelp"
                           name="password"
                           id="password" />
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <small id="passwordHelp" class="form-text text-muted">
                        Если Вы не хотите обновлять пароль, оставьте это поле пустым.
                    </small>
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="font-weight-bold">
                        Подтверждение пароля:
                    </label>
                    <input id="password-confirm"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="rows_count">
                        Количество выводимых записей:
                    </label>
                    <input type="number"
                           class="form-control @error('rows_count') is-invalid @enderror"
                           value="{{ $user->rows_count }}"
                           autocomplete="rows_count"
                           autofocus
                           aria-describedby="rowsCountHelp"
                           name="rows_count"
                           id="rows_count" />
                    @error('rows_count')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <small id="rowsCountHelp" class="form-text text-muted">
                        Вы можете указать сколько записей на страницу выводить в списках. Если оставите пустым, количество будет стандартным (10).
                    </small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
