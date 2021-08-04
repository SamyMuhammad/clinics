<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view rooms')->only('index');
        $this->middleware('can:create rooms')->only(['create', 'store']);
        $this->middleware('can:edit rooms')->only(['edit', 'update']);
        $this->middleware('can:delete rooms')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Room::paginate(10);
        return view('admin.rooms.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $data = $request->validated();
        try {
            $item = Room::create($data);
            success(__('flashes.store'));
        } catch (\Throwable $th) {
            // error(__('flashes.error'));
            throw $th;
        }
        return redirect()->route('admin.room.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', [
            'item' => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        $data = $request->validated();
        try {
            $room->update($data);
            success(__('flashes.update'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.room.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            success(__('flashes.destroy'));
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('admin.room.index');
    }
}
