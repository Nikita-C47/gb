@extends('layouts.app')

@section('title', 'Обновить пароль')

@section('content')
    <div class="alert alert-info" role="alert">
        Введите свои новые учетные данные в форму ниже.
    </div>
    <div class="card border-primary">
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email" class="font-weight-bold">
                        Email: <span class="text-danger">*</span>
                    </label>
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ $email ?? old('email') }}"
                           required
                           autocomplete="email"
                           autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="font-weight-bold">
                        Новый пароль: <span class="text-danger">*</span>
                    </label>
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="font-weight-bold">
                        Подтверждение нового пароля: <span class="text-danger">*</span>
                    </label>
                    <input id="password-confirm"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           required
                           autocomplete="new-password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Обновить пароль
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
