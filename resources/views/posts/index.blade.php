@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
        <div class="row pb-3">
            <div class="col-6 offset-3 d-flex justify-content-between">
                <div class="d-flex">
                    <div>
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 p-2 mr-2" style="max-width: 50px">
                    </div>
                    <div class="font-weight-bold d-flex align-items-center">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <a class="nav-link dropdown-toggle" style="color: #565E64" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @can('update', $post->user->profile)
                            <a class="dropdown-item" href="{{ route('post.edit', array('post' => $post->id)) }}">
                                {{ __('Edit Post') }}
                            </a>
                            <form action="/p/{{ $post->id }}" enctype="multipart/form-data" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item" href="{{ route('post.destroy', array('post' => $post->id)) }}">
                                    {{ __('Delete Post') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 offset-3">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
        </div>

        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <p>
                <span class="font-weight-bold">
                    <a href="/profile/{{ $post->user->username }}">
                        <span class="text-dark">{{ $post->user->username }}</span>
                    </a>
                </span> {{ $post->caption }}
                </p>
            </div>
        </div>
    @endforeach
</div>
@endsection
