<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CheckDoctorsTimes;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\ClinicDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicRequest;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{
    use CheckDoctorsTimes;

    public function __construct()
    {
        $this->middleware('can:view clinics')->only('index');
        $this->middleware('can:show clinics')->only('show');
        $this->middleware('can:create clinics')->only(['create', 'store']);
        $this->middleware('can:edit clinics')->only(['edit', 'update']);
        $this->middleware('can:delete clinics')->only('destroy');
        $this->middleware('can:view reservations')->only('reservations');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Clinic::paginate(10);
        return view('admin.clinics.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clinics.create', [
            'doctors' => User::doctors()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClinicRequest $request)
    {
        $data = $request->validated();
        try {
            DB::transaction(function () use ($data) {
                $item = Clinic::create($data);
                if(array_key_exists('doctors', $data)) $item->doctors()->attach($data['doctors']);
                // $this->updateWorkTimes($item);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.clinic.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        return view('admin.clinics.show', ['item' => $clinic]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clinic $clinic)
    {
        return view('admin.clinics.edit', [
            'item' => $clinic,
            'doctors' => User::doctors()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicRequest $request, Clinic $clinic)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($clinic, $data) {
                $clinic->update($data);
                $data['doctors'] = $data['doctors'] ?? [];
                $clinic->doctors()->sync($data['doctors']);
                // $this->updateWorkTimes($clinic);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.clinic.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinic $clinic)
    {
        try {
            DB::transaction(function () use ($clinic) {
                $clinic->delete();
                success(__('flashes.destroy'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.clinic.index');
    }

    /**
     * Update the doctor's shift's time.
     */
    /* private function updateWorkTimes(Clinic $clinic)
    {
        /* request array
            "1:shift_start_time" => "1:05 PM"
            "1:shift_end_time" => "2:05 PM"
            "2:shift_start_time" => null
            "2:shift_end_time" => null
            "6:shift_start_time" => null
            "6:shift_end_time" => null
            "8:shift_start_time" => "3:00 PM"
            "8:shift_end_time" => "5:00 PM"
        *//*
        $doctorsIds = $clinic->doctors->pluck('id');

        // Creating rules and names arrays for validation.
        foreach ($doctorsIds as $id) {
            $rules[$id . ':shift_start_time'] = 'nullable|date_format:g:i A';
            $rules[$id . ':shift_end_time'] = 'nullable|date_format:g:i A';
            $niceNames[$id.':shift_start_time'] = "موعد بداية العمل للطبيب" .' '. User::find($id)->name;
            $niceNames[$id.':shift_end_time'] = "موعد نهاية العمل للطبيب" .' '. User::find($id)->name;
        }
        /* rules array
            "1:shift_start_time" => "nullable|date_format:A g:i"
            "1:shift_end_time" => "nullable|date_format:A g:i"
        *//*

        $data = request()->validate($rules, [], $niceNames);

        foreach ($data as $key => $value) {
            $arr = explode(':', $key);
            $doctorId = $arr[0];
            $column = $arr[1];
            $value = Carbon::parse($value)->format('G:i:s');
            @$clinic->doctors()->updateExistingPivot($doctorId, [$column => $value]); // @ to skip error in case $doctorId doesn't exist.
        }
        return true;
    } */

    /**
     * Show the form for editing the specified clinic doctors appointments.
     *
     * @param  Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function editAppointments(Clinic $clinic)
    {
        if ($clinic->doctors->count() < 1) {
            warning('لا يوجد أي أطباء مسجلين بهذه العيادة.');
            return back();
        }
        return view('admin.clinics.editAppointments', [
            'item' => $clinic,
            'doctors' => $clinic->doctors->unique(),
            'days' => ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']
        ]);
    }

    /**
     * Updating the specified clinic doctors appointments.
     */
    public function updateAppointments(Request $request, Clinic $clinic)
    {
        $requestArray = $request->except('_token', '_method');

        if (empty($requestArray)) {
            error('لم يتم إدخال أي بيانات.');
            return back();
        }
        foreach ($requestArray as $key => $value) {
            $rules[$key] = 'nullable|date_format:g:i A';
        }

        $validator = Validator::make($requestArray, $rules);
        $timesAreFine = $this->isEndTimeAfterStartTime($requestArray);

        if ($validator->fails() || !$timesAreFine) {
            error(' تأكد من أن الأوقات مدخلة بترتيب صحيح علي الصيغة "g:i A" وحاول مرة أخري.');
            return back();
        }

        foreach ($requestArray as $key => $value): // $key for instance >> 1:shift_start_time:tuesday
            $arr = explode(':', $key);
            $doctorId = $arr[0];
            $column = $arr[1];
            $day = $arr[2];
            $value = is_null($value) ? $value : Carbon::parse($value)->format('G:i:s');
            if ($clinic->doctors->pluck('id')->contains($doctorId)) {
                ClinicDoctor::updateOrCreate(
                    ['clinic_id' => $clinic->id, 'doctor_id' => $doctorId, 'day_name' => $day],
                    [$column => $value]
                );
            }

            // Delete records with day_name = null.
            $recordsWithNulls = ClinicDoctor::where([ ['doctor_id', '=', $doctorId], ['clinic_id', '=', $clinic->id] ])
            ->where(function ($query){
                $query->where('day_name', null)->orWhere(function ($query){
                    $query->where('shift_start_time', null)->where('shift_end_time', null);
                });
            })->get();

            foreach ($recordsWithNulls as $record) {
                $record->delete();
            }
        endforeach;
        success(__('flashes.store'));
        return redirect()->route('admin.clinic.index');
    }

    /**
     * Get the clinic reservations.
     */
    public function reservations(Clinic $clinic)
    {
        return view('reservations.index', [
            'items' => $clinic->reservations()->with(['patient', 'doctor', 'clinic'])->paginate(10)
        ]);
    }
}
