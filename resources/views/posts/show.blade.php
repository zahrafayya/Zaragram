@extends('layouts.app')

@section('content')
<div class="container" style="background-color: #ffffff">
    <div class="row">
        <div class="col-7">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-5 d-flex justify-content-between flex-column pl-2 pr-2">
            <div>
                <div class="d-flex align-items-center mt-2">
                    <div class="col-1 p-0">
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 mt-2" style="max-width: 32px">
                    </div>
                    <div class="font-weight-bold d-flex align-items-center ml-2 mr-5">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            @cannot('update', $post->user->profile)
                            <form class="form-horizontal" action="{{route('follow', array('user' => $post->user->id))}}" method="POST">
                            @csrf
                            @if( $follows === false )
                                <button class="btn btn-link p-0 m-0 font-weight-bold" name="follow" value="following">Follow</button>
                            @else
                                <button class="btn btn-link p-0 m-0 font-weight-bold" style="color: #565E64" name="follow" value="following">Unfollow</button>
                            @endif
                            </form>
                            @endcannot
                        </div>

                        <div class="d-flex align-items-center">
                            <a class="nav-link dropdown-toggle" style="color: #565E64" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @can('update', $post->user->profile)
                                <a class="dropdown-item" href="{{ route('post.edit', array('post' => $post->id)) }}">
                                    {{ __('Edit Post') }}
                                </a>
                                <form action="{{ route('post.destroy', array('post' => $post->id)) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item">
                                        {{ __('Delete Post') }}
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-2" style="margin-left: -23px; margin-right: -8px">

                <div class="d-flex align-items-center">
                    <div class="col-1 p-0">
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 mt-2" style="max-width: 32px">
                    </div>
                    <div class="font-weight-bold d-flex align-items-center ml-2 mr-2">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex align-items-center">{{ $post->caption }}</div>
                    </div>
                </div>

                <div>
                @foreach($post->comments as $comment)
                    <div class="d-flex align-items-center mt-1">
                        <div class="col-1 p-0">
                            <img src="{{ $comment->user->profile->profileImage() }}" class="rounded-circle w-100 mt-2" style="max-width: 32px">
                        </div>
                        <div class="font-weight-bold d-flex align-items-center ml-2 mr-2">
                            <a href="/profile/{{ $comment->user->username }}">
                                <span class="text-dark">{{ $comment->user->username }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between w-100">
                            <div class="d-flex align-items-center">{{ $comment->comment }}</div>
                            <div class="d-flex align-items-center">
                                <a class="nav-link dropdown-toggle" style="color: #565E64" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @can('update', $comment->user->profile)
                                        <form action={{ route('comment.delete', array('comment' => $comment->id)) }}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <div>
                <hr style="margin-left: -23px; margin-right: -8px">
                <div class="d-flex">
                    <div class="mr-4">
                        <form action="{{ route('like', array('post' => $post->id)) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @if( (auth()->user()) && auth()->user()->likes->contains('id', $post->id) )
                                <input type="image"
                                       src="/svg/ig_like2.png"
                                       name="like"
                                       id="like"
                                       style="max-height: 24px"/>
                            @else
                                <input type="image"
                                       src="/svg/ig_like1.png"
                                       name="like"
                                       id="like"
                                       style="max-height: 24px"/>
                            @endif
                        </form>
                    </div>

                    <div class="mr-4">
                        <form action="/p/{{ $post->id }}" enctype="multipart/form-data" method="get">
                            @csrf
                            <input type="image"
                                   src="/svg/ig_comment.png"
                                   style="max-width: 24px"/>
                        </form>
                    </div>
                </div>
                <div class="mt-1 mb-1">
                    <a href="/p/{{$post->id}}/likes" style="color: inherit; text-decoration: inherit">
                        <span class="font-weight-bold">
                            {{ $post->liked->count() }} likes
                        </span>
                    </a>
                </div>
                <div class="mt-1 mb-1">
                    <span style="color: #565E64; font-size: smaller">
                        {{ strtoupper($post->created_at->isoFormat('MMMM D, Y')) }}
                    </span>
                </div>
                <hr class="mb-2" style="margin-left: -23px; margin-right: -8px">
                <form action="{{ route('comment.store', array('post' => $post->id)) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group d-flex">
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
</div>
@endsection
