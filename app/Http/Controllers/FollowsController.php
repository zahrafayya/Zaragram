<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $url = url()->previous();

        auth()->user()->following()->toggle($user->profile);

        return redirect($url);
    }

    public function get_following($username)
    {
        $id = User::select('id')->where('username', $username)->first();
        $user = User::findOrFail($id)->first();

        $followings = $user->following()->pluck('profiles.user_id');

        $prof_fol = Profile::whereIn('user_id', $followings)->with('user')->get();

        return view('profiles.following', compact('user', 'prof_fol'));
    }

    public function get_followers($username)
    {
        $id = User::select('id')->where('username', $username)->first();
        $user = User::findOrFail($id)->first();

        $followers = DB::table('profile_user')->where('profile_id', $user->profile->id)->pluck('user_id');

        $prof_fol = User::whereIn('id', $followers)->get();

        return view('profiles.followers', compact('user', 'prof_fol'));
    }
}
