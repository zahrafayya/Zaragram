@extends('layouts.app')

@section('content')
    <div class="container w-50">
        <h4 class="pb-2">
            Followers of {{ $user->username }}
        </h4>
        @foreach($prof_fol as $usr_fol)
            <div class="row-4 d-flex mt-4">
                <div class="mr-3">
                    <img src="{{ $usr_fol->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 60px">
                </div>

                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="ml-2">
                        <div>
                            <a href="/profile/{{ $usr_fol->username }}">
                                <p class="font-weight-bold text-dark m-0">{{ $usr_fol->username }}</p>
                            </a>
                        </div>
                        <div>
                            <p class="m-0" style="color: gray">{{ $usr_fol->profile->title }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        @cannot('update', $usr_fol->profile)
                        <form class="form-horizontal" action="{{route('follow', array('user' => $usr_fol->id))}}" method="POST">
                            @csrf
                            @if((auth()->user()) && auth()->user()->following->contains('user_id', $usr_fol->id))
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
