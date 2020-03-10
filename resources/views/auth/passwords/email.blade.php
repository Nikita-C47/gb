@extends('layouts.app')

@section('title', 'Сбросить пароль')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="alert alert-info" role="alert">
        Для сброса пароля, введите свой email в форму ниже.
    </div>
    <div class="card border-primary">
        <div class="card-body">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="font-weight-bold">
                        Email: <span class="text-danger">*</span>
                    </label>
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Сбросить пароль
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
