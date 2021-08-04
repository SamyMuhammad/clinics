<?php

namespace App\Http\Controllers\Admin;

use App\Models\MedicalTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalTestRequest;

class MedicalTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view medical tests')->only('index');
        $this->middleware('can:show medical tests')->only('show');
        $this->middleware('can:create medical tests')->only(['create', 'store']);
        $this->middleware('can:edit medical tests')->only(['edit', 'update']);
        $this->middleware('can:delete medical tests')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = MedicalTest::paginate(10);
        return view('admin.medical-tests.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.medical-tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalTestRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                $item = MedicalTest::create($data);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.medical-test.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalTest  $medicalTest
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalTest $medicalTest)
    {
        return view('admin.medical-tests.show', ['item' => $medicalTest]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalTest  $medicalTest
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalTest $medicalTest)
    {
        return view('admin.medical-tests.edit', ['item' => $medicalTest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalTest  $medicalTest
     * @return \Illuminate\Http\Response
     */
    public function update(MedicalTestRequest $request, MedicalTest $medicalTest)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($medicalTest, $data) {
                $medicalTest->update($data);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.medical-test.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalTest  $medicalTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalTest $medicalTest)
    {
        try {
            DB::transaction(function () use ($medicalTest) {
                $medicalTest->delete();
                success(__('flashes.destroy'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.medical-test.index');
    }
}
