@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="col-8 offset-2">
            <div class="row">
                <h2>Edit Profile</h2>
            </div>

            <div class="row">
                <div class="d-flex flex-column">
                    <label for="image" class="col-form-label text-md-end">Profile Image</label>
                    <div class="col-6 p-0">
                        <img src="{{ $user->profile->profileImage() }}" class="w-100">
                    </div>
                </div>
                <input type="file" class="form-control" id="image" name="image">

                @error('image')
                <strong>{{ $message }}</strong>
                @enderror
            </div>

            <div class="row">
                <label for="title" class="col-form-label text-md-end">Title</label>

                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ old('title') ?? $user->profile->title }}"
                       autocomplete="caption" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
                @enderror
            </div>

            <div class="row">
                <label for="description" class="col-form-label text-md-end">Description</label>

                <input id="description"
                       type="text"
                       class="form-control @error('description') is-invalid @enderror"
                       name="description"
                       value="{{ old('description') ?? $user->profile->description }}"
                       autocomplete="caption" autofocus>

                @error('description')
                <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
                @enderror
            </div>

            <div class="row">
                <label for="url" class="col-form-label text-md-end">URL</label>

                <input id="url"
                       type="text"
                       class="form-control @error('url') is-invalid @enderror"
                       name="url"
                       value="{{ old('url') ?? $user->profile->url }}"
                       autocomplete="caption" autofocus>

                @error('url')
                <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
                @enderror
            </div>

            <div class="row pt-4">
                <button class="btn btn-primary">Save Profile</button>
            </div>
        </div>
    </form>
</div>
@endsection
