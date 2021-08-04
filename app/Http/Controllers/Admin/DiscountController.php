<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view discounts')->only('index');
        $this->middleware('can:create discounts')->only(['create', 'store']);
        $this->middleware('can:edit discounts')->only(['edit', 'update']);
        $this->middleware('can:delete discounts')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Discount::paginate(10);
        return view('admin.discounts.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        $data = $request->validated();
        try {
            $item = Discount::create($data);
            success(__('flashes.store'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.discount.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', [
            'item' => $discount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DiscountRequest  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $data = $request->validated();
        try {
            $discount->update($data);
            success(__('flashes.update'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        try {
            $discount->delete();
            success(__('flashes.destroy'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.discount.index');
    }
}
