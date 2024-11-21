<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return[
           new Middleware('permission:view user', only : ['index']),
           new Middleware('permission:create user', only : ['create','store']),
           new Middleware('permission:update user', only : ['update','edit']),
           new Middleware('permission:delete user', only : ['destroy']),
        ];
    }
   
 
    public function index(){

    $users = User::all();
        return view("Action.user.index", [
            "users" => $users
            ]);
    }

    public function create(){   
        $roles = Role::pluck('name', 'name')->all();
        return view("Action.user.create",[
            "roles"=> $roles
        ]);
    }

    

    public function store(Request $request){
        $request->validate([
            "name"=> "required",
            "email" => "required",
            "roles" => "required"]

            );
        $user = User::create([
            "name" => $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password),
        ]);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status','User Created Successfully');

}

public function edit(User $user){

    $roles = Role::pluck('name', 'name')->all();
    $userRoles = $user->roles->pluck('name', 'name')->all();

    return view('Action.user.edit',[
        'user' => $user,
        'roles'=> $roles,
        'userRoles' => $userRoles,
        
        ]); 
}
public function update(Request $request, User $user){
    $request->validate([
        "name"=> "required",
        "email" => "required",
        "roles" => "required"]
        );

        $data =[
            'name' => $request->name,
            'email'=> $request->email,
        ];

        $user->update($data);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status','User Updated Successfully');

}

public function destroy($userId){
    $user = User::find( $userId );
    $user->delete();
    return redirect("/users")->with("status","User has been Deleted ");
}



}