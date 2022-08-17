@extends('layouts.app')

@section('content')
<div class="container w-25">
    <h4 class="pb-2">
        Followed by {{ $user->username }}
    </h4>
    @foreach($prof_fol as $profile)
    <div class="row-4 d-flex mt-4">
        <div class="mr-3">
            <img src="{{ $profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 54px">
        </div>

        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="font-weight-bold ml-2 mr-5">
                <a href="/profile/{{ $profile->user->username }}">
                    <span class="text-dark">{{ $profile->user->username }}</span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                @cannot('update', $profile)
                <form class="form-horizontal" action="{{route('follow', array('user' => $profile->user->id))}}" method="POST">
                    @csrf
                    @if((auth()->user()) && auth()->user()->following->contains('user_id', $profile->user->id))
                        <button class="btn btn-outline-dark ml-4" name="follow" value="following">Following</button>
                    @else
                        <button class="btn btn-primary ml-4" name="follow" value="following">Follow</button>
                    @endif
                </form>
                @endcannot
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
