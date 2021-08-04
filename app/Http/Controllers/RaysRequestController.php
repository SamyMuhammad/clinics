<?php

namespace App\Http\Controllers;

use App\Models\RayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaysRequestController extends Controller
{
    public function index()
    {
        $requests = RayRequest::orderBy('file_id', 'asc')->with(['doctor', 'patient', 'ray_type', 'technician', 'file'])->paginate(10);
        return view('raysRequests.index', [
            'items' => $requests,
        ]);
    }

    public function addResult(RayRequest $rayRequest)
    {
        return view('raysRequests.addResult', [
            'item' => $rayRequest,
        ]);
    }

    public function storeResult(Request $request, RayRequest $rayRequest)
    {
        $file = $request->validate(['file' => 'required|file'])['file'];

        $patient = $rayRequest->patient;

        try {
            DB::transaction(function () use ($rayRequest, $file, $patient) {
                // To overwrite the existed.
                optional($rayRequest->file)->deleteFromUploads();
                optional($rayRequest->file)->delete();
                $fileInstance = $patient->storeToUploads($file, 'rays');
                $rayRequest->update([
                    'technician_id' => auth()->id(),
                    'file_id' => $fileInstance->id,
                ]);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            // throw $th;
            error(__('flashes.error'));
        }

        return redirect()->route('raysRequest.index');
    }
}
