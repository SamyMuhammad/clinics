<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientFileRequest;

class PatientFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
    {
        $items = $patient->files()->paginate(10);
        return view('admin.files.index', compact('patient', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Patient $patient)
    {
        return view('admin.files.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientFileRequest $request, Patient $patient)
    {
        $data = $request->validated();
        $patient->storeToUploads($data['file'], $data['type'], $data['description']);
        success(__('flashes.store'));
        return redirect()->route('admin.patient.files.index', $patient->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient, File $file)
    {
        return view('admin.files.edit', [
            'patient' => $patient,
            'item' => $file
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientFileRequest $request, Patient $patient, File $file)
    {
        $data = $request->validated();
        $file->update($data);
        return redirect()->route('admin.patient.files.index', $patient->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient, File $file)
    {
        $file->delete();
        success(__('flashes.destroy'));
        return redirect()->route('admin.patient.files.index', $patient->id);
    }
}
