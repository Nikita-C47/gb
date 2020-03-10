@extends('layouts.app')

@section('title', 'Мои записи')

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
                    <div class="float-left">
                        Добавлена {{ $entry->created_at->diffForHumans() }}
                        <br>
                        Изменена {{ $entry->updated_at->diffForHumans() }}
                    </div>
                    <div class="float-right">
                        <a href="{{ route('edit-entry', ['id' => $entry->id]) }}" class="btn btn-primary">
                            Редактировать
                        </a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletionModal">
                            Удалить
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="deletionModal" tabindex="-1" role="dialog" aria-labelledby="deletionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deletionModalLabel">Подтверждение удаления</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <span class="text-danger">ВНИМАНИЕ!</span>
                                        <span>Вы действительно хотите удалить эту запись? Это действие необратимо!</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                        <form method="post" action="{{ route('delete-entry', ['id' => $entry->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $entries->links() }}
    @else
        <div class="alert alert-info" role="alert">
            Вы еще не добавляли записей. Нажмите <a href="{{ route('add-entry') }}">здесь</a>, чтобы добавить первую.
        </div>
    @endif
@endsection
