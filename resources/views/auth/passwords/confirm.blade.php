@extends('layouts.app')

@section('title', 'Подтверждение пароля')

@section('content')
    <div class="alert alert-info" role="alert">
        Пожалуйста, подтвердите Ваш пароль перед тем, как продолжить.
    </div>
    <div class="card border-primary">
        <div class="card-body">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label for="password" class="font-weight-bold">
                        Пароль: <span class="text-danger">*</span>
                    </label>
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Подтвердить
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Забыли пароль?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
