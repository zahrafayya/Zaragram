@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4">
            <div class="d-flex align-items-center">
                <div>
                    <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100 pr-3" style="max-width: 50px">
                </div>
                <div>
                    <div class="font-weight-bold d-flex align-items-center">
                        <a href="/profile/{{ $post->user->username }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                        @cannot('update', $post->user->profile)
                        <form class="form-horizontal" action="{{route('follow', array('user' => $post->user->id))}}" method="POST">
                        @csrf
                        @if( $follows === false )
                            <button class="btn btn-link ml-3 p-0 m-0" name="follow" value="following">Follow</button>
                        @else
                            <button class="btn btn-link ml-3 p-0 m-0" style="color: #565E64" name="follow" value="following">Unfollow</button>
                        @endif
                        </form>
                        @endcannot
                    </div>
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
