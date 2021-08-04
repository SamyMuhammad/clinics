<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view roles')->only(['adminsRoles', 'usersRoles']);
        $this->middleware('can:show roles')->only('show');
        $this->middleware('can:create roles')->only(['createFor', 'create', 'store']);
        $this->middleware('can:edit roles')->only(['editFor', 'edit', 'update']);
        $this->middleware('can:delete roles')->only('destroy');
    }

    /**
     * Get the admins roles.
     */
    public function adminsRoles()
    {
        $roles = Role::where('guard_name', 'admin')->paginate(10);
        $permissions_count = Permission::where('guard_name', 'admin')->get()->count();
        return view('admin.roles.index', compact('roles', 'permissions_count'));
    }

    /**
     * Get the users roles.
     */
    public function usersRoles()
    {
        $roles = Role::where('guard_name', 'web')->paginate(10);
        $permissions_count = Permission::where('guard_name', 'web')->get()->count();
        return view('admin.roles.index', compact('roles', 'permissions_count'));
    }

    public function createFor($param)
    {
        $check = $this->checkGuards($param);
        if ($check !== true) { return $check; }

        $guard = ['admins' => 'admin', 'users' => 'web'][$param];
        return $this->create($guard);
    }

    private function create($guard)
    {
        $permissions = Permission::where('guard_name', $guard)->get();
        return view('admin.roles.create', compact('permissions', 'guard'));
    }

    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        
        try {
            DB::transaction(function () use ($data){
                $role = Role::create($data);
                $role->givePermissionTo($data['permissions']);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }

        $previousUrl = url()->previous();
        if ($previousUrl === route('admin.role.createFor', 'admins')) {
            return redirect()->route('admin.role.admins');
        }elseif ($previousUrl === route('admin.role.createFor', 'users')) {
            return redirect()->route('admin.role.users');
        }else{
            return back();
        }
    }

    public function show(Role $role)
    {
        return view('admin.roles.show')->with('role', $role);
    }

    public function editFor(Role $role, $param)
    {
        $check = $this->checkGuards($param);
        if ($check !== true) { return $check; }

        $guard = ['admins' => 'admin', 'users' => 'web'][$param];
        if ($role->guard_name !== $guard) {
            error(__('flashes.error'));
            return back();
        }
        return $this->edit($role, $guard);
    }

    private function edit($role, $guard)
    {
        $permissions = Permission::where('guard_name', $guard)->get();
        return view('admin.roles.edit', compact('role', 'permissions', 'guard'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->validated();
        
        try {
            DB::transaction(function () use ($role, $data){
                $role->update($data);
                $role->syncPermissions($data['permissions']);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        
        $previousUrl = url()->previous();
        if ($previousUrl === route('admin.role.editFor', ['role' => $role->id, 'param' => 'admins'])) {
            return redirect()->route('admin.role.admins');
        }elseif ($previousUrl === route('admin.role.editFor', ['role' => $role->id, 'param' => 'users'])) {
            return redirect()->route('admin.role.users');
        }else{
            return back();
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        success(__('flashes.destroy'));
        return back();
    }

    /**
     * Checking values for guard_name.
     * 
     * @param array $data
     */
    private function checkGuards($param)
    {
        if (! in_array($param, ['users', 'admins'])) {
            error(__('flashes.error'));
            return back()->withInput();
        }
        return true;
    }
}
