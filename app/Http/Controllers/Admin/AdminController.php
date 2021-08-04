<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view admins')->only('index');
        $this->middleware('can:show admins')->only('show');
        $this->middleware('can:create admins')->only(['create', 'store']);
        $this->middleware('can:edit admins')->only(['edit', 'update']);
        $this->middleware('can:delete admins')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.admins.index')->with('admins', $admins);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create')->with('roles', Role::where('guard_name', 'admin')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $data = $request->except(['password', 'photo']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        try {
            DB::transaction(function () use($request, $data) {
                if ($request->hasFile('photo')) {
                    $name = storeFile('photo', 'admins/images');
                    $data['photo'] = $name;
                }
                $admin = Admin::create($data);
                $admin->syncRoles($data['roles']);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.admin.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->except(['password', 'photo']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        try {
            DB::transaction(function () use($request, $admin, $data) {
                if ($request->hasFile('photo')) {
                    $name = storeFile('photo', 'admins/images');
                    $data['photo'] = $name;
                    $admin->deletePhotoFromUploads();
                }
                $admin->update($data);
                $admin->syncRoles($data['roles']);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        try {
            DB::transaction(function () use ($admin) {
                $admin->deletePhotoFromUploads();
                $admin->delete();
                success(__('flashes.destroy'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.admin.index');
    }
}
