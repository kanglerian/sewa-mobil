<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Car::paginate(10);
        return view('pages.cars.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'brand' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'plate_number' => 'required|string|max:20|unique:cars,plate_number',
                'rates' => 'required|numeric|min:0',
                'available' => 'required|boolean',
            ]);

            Car::create($validatedData);
            return redirect()->route('cars.index')->with('success', 'Car has been successfully added.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('pages.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('pages.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        try {
            $validatedData = $request->validate([
                'brand' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $car->id,
                'rates' => 'required|numeric|min:0',
                'available' => 'required|boolean',
            ]);

            $car->update($validatedData);
            return redirect()->route('cars.index')->with('success', 'Car has been successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        try {
            $car->delete();
            return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }
}
