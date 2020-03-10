@extends('layouts.app')

@section('title', 'Подтверждение email')

@section('content')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Новая ссылка для подтверждения была отправлена на ваш email адрес.
        </div>
    @endif
    <div class="card border-primary">
        <div class="card-body">
            Перед тем как продолжить, пожалуйста проверьте Ваш почтовый ящик. Мы выслали туда ссылку подтверждения.
            Если Вы не получили ссылку,
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите, чтобы запросить ещё</button>.
            </form>
        </div>
    </div>
@endsection
