<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * follow other user
     * @param Request $request
     * @return JsonResponse
     */
    public function follow(Request $request)
    {
        /**
         * check if user is followable:
         * -> user exist
         * -> not trying to follow self
         * -> not already followed
         * -> profile is public
         */

        // validate that users exist
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        // can't follow self
        if ($request->user_id == Auth::id()) {
            return response()->json([
                'error' => 'Can\'t follow yourself!',
            ]);

        }

        // can't follow a user twice


        // get user to follow
        $user_to_follow = User::where('id', $request->user_id)->first();


        // only follow users with public profile
        // account_type = public
        if ($user_to_follow->account_type == 1) {
            $followed = Follow::create([
                'user_id' => $request->user_id,
                'follower_id' => Auth::id(),
            ]);

            return response()->json([
                'user' => $followed->follower_id,
                'following' => $followed->user_id
            ]);
        } else {
            return response()->json([
                'message' => "This is private account. Needs users approval before you can follow.",
            ]);
        }
    }

    /**
     * get list of followers for an user
     */
    public function followers(Request $request)
    {
//        return $allUsersWithFollowers = User::with('followers')->get();

        $followers = Follow::with([
            'followers' => function ($query) {
                $query->select('id', 'name', 'user_name');
            }])
            ->where('user_id', '=', $request->user()->id)
            ->get()
            ->pluck('followers');

        return response()->json([
            'user' => $request->user()->id,
            'followers' => $followers,
        ]);
    }
}
