@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/p/{{ $post->id }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="col-8 offset-2">
            <div class="row mb-3">
                <h2>Edit Post</h2>
            </div>

            <div class="row mb-3">
                <img src="/storage/{{ $post->image }}" class="w-50">
            </div>

            <div class="row">
                <label for="caption" class="col-form-label text-md-end">Post Caption</label>

                <input id="caption"
                       type="text"
                       class="form-control @error('caption') is-invalid @enderror"
                       name="caption"
                       value="{{ old('caption') ?? $post->caption }}"
                       autocomplete="caption" autofocus>

                @error('caption')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>

            <div class="row pt-4">
                <button class="btn btn-primary">Save Post</button>
            </div>
        </div>
    </form>
</div>
@endsection
