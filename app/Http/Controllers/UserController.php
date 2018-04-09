<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChangelogResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);
        $data = User::paginate();
        if($request->is('api*')){
            return new UserCollection($data);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        $this->authorize('view', $user);
        if($request->is('api*')){
            return new UserResource($user);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {
        //
    }

    public function employee(User $user, Request $request){
        $this->authorize('view', $user);
        if($request->is('api*')){
            return new EmployeeResource($user->Employee_Record);
        }
    }

    public function current(Request $request){
        if($request->is('api*')){
            return new UserResource($request->user());
        }
    }

    public function changelog(User $user, Request $request){
        return ChangelogResource::collection($user->audits()->paginate());
    }
}
