@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
        <div class="row">
            <div class="col-6 offset-3 d-flex justify-content-between" style="background-color: white; background-clip: content-box;">
                <div class="d-flex ml-3 mt-2 mb-2">
                    <div>
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 p-2 mr-2" style="max-width: 50px">
                    </div>
                    <div class="font-weight-bold d-flex align-items-center">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center mr-3">
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

        <div class="row pb-4">
            <div class="col-6 offset-3" style="background-color: white; background-clip: content-box;">
                <div class="mt-3 ml-3 d-flex">
                    <div class="mr-4">
                        <form action="{{ route('like', array('post' => $post->id)) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @if( (auth()->user()) && auth()->user()->likes->contains('user_id', $post->id) )
                                <input type="image"
                                       src="svg/ig_like2.png"
                                       name="like"
                                       id="like"
                                       style="max-width: 24px"/>
                            @else
                                <input type="image"
                                       src="svg/ig_like1.png"
                                       name="like"
                                       id="like"
                                       style="max-width: 24px"/>
                            @endif
                        </form>
                    </div>

                    <div class="mr-4">
                        <form action="/p/{{ $post->id }}" enctype="multipart/form-data" method="get">
                            @csrf
                            <input type="image"
                                   src="svg/ig_comment.png"
                                   style="max-width: 24px"/>
                        </form>
                    </div>
                </div>

                <div class="mt-2 mb-1 ml-3">
                    <a href="/p/{{$post->id}}/likes" style="color: inherit; text-decoration: inherit">
                        <strong>
                            <span class="font-weight-bold">
                                {{ $post->liked->count() }} likes
                            </span>
                        </strong>
                    </a>
                </div>

                <div class="mt-2 mb-1 ml-3">
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span> {{ $post->caption }}
                </div>

                @if($post->comments->count() > 2)
                    <div class="mb-2 mt-2 ml-3">
                        <a style="color: gray" href="/p/{{ $post->id }}">View all {{ $post->comments->count() }} comments</a>
                    </div>
                @endif

                <?php $i = 0; ?>
                @foreach($post->comments as $comment)
                    @if($i < 2)
                        <div class="mb-1 ml-3">
                            <span class="font-weight-bold">
                                <a href="/profile/{{ $comment->user->username }}">
                                    <span class="text-dark">{{ $comment->user->username }}</span>
                                </a>
                            </span> {{ $comment->comment }}
                        </div>
                    @else
                        @break
                    @endif
                    <?php $i++; ?>
                @endforeach

                <div class="ml-3 mt-1 mb-1">
                    <span style="color: #565E64; font-size: smaller">
                        {{ strtoupper($post->created_at->isoFormat('MMMM D, Y')) }}
                    </span>
                </div>
                <div>
                    <hr class="mb-1">

                    <form action="{{ route('comment.store', array('post' => $post->id)) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group d-flex mr-3 ml-3 mb-2 mt-2">
                            <input type="text"
                                   class="form-control border-0 p-0"
                                   id="comment"
                                   name="comment"
                                   placeholder="Add a comment...">
                            <button type="submit" class="btn font-weight-bold" style="color: #007BFF">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
