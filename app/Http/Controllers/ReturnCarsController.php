<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentalCars;
use App\Models\ReturnCars;
use Illuminate\Http\Request;

class ReturnCarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ReturnCars::with(['cars', 'users'])->paginate(10);
        return view('pages.returns.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.returns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'car_id' => 'required|exists:cars,id',
                'user_id' => 'required|exists:users,id',
                'rates' => 'required|numeric|min:0',
                'return' => 'required|date',
            ]);
            $car = Car::findOrFail($request->input('car_id'));
            $rentalCars = RentalCars::where('car_id', $request->input('car_id'));
            $rentalCars->update([
                'rates' => $validatedData['rates']
            ]);
            $car->update([
                'available' => true,
            ]);
            ReturnCars::create([
                'car_id' => $validatedData['car_id'],
                'user_id' => $validatedData['user_id'],
                'return' => $validatedData['return'],
            ]);
            return redirect()->route('rentals.index')->with('success', 'Return cars has been successfully added.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('pages.returns.show', compact('returnCars'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pages.returns.edit', compact('returnCars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'car_id' => 'required|exists:cars,id',
                'user_id' => 'required|exists:users,id',
                'return' => 'required|date',
            ]);
            $returnCars = ReturnCars::findOrFail($id);
            $returnCars->update($validatedData);
            return redirect()->route('returns.index')->with('success', 'Return car has been successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $returnCars = ReturnCars::findOrFail($id);
            $returnCars->delete();
            return redirect()->route('returns.index')->with('success', 'Return deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }
}
