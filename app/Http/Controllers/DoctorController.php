<?php

namespace App\Http\Controllers;

use App\Helpers\CheckDoctorsTimes;
use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\RayRequest;
use App\Models\ClinicDoctor;
use Illuminate\Http\Request;
use App\Models\MedicalTestRequest;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    use CheckDoctorsTimes;

    /**
     * Update clinic's work time.
     */
    public function updateWorkTimes(Request $request)
    {
        $requestArray = $request->except('_token', '_method');
        if (empty($requestArray)) {
            error(__('flashes.noData'));
            return back();
        }
        foreach ($requestArray as $key => $value) {
            $rules[$key] = 'nullable|date_format:g:i A';
        }

        $validator = Validator::make($requestArray, $rules);
        $timesAreFine = $this->isEndTimeAfterStartTime($requestArray);

        if ($validator->fails() || !$timesAreFine) {
            error(__('doctor.wrongTimeFormat'));
            return back();
        }
        $user = auth()->user();
        foreach ($requestArray as $key => $value):
            $arr = explode(':', $key);
            $clinicId = $arr[0];
            $column = $arr[1];
            $day = $arr[2];
            $value = is_null($value) ? $value : Carbon::parse($value)->format('G:i:s'); // To prevent converting null values to current time.
            if ($user->clinics->pluck('id')->contains($clinicId)) {
                ClinicDoctor::updateOrCreate(
                    ['doctor_id' => $user->id, 'clinic_id' => $clinicId, 'day_name' => $day],
                    [$column => $value]
                );
            }
            // Delete records with day_name = null or (shift_start_time and shift_end_time) = null.
            $recordsWithNulls = ClinicDoctor::where([ ['doctor_id', '=', $user->id], ['clinic_id', '=', $clinicId] ])
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
        return redirect()->route('user.profile');
    }

    /**
     * Update clinic's work time.
     */
    /* public function updateWorkTimes(Request $request)
    {
        /* request array
            "1:shift_start_time" => "3:30 PM"
            "1:shift_end_time" => "5:30 PM"
            "2:shift_start_time" => "2:00 PM"
            "2:shift_end_time" => "4:30 PM"
        *//*
        $user = auth()->user();
        $clinicsIds = $user->clinics->pluck('id');

        // Creating the rules and names arrays for validation.
        foreach ($clinicsIds as $id) {
            $rules[$id . ':shift_start_time'] = 'required|date_format:g:i A';
            $rules[$id . ':shift_end_time'] = 'required|date_format:g:i A';
            $niceNames[$id.':shift_start_time'] = __('doctor.shift_start_time_for_clinic') .' '. Clinic::find($id)->name;
            $niceNames[$id.':shift_end_time'] = __('doctor.shift_end_time_for_clinic') .' '. Clinic::find($id)->name;
        }
        /* rules array
            "1:shift_start_time" => "required|date_format:A g:i"
            "1:shift_end_time" => "required|date_format:A g:i"
            "2:shift_start_time" => "required|date_format:A g:i"
            "2:shift_end_time" => "required|date_format:A g:i"
        *//*

        $data = $request->validate($rules, [], $niceNames);

        foreach ($data as $key => $value) {
            $arr = explode(':', $key);
            $clinicId = $arr[0];
            $column = $arr[1];
            $value = Carbon::parse($value)->format('G:i:s');
            $user->clinics()->updateExistingPivot($clinicId, [$column => $value]);
        }

        success(__('flashes.update'));
        return redirect()->route('user.profile');
    } */

    /**
     * Displaying the waiting list.
     */
    public function waitingList()
    {
        /* return view('patients.index', [
            'patients' => auth()->user()->patients()->opened()->paginate(10)
        ]); */
        return view('reservations.index', [
            'items' => auth()->user()->reservations()->waiting()->with(['patient', 'doctor', 'clinic'])->paginate(10)
        ]);
    }

    /**
     * Displaying the requested rays.
     */
    public function raysRequests()
    {
        $items = RayRequest::where('doctor_id', auth()->id())->latest()->paginate(10);
        return view('raysRequests.index', compact('items'));
    }

    /**
     * Delete a rays request.
     */
    public function destroyRaysRequest(RayRequest $rayRequest)
    {
        if (request()->routeIs('admin.*') || auth()->id() === $rayRequest->doctor_id) {
            optional($rayRequest->file)->deleteFromUploads();
            optional($rayRequest->file)->delete();
            $rayRequest->delete();
            success(__('flashes.destroy'));
        }else {
            error(__('flashes.error'));
        }
        return back();
    }

    /**
     * Displaying the requested tests.
     */
    public function testsRequests()
    {
        $items = MedicalTestRequest::where('doctor_id', auth()->id())->latest()->paginate(10);
        return view('medicalTestsRequests.index', compact('items'));
    }

    /**
     * Delete a test request.
     */
    public function destroyTestRequest(MedicalTestRequest $testRequest)
    {
        if (request()->routeIs('admin.*') || auth()->id() === $testRequest->doctor_id) {
            optional($testRequest->file)->deleteFromUploads();
            optional($testRequest->file)->delete();
            $testRequest->delete();
            success(__('flashes.destroy'));
        }else {
            error(__('flashes.error'));
        }
        return back();
    }
}
