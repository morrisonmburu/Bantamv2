<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notification extends Controller
{
    // all user notifications
    public function index(Request $request)
    {
        if ($request->is('api*')){
            $user= User::find(Auth::user()->id);
            return new NotificationResource($user->notifications);
        }
    }
    public function update(Request $request)
    {
        if ($request->is('api*')){
            $user= User::find(Auth::user()->id);
            try{
                $user->unreadNotifications->markAsRead();
                return response("Success",200);
            }catch (\Exception $e){
                return response("Error !".$e->getMessage(),500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    // Unread notifications
    public function UnreadNotifications (Request $request){
        if ($request->is('api*')){
            $user= User::find(Auth::user()->id);
            return new NotificationResource($user->unreadNotifications );
        }
    }

    //Read notifications
    public function ReadNotifications (Request $request){
        if ($request->is('api*')){
            $user= User::find(Auth::user()->id);
            return new NotificationResource($user->readNotifications);
        }
    }
}
