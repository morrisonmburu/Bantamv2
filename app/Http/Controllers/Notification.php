<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\User;
use Illuminate\Http\Request;

class Notification extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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


    // All notifications
    public function UserNotifications (User $user, Request $request){
        if ($request->is('api*')){
            return new NotificationResource($user->notifications);
        }
    }

    // Unread notifications
    public function UnreadNotifications (User $user, Request $request){
        if ($request->is('api*')){
            return new NotificationResource($user->unreadNotifications );
        }
    }

    //Read notifications
    public function ReadNotifications (User $user, Request $request){
        if ($request->is('api*')){
            return new NotificationResource($user->readNotifications);
        }
    }
}
