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
                    @if(count($entry->images) > 0)
                    <span class="text-primary">Прикрепленные изображения:</span>
                    <div class="d-lg-flex d-xl-flex align-items-end">
                        @foreach($entry->images as $image)
                            <a class="mr-1" href="{{ $image->link }}" data-lightbox="images-{{ $entry->id }}" data-title="{{ $image->original_name }}">
                                <img src="{{ $image->thumbnail_link }}" alt="{{ $image->original_name }}"/>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="card-footer text-muted">
                    {{ $entry->author }}, {{ $entry->updated_at->diffForHumans() }}
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
