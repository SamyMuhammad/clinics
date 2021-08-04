<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view users')->only(['index', 'usersByJob']);
        $this->middleware('can:show users')->only('show');
        $this->middleware('can:create users')->only(['create', 'store']);
        $this->middleware('can:edit users')->only(['edit', 'update']);
        $this->middleware('can:delete users')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();
        $jobs = User::getEnumValues('job');
        return view('admin.users.create', compact('roles', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->except(['password', 'photo']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        try {
            $user = DB::transaction(function () use($request, $data) {
                if ($request->hasFile('photo')) {
                    $name = storeFile('photo', 'users/images');
                    $data['photo'] = $name;
                }
                $user = User::create($data);
                if($request->filled('roles')) $user->syncRoles($data['roles']);
                return $user;
            });
            return $this->redirectByJob($user);
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $jobs = User::getEnumValues('job');
        return view('admin.users.edit', compact('user', 'roles', 'jobs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->except(['password', 'photo']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        try {
            DB::transaction(function () use($request, $user, $data) {
                if ($request->hasFile('photo')) {
                    $name = storeFile('photo', 'users/images');
                    $data['photo'] = $name;
                    $user->deletePhotoFromUploads();
                }
                $user->update($data);
                if($request->filled('roles')) $user->syncRoles($data['roles']);
            });
            return $this->redirectByJob($user, 'update');
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->deletePhotoFromUploads();
                $user->delete();
                success(__('flashes.destroy'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.user.index');
    }

    /**
     * Redirect depending on job to complete data.
     */
    private function redirectByJob($user, $method = 'store')
    {
        switch ($user->job) {
            case 'doctor':
                if ($method === 'update') {
                    return redirect()->route('admin.doctorData.edit', $user->id);
                }else{
                    return redirect()->route('admin.doctorData.create', $user->id);
                }
            break;
            
            default:
                success(__('flashes.store'));
                return redirect()->route('admin.user.index');
            break;
        }
    }

    /**
     * Get subgroup of users depending on their job.
     * 
     * @param String $job
     */
    public function usersByJob(String $job)
    {
        if (! in_array($job, ['doctors', 'technicians', 'tests-doctors'])) {
            error(__('flashes.error'));
            return back();
        }

        $realJobsNames = [
            'doctors' => 'doctor',
            'technicians' => 'ray_technician',
            'tests-doctors' => 'test_responsible',
        ];

        $users = User::where('job', $realJobsNames[$job])->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
