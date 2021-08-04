<?php

namespace App\Http\Controllers\Admin;

use App\Models\RaysTypes;
use Illuminate\Http\Request;
use App\Http\Requests\RaysRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RaysController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view rays')->only('index');
        $this->middleware('can:show rays')->only('show');
        $this->middleware('can:create rays')->only(['create', 'store']);
        $this->middleware('can:edit rays')->only(['edit', 'update']);
        $this->middleware('can:delete rays')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = RaysTypes::paginate(10);
        return view('admin.rays.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RaysRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                $item = RaysTypes::create($data);
                success(__('flashes.store'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.rays.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RaysTypes $ray)
    {
        return view('admin.rays.show', ['item' => $ray]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RaysTypes $ray)
    {
        return view('admin.rays.edit', ['item' => $ray]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RaysRequest $request, RaysTypes $ray)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($ray, $data) {
                $ray->update($data);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.rays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RaysTypes $ray)
    {
        try {
            DB::transaction(function () use ($ray) {
                $ray->delete();
                success(__('flashes.destroy'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.rays.index');
    }
}
