<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Company;
use App\Models\Patient;
use App\Models\Discount;
use App\Models\RaysTypes;
use App\Models\RayRequest;
use App\Models\MedicalTest;
use Illuminate\Http\Request;
use App\Models\MedicalTestRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PatientRequest;

class PatientController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view patients')->only(['index', 'search']);
        $this->middleware('can:show patients')->only('show');
        $this->middleware('can:create patients')->only(['create', 'store']);
        $this->middleware('can:edit patients')->only(['edit', 'update']);
        $this->middleware('can:delete patients')->only('destroy');
        $this->middleware('can:view blocked patients')->only('blockedPatients');
        $this->middleware('can:view reservations')->only('reservations');
    }

    public function index()
    {
        return view('patients.index', [
            'patients' => Patient::notBlocked()->paginate(10),
            'title' => __('patients.patients')
        ]);
    }

    public function blockedPatients()
    {
        return view('patients.index', [
            'patients' => Patient::blocked()->paginate(10),
            'title' => __('patients.blockedPatients')
        ]);
    }

    public function emergencyPatients()
    {
        return view('patients.index', [
            'patients' => Patient::emergency()->paginate(10),
            'title' => __('patients.emergencyPatients')
        ]);
    }

    public function create()
    {
        return view('patients.create', [
            'doctors' => doctors()->get(),
            'companies' => Company::get(['id', 'ar_name', 'en_name']),
            'discounts' => Discount::all(),
            'rooms' => Room::notFull()->orderBy('floor_number')->get(['id', 'room_number', 'floor_number'])
        ]);
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validated();

        $check = $this->checkEnums($data);
        if ($check !== true) {return $check;}

        try {
            DB::transaction(function () use ($data) {
                $patient = Patient::create($data);
                $patient->doctors()->attach($data['doctors']);

                if (!empty($data['files'])) {
                    $patient->storeToUploads($data['files']);
                }
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            // throw $th;
            error(__('flashes.error'));
        }
        return $this->routeRedirect('patient.index');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', [
            'item' => $patient,
            'diagnoses' => $patient->diagnoses(),
            'raysTypes' => RaysTypes::all(),
            'medicalTests' => MedicalTest::all()
        ]);
    }

    public function diagnoses(Patient $patient)
    {
        return view('patients.diagnoses', [
            'item' => $patient,
            'diagnoses' => $patient->diagnoses(),
        ]);
    }

    /**
     * Change Patient Status.
     */
    public function changeStatus(Patient $patient)
    {
        if ($patient->doctors->pluck('id')->contains(auth()->id())){
            $patient->update(['status' => 'closed']);
        }
        success(__('flashes.update'));
        return back();
    }

    /**
     * Add Diagnose.
     */
    public function addDiagnose(Request $request, Patient $patient)
    {
        $request->validate(['diagnose' => 'required|string|min:5'], [], ['diagnose' => __('patients.diagnose')]);
        $doctor = auth()->user();
        $doctor->patients()->updateExistingPivot($patient->id, ['diagnose' => $request->diagnose]);

        success(__('flashes.store'));
        return back();
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', [
            'item' => $patient,
            'doctors' => doctors()->get(),
            'companies' => Company::get(['id', 'ar_name', 'en_name']),
            'discounts' => Discount::all(),
            'rooms' => Room::notFull()->orderBy('floor_number')->get(['id', 'room_number', 'floor_number'])
        ]);
    }

    public function update(patientRequest $request, Patient $patient)
    {
        $data = $request->validated();

        $check = $this->checkEnums($data);
        if ($check !== true) {return $check;}

        try {
            DB::transaction(function () use ($patient, $data) {
                $patient->update($data);
                $patient->doctors()->syncWithoutDetaching($data['doctors']);

                if (!empty($data['files'])) {
                    $patient->storeToUploads($data['files']);
                }
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }

        return $this->routeRedirect('patient.index');
    }

    public function destroy(Patient $patient)
    {
        $patient->deleteAllUploadedFiles();
        $patient->deleteAssociatedFiles(); // records from files table.
        $patient->delete();

        success(__('flashes.destroy'));
        return $this->routeRedirect('patient.index');
    }

    /**
     * Checking values for enum attributes.
     *
     * @param array $data
     */
    private function checkEnums($data = [])
    {
        foreach (Patient::ENUM_FIELDS as $field) {
            if (array_key_exists($field, $data) && !in_array($data[$field], Patient::getEnumValues($field))) {
                error(__('flashes.wrongData'));
                return back()->withInput();
            }
        }
        return true;
    }

    /**
     * Custom Redirect method to handle admin routes.
     */
    private function routeRedirect(String $route)
    {
        if (request()->routeIs('admin.patient.*')) {
            return redirect()->route("admin.$route");
        }
        return redirect()->route($route);
    }

    /**
     * Search In patients Table.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        if (empty($request->query('key'))) {
            return redirect()->route('patient.index');
        }

        $key = $request->query('key');

        $patients = Patient::query();
        $searchIn = [
            'code',
            'ar_name',
            'en_name',
            'phone',
            'national_id',
            'nationality',
            'age',
            'address',
            // 'gender',
            // 'social_status',
            // 'type',
            // 'payment_method',
        ];
        foreach ($searchIn as $field) {
            $patients->orWhere($field, 'LIKE', "%$key%");
        }
        return view('patients.index', ['patients' => $patients->paginate(10)]);
    }

    /**
     * Create a ray request.
     */
    public function raysRequest(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'raysTypes' => 'required|array',
            'raysTypes.*' => 'required|exists:rays_types,id',
        ]);

        $doctorId = auth()->id();
        foreach ($data['raysTypes'] as $typeId) {
            RayRequest::create([
                'doctor_id' => $doctorId,
                'patient_id' => $patient->id,
                'ray_type_id' => $typeId,
            ]);
        }

        success(__('flashes.store'));
        return back();
    }

    /**
     * Create a medical test request.
     */
    public function medicalTestRequest(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'medicalTests' => 'required|array',
            'medicalTests.*' => 'required|exists:medical_tests,id',
        ]);

        $doctorId = auth()->user()->id;
        foreach ($data['medicalTests'] as $testId) {
            MedicalTestRequest::create([
                'doctor_id' => $doctorId,
                'patient_id' => $patient->id,
                'medical_test_id' => $testId,
            ]);
        }

        success(__('flashes.store'));
        return back();
    }

    /**
     * Get the patient reservations.
     */
    public function reservations(Patient $patient)
    {
        return view('reservations.index', [
            'items' => $patient->reservations()->with(['patient', 'doctor', 'clinic'])->paginate(10)
        ]);
    }
}
