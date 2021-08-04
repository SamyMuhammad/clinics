<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\DoctorData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DoctorDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view reservations')->only('reservations');
    }

    public function create(User $user)
    {
        $check = $this->check($user, 'create');
        if ($check !== true){ return $check; }
        
        return view('admin.doctors.createData', [
            'item' => $user
        ]);
    }

    public function store(Request $request, User $user)
    {
        $check = $this->check($user, 'create');
        if ($check !== true){ return $check; }

        $data = $this->validator($request);
        $data['doctor_id'] = $user->id;
        try {
            DB::transaction(function () use ($data) {
                DoctorData::create($data);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.user.index');
    }

    public function edit(User $user)
    {
        $check = $this->check($user, 'update');
        if ($check !== true){ return $check; }

        return view('admin.doctors.editData', [
            'item' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $check = $this->check($user, 'update');
        if ($check !== true){ return $check; }

        $data = $this->validator($request);
        $doctorId = $user->id;
        try {
            DB::transaction(function () use ($data, $doctorId) {
                DoctorData::updateOrCreate(['doctor_id' => $doctorId], $data);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.user.index');
    }

    /**
     * Check if the user is a doctor or if he already has data.
     */
    private function check($user, $method = 'create')
    {
        if ($method === 'update') {
            if ($user->job !== 'doctor') {
                error(__('flashes.error'));
                return redirect()->route('admin.user.index');
            }
        }else{
            if ($user->job !== 'doctor' || !empty(DoctorData::findByDoctorId($user->id))) {
                error(__('flashes.error'));
                return redirect()->route('admin.user.index');
            }
        }

        return true;
    }

    private function validator(Request $request)
    {
        $data = $request->validate([
            'specialization' => 'required|string|min:3'
        ]);
        return $data;
    }

    /**
     * Get the doctor reservations.
     */
    public function reservations(User $user)
    {
        return view('reservations.index', [
            'items' => $user->reservations()->with(['patient', 'doctor', 'clinic'])->paginate(10)
        ]);
    }
}
