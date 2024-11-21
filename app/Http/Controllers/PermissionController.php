<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller 
{




    public function index(){
        $permissions = Permission::get();
        return view("Action.permission.index",[
            'permissions' => $permissions,
        ]);
    }

    public function create(){
        return view("Action.permission.create");
    }

    public function store(Request $request){
        $request->validate([
          "name"=> "required","unique:permissions,name"
        ]);
  
        Permission::create([
          "name" => $request->name
        ]);
        return redirect("permissions")->with("status","Permission has been added");
      }

      public function edit(Permission $permission){
        return view('Action.permission.edit', [
            'permission' => $permission
        ]);
        
    }

    public function update(Request $request, Permission $permission){

        $request->validate([
            'name'=> ['required', 'string', 'unique:permissions,name,' .$permission->id ]
        ]);

        $permission->update([
            "name" => $request->name
            
          ]);
          return redirect("permissions")->with("status","Permission has been Updated");

        
    }

    public function destroy($permissionId){
        $permission = Permission::find( $permissionId );
        $permission->delete();
        return redirect("permissions")->with("status","Permission has been Deleted ");
        
    }
   
}


