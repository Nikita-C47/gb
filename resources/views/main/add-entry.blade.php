@extends('layouts.app')

@section('title', 'Добавить запись')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="card border-primary">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf
                @guest
                <div class="form-group">
                    <label class="font-weight-bold" for="author">
                        Ваше имя: <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('author') is-invalid @enderror"
                           value="{{ old('author') }}"
                           required
                           autocomplete="author"
                           autofocus
                           name="author"
                           id="author" />
                    @error('author')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                @endguest
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
                              name="content">{{ old('content') }}</textarea>
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
                @guest
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ config('app.google_recaptcha.key') }}"></div>
                    @error('g-recaptcha-response')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                @endguest
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Добавить запись
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @guest
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endguest
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
