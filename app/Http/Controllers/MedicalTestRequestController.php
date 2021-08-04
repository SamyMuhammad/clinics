<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalTestRequest;
use Illuminate\Support\Facades\DB;

class MedicalTestRequestController extends Controller
{
    public function index()
    {
        $requests = MedicalTestRequest::orderBy('file_id', 'asc')
        ->with(['doctor', 'patient', 'medical_test', 'tests_responsible', 'file'])->paginate(10);
        
        return view('medicalTestsRequests.index', [
            'items' => $requests,
        ]);
    }

    public function addResult(MedicalTestRequest $testRequest)
    {
        return view('medicalTestsRequests.addResult', [
            'item' => $testRequest,
        ]);
    }

    public function storeResult(Request $request, MedicalTestRequest $testRequest)
    {
        $file = $request->validate(['file' => 'required|file'])['file'];

        $patient = $testRequest->patient;

        try {
            DB::transaction(function () use ($testRequest, $file, $patient) {
                // To overwrite the existed.
                optional($testRequest->file)->deleteFromUploads();
                optional($testRequest->file)->delete();
                $fileInstance = $patient->storeToUploads($file, 'test');
                $testRequest->update([
                    'tests_responsible_id' => auth()->id(),
                    'file_id' => $fileInstance->id,
                ]);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            // throw $th;
            error(__('flashes.error'));
        }

        return redirect()->route('testRequest.index');
    }
}
