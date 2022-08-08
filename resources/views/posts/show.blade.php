@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4">
            <div class="d-flex align-items-center ">
                <div>
                    <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 p-2 mr-2" style="max-width: 50px">
                </div>
                <div class="font-weight-bold d-flex align-items-center mr-3">
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
                            <button class="btn btn-link p-0 m-0" name="follow" value="following">Follow</button>
                        @else
                            <button class="btn btn-link p-0 m-0" style="color: #565E64" name="follow" value="following">Unfollow</button>
                        @endif
                        </form>
                        @endcannot
                    </div>
                    @can('update', $post->user->profile)
                    <div class="d-flex align-items-center">
                        <a class="nav-link dropdown-toggle" style="color: #565E64" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('post.edit', array('post' => $post->id)) }}">
                                {{ __('Edit Post') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.show', array('username' => Auth::user()->username )) }}">
                                {{ __('Delete Post') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>

            <hr>

            <p>
                <span class="font-weight-bold">
                    <a href="/profile/{{ $post->user->username }}">
                        <span class="text-dark">{{ $post->user->username }}</span>
                    </a>
                </span> {{ $post->caption }}
            </p>
        </div>
    </div>
</div>
@endsection
