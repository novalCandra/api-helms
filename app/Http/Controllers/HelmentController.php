<?php

namespace App\Http\Controllers;

use App\Models\Helment;
use Illuminate\Http\Request;

class HelmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $helmentsAll = Helment::paginate(10);
        return response()->json([
            "message" => "List of Helments",
            "data" => $helmentsAll
        ], 200);
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
            "helmend_code" => "required|string|min:1|max:255",
            "type" => "required|string|min:1|max:255",
            "condition" => "required|string|min:1|max:255",
            "status" => "required|string|min:1|max:255",
        ]);
        $helmenCreate = Helment::create([
            "helmend_code" => $request->helmend_code,
            "type" => $request->type,
            "condition" => $request->condition,
            "status" => $request->status
        ]);

        try {
            if (!$helmenCreate) {
                return response()->json([
                    "message" => "Helment failed to create"
                ], 404);
            } else {
                return response()->json([
                    "message" => "Helment created successfully",
                    "data" => $helmenCreate
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Server Error",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $helmentId = Helment::findOrFail($id);
        try {
            if (!$helmentId) {
                return response()->json([
                    "message" => "Helment not found"
                ], 404);
            } else {
                return response()->json([
                    "message" => "Helment found",
                    "data" => $helmentId
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Server Error",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Helment $helment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $HelmenUpdate = Helment::findOrFail($id);

        $request->validate([
            "helmend_code" => "required|string|min:1|max:255",
            "type" => "required|string|min:1|max:255",
            "condition" => "required|string|min:1|max:255",
            "status" => "required|string|min:1|max:255",
        ]);

        $HelmenUpdate->update([
            "helmend_code" => $request->helmend_code,
            "type" => $request->type,
            "condition" => $request->condition,
            "status" => $request->status
        ]);

        return response()->json([
            "message" => "Helment updated successfully",
            "data" => $HelmenUpdate
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $helmentDestory = Helment::destroy($id);
        return response()->json([
            "message" => "Helment deleted successfully"
        ]);
    }
}
