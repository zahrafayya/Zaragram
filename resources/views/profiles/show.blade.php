@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center">
                    <h4>{{ $user->username }}</h4>
                    @cannot('update', $user->profile)
                    <form class="form-horizontal" action="{{route('follow', array('user' => $user->id))}}" method="POST">
                        @csrf
                        @if( $follows === false )
                            <button class="btn btn-primary ml-4" name="follow" value="following">Follow</button>
                        @else
                            <button class="btn btn-outline-dark ml-4" name="follow" value="following">Unfollow</button>
                        @endif
                    </form>
                    @endcannot
                    @can('update', $user->profile)
                        <a class="btn btn-outline-dark ml-4" href="/profile/{{ $user->profile->id }}/edit">Edit Profile</a>
                    @endcan
                </div>
                @can('update', $user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan
            </div>

            <div class="d-flex pt-3">
                <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="https://www.freecodecamp.org/">{{ $user->profile->url }}</a></div>
        </div>
    </div>
    <div class="row pt-5">
    <?php $i = 0; ?>
    @foreach($user->posts as $post)
        @if($i % 3 == 0 && $i != 0)
        </div>
        <div class="row pt-5">
        @endif
            <div class="col-4">
                <a href="/p/{{ $post->id }}">
                    <img class="w-100" src="/storage/{{ $post->image }}">
                </a>
            </div>
        <?php $i++; ?>
    @endforeach
    </div>
</div>
@endsection
