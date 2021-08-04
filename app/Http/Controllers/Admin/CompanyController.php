<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view companies')->only('index');
        $this->middleware('can:show companies')->only('show');
        $this->middleware('can:create companies')->only(['create', 'store']);
        $this->middleware('can:edit companies')->only(['edit', 'update']);
        $this->middleware('can:delete companies')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Company::paginate(10);
        return view('admin.companies.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $data = $request->validated();
        try {
            $item = Company::create($data);
            success(__('flashes.store'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('admin.companies.show', ['item' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', [
            'item' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $data = $request->validated();
        try {
            $company->update($data);
            success(__('flashes.update'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            success(__('flashes.destroy'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.company.index');
    }

    public function patients(Company $company)
    {
        $patients = $company->patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }
}
