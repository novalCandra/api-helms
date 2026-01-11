<?php

namespace App\Http\Controllers;

use App\Models\Helm_Return;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HelmReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "borrowed_id" => "required|exists:borroweds,id",
            "due_date" => "required|date|string",
        ]);
        $duaDate = Carbon::create($request->due_date);
        $CreateReturn = Helm_Return::create([
            "borrowed_id" => $request->borrowed_id,
            "due_date" => $duaDate->toDateString()
        ]);
        return response()->json([
            "message" => "sucess mengembalikan",
            "data" => $CreateReturn
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Helm_Return $helm_Return)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Helm_Return $helm_Return)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Helm_Return $helm_Return)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Helm_Return $helm_Return)
    {
        //
    }
}
