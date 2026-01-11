<?php

namespace App\Http\Controllers;

use App\Models\Borrowed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BorrowedAll = Borrowed::with(['users', 'helment', 'HelmReturn'])->get();
        return response()->json([
            "status" => true,
            "message" => "Data Borrowed All",
            "data" => $BorrowedAll
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
            "helment_id" => "required|exists:helments,id",
            "status" => "required|string|min:1|max:255",
            "borrow_date" => "required|string",
            "return_date" => "required|string"
        ]);

        $borrow_date = Carbon::create($request->borrow_date);
        $return_date = Carbon::create($request->return_date);

        $user = Auth::user();
        $CreateBorrowed = Borrowed::create([
            "user_id" => $user->id,
            "helment_id" => $request->helment_id,
            "status" => $request->status,
            "borrow_date" => $borrow_date->toDateString(),
            "return_date" => $return_date->toDateString(),
        ]);

        try {
            //code...
            if (!$CreateBorrowed) {
                return response()->json([
                    "status" => false,
                    "message" => "gagal Borrowed"
                ], 404);
            } else {
                return response()->json([
                    "status" => true,
                    "message" => "Sucess Create Borrowed",
                    "data" => $CreateBorrowed
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Api Gagal",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $BorrowedId = Borrowed::with(['users', 'helment', 'HelmReturn'])->findOrFail($id);
        try {
            if (!$BorrowedId) {
                return response()->json([
                    "status" => false,
                    "message" => "Gagal Data Id",
                ], 404);
            } else {
                return response()->json([
                    "status" => true,
                    "message" => "sucess data ID",
                    "data" => $BorrowedId
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "API Error",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowed $borrowed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $BorrowedId = Borrowed::findOrFail($id);
        $request->validate([
            "user_id" => "required|exists:users,id",
            "helment_id" => "required|exists:helments,id",
            "status" => "required|string|min:1|max:255",
            "borrow_date" => "required|string",
            "return_date" => "required|string"
        ]);

        $borrow_date = Carbon::create($request->borrow_date);
        $return_date = Carbon::create($request->return_date);

        $BorrowedId->update([
            "user_id" => $request->user_id,
            "helment_id" => $request->helment_id,
            "status" => $request->status,
            "borrow_date" => $borrow_date->toDateString(),
            "return_date" => $return_date->toDateString(),
        ]);

        try {
            if (!$BorrowedId) {
                return response()->json([
                    "status" => false,
                    "message" => "Gagal Update Data"
                ], 404);
            } else {
                return response()->json([
                    "status" => true,
                    "message" => "Success Edit data",
                    "data" => $BorrowedId
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "gagal api",
                "error" => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $BorroedId = Borrowed::destroy($id);
        return response()->json([
            "message" => "Data Deleted Successfully",
        ]);
    }
}
