@extends('layouts.app')

@section('title', 'Редактировать запись')

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="content" class="font-weight-bold">
                        Текст записи: <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              rows="6"
                              style="resize: none;"
                              id="content"
                              required
                              autocomplete="content"
                              name="content">{{ $entry->content }}</textarea>
                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">
                        Прикрепить файлы:
                    </label>
                    <div class="custom-file">
                        <input type="file"
                               class="custom-file-input"
                               multiple
                               name="images[]"
                               id="images">
                        <label class="custom-file-label" for="images" data-browse="Обзор">Выберите файлы</label>
                    </div>
                    @error('images')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                @if(count($entry->images) > 0)
                <div class="form-group">
                    <label class="font-weight-bold">
                        Открепить файлы:
                    </label>
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Удалить</th>
                                <th>Название</th>
                                <th>Предпросмотр</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entry->images as $image)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="image-{{ $image->id }}"
                                                   name="removed_images[]"
                                                   value="{{ $image->id }}">
                                            <label class="custom-control-label font-weight-normal" for="image-{{ $image->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ $image->link }}" data-lightbox="image-{{ $image->id }}">
                                            <img src="{{ $image->thumbnail_link }}" alt="{{ $image->original_name }}" />
                                        </a>
                                    </td>
                                    <td>
                                        {{ $image->original_name }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('removed_images')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
