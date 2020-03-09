@extends('layouts.app')

@section('title', 'Список записей')

@section('content')
    @if(count($entries) > 0)
        @foreach($entries as $entry)
            <div class="card mb-3 border-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $entry->title }}
                    </h5>
                    <p class="card-text">
                        {{ $entry->content }}
                    </p>
                </div>
                <div class="card-footer text-muted">
                    <div class="float-left">
                        {{ $entry->author }}, {{ $entry->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach
        {{ $entries->links() }}
    @else
        <div class="jumbotron">
            <h1 class="display-4">Добро пожаловать!</h1>
            <p class="lead">
                Приветствуем Вас в нашей гостевой книге.
            </p>
            <hr class="my-4">
            <p>
                Если Вам есть что сказать и чем поделиться, вы можете оставить здесь свои мысли.
                Судя по всему, еще не было добавлено ни одной записи. Вы можете быть первым!
            </p>
            <a class="btn btn-primary btn-lg" href="{{ route('add-entry') }}" role="button">Добавить запись</a>
        </div>
    @endif
@endsection
