@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="/svg/FCCProfilePicture.svg" class="rounded-circle" style="max-height: 160px">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->username }}</h1>
                <a href="/p/create">Add New Post</a>
            </div>
            <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="pr-5"><strong>104K</strong> followers</div>
                <div class="pr-5"><strong>356</strong> following</div>
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
