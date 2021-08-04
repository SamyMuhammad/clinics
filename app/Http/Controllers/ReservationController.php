<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\ClinicDoctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\ReservationRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    const WEEK_DAYS = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    /**
     * List all the reservations.
     */
    public function index()
    {
        return view('reservations.index', [
            'items' => Reservation::with(['patient', 'doctor', 'clinic'])->paginate(10)
        ]);
    }

    /**
     * Show the reservation Form.
     */
    public function showForm(Patient $patient)
    {
        $items = $patient->reservations()->orderBy('date')->paginate(10);
        return view('patients.reservation', compact('patient', 'items'));
    }

    /**
     * Get the doctor's times in certain day.
     */
    public function getDoctorTimes(Request $request)
    {
        $validator = $this->doctorTimesValidator($request);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => __('flashes.error')]);
        }

        $dayName = static::WEEK_DAYS[$request->day_number];
        $doctorId = $request->doctor_id;
        // Fetching all doctor's times.
        $allDoctorTimes = ClinicDoctor::where([['doctor_id', '=', $doctorId], ['day_name', '=', $dayName]])->with('clinic')->get();
        if ($allDoctorTimes->isEmpty()) return response()->json(['status' => false, 'msg' => __('flashes.error')]);
        
        # In case there is no returned records.
        // Grouping Times By clinic name.
        foreach ($allDoctorTimes->groupBy('clinic_id') as $key => $value):
            foreach ($value as $item): // $value is a collection.
                $clinic = Clinic::find($key);
                $availableTimes[$clinic->name]['id'] = $clinic->id;
                $availableTimes[$clinic->name]['times'] = $item->workTimeSlots;
            endforeach;
        endforeach;

        $existedReservations = Reservation::where('doctor_id', $doctorId)
            ->where('date', $request->date)
            ->waiting()
        ->get();

        # In case there is any reservation.
        if ($existedReservations->count() > 0):
            foreach ($allDoctorTimes as $record):
                // Existed reservations by clinic times.
                $existedExaminations = $existedReservations
                ->where('clinic_id', $record->clinic_id)
                ->whereBetween('time', [$record->shift_start_time, $record->shift_end_time]);
                
                // Removing the reserved times from the available Times;
                foreach ($existedExaminations as $item) {
                    $time = $item->timeInFormat;
                    
                    if (in_array($time, $availableTimes[$record->clinic->name]['times'])) {
                        $offset = array_search($time, $availableTimes[$record->clinic->name]['times']);
                        unset($availableTimes[$record->clinic->name]['times'][$offset]);
                        $availableTimes[$record->clinic->name]['times'] = array_values($availableTimes[$record->clinic->name]['times']);

                        // Removing all the clinic group if there is no available times.
                        if (count($availableTimes[$record->clinic->name]['times']) == 0) {
                            unset($availableTimes[$record->clinic->name]);
                        }
                    }
                }
            endforeach;
        endif;

        return count($availableTimes) > 0 
        ? response()->json(['status' => true, 'content' => $availableTimes])
        : response()->json(['status' => false, 'msg' => __('reservations.noAvailableTime')]);
    }

    private function doctorTimesValidator(Request $request)
    {
        return Validator::make($request->all(), [
            'day_number' => 'required|integer|between:0,6',
            'doctor_id' => ['required', Rule::exists('users', 'id')->where(function ($query) {
                return $query->where('job', 'doctor');
            })],
            'date' => ['required', 'date_format:Y-m-d'],
        ]);
    }

    /**
     * Store a reservation to the database.
     */
    public function store(ReservationRequest $request)
    {
        $validator = $this->validateClinicAndTime($request->reservation_time);
        if ($validator->fails()) {
            return back()->withError(__('flashes.error'));
        }

        $data = $validator->validated() + $request->except('reservation_time', '_token'); // merging the two arrays.

        $data['date'] = Carbon::parse($data['date'])->format('Y-m-d');
        $data['time'] = Carbon::parse($data['time'])->format('H:i:s');
        Reservation::create($data);

        success(__('flashes.store'));
        return redirect()->route('patient.index');
    }

    /**
     * Validating clinic id and the time.
     */
    private function validateClinicAndTime(string $clinic_and_time)
    {
        list($clinicId, $time) = explode('|', $clinic_and_time);

        $data = ['clinic_id' => $clinicId, 'time' => $time];
        $rules = ['clinic_id' => 'exists:clinics,id', 'time' => 'date_format:g:i A'];

        return validator($data, $rules);
    }

    /**
     * Destroy a reservation
     * 
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        success(__('flashes.destroy'));
        return back();
    }

    public function changeStatus(Request $request)
    {
        $validator = validator($request->all(), [
            'reservation_id' => ['required', 'exists:reservations,id'],
            'status' => ['required', Rule::in(Reservation::getEnumValues('status'))],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => __('flashes.error')]);
        }

        $reservation = Reservation::find($request->reservation_id);
        $reservation->update(['status' => $request->status]);
        return response()->json(['status' => true, 'msg' => __('reservations.status.changeDone')]);
    }

    public function search(Request $request)
    {
        $query = $request->key;
        if(empty($query)) return redirect()->route('admin.reservation.index');

        $items = Reservation::whereHas('patient', function(Builder $q) use ($query){
            $q->where('ar_name', 'like', "%$query%")
            ->orWhere('en_name', 'like', "%$query%");
        })
        ->orWhereHas('clinic', function(Builder $q) use ($query){
            $q->where('ar_name', 'like', "%$query%")
            ->orWhere('en_name', 'like', "%$query%");
        })
        ->orWhereHas('doctor', function(Builder $q) use ($query){
            $q->where('name', 'like', "%$query%");
        });

        if (mb_detect_encoding($query) === 'UTF-8') { // If input is arabic.
            $statusByArabicKeys = [
                'انتظار' => 'waiting',
                'ملغي' => 'canceled',
                'متغيب' => 'absence',
                'منتهي' => 'dones'
            ];

            if (array_key_exists($query, $statusByArabicKeys))
            $items->orWhere('status', $statusByArabicKeys[$query]);

        }else{
            $items->orWhereDate('date', 'like', "%$query%")
            ->orWhereTime('time', 'like', "%$query%"); 
        }
        
        $items = $items->paginate(10);
        return view('reservations.index', compact('items'));
    }
}
