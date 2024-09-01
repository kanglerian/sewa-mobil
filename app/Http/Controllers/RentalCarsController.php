<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentalCars;
use App\Models\ReturnCars;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalCarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->role == 'A') {
            $data = RentalCars::with(['cars', 'users'])->paginate(10);
        } else {
            $data = RentalCars::with(['cars', 'users'])->where('user_id', Auth::user()->id)->paginate(10);
        }
        return view('pages.rentals.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::all();
        $clients = User::where('role', 'U')->get();
        return view('pages.rentals.create')->with([
            'cars' => $cars,
            'clients' => $clients,
        ]);
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
                'start' => 'required|date',
                'end' => 'required|date',
            ]);
            $car = Car::findOrFail($request->input('car_id'));
            $overlappingRentals = RentalCars::where('car_id', $validatedData['car_id'])
                ->where(function ($query) use ($validatedData) {
                    $query->whereBetween('start', [$validatedData['start'], $validatedData['end']])
                        ->orWhereBetween('end', [$validatedData['start'], $validatedData['end']])
                        ->orWhere(function ($q) use ($validatedData) {
                            $q->where('start', '<=', $validatedData['start'])
                                ->where('end', '>=', $validatedData['end']);
                        });
                })
                ->exists();

            // Jika mobil sedang disewa pada periode yang diminta
            if ($overlappingRentals) {
                return back()->with('errors', 'The car is not available for the selected period.');
            }

            RentalCars::create($validatedData);
            return redirect()->route('rentals.index')->with('success', 'Rental cars has been successfully added.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('pages.rentals.show', compact('rentalCars'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cars = Car::all();
        $clients = User::where('role', 'U')->get();
        $rentalCars = RentalCars::with(['cars'])->findOrFail($id);
        return view('pages.rentals.edit', compact('rentalCars', 'cars', 'clients'));
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
                'start' => 'required|date',
                'end' => 'required|date',
            ]);
            $rentalCars = RentalCars::findOrFail($id);
            $rentalCars->update($validatedData);
            return redirect()->route('rentals.index')->with('success', 'Rental car has been successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function status(Request $request, $id)
    {
        try {
            $available = $request->input('available');
            $status = $request->input('status');
            $rentalCars = RentalCars::findOrFail($id);
            $returnCars = ReturnCars::where('rental_id', $id)->first();
            $car = Car::where('id', $rentalCars->car_id)->first();
            if ($available == '1' && $status == '1') {
                ReturnCars::create([
                    'car_id' => $request->input('car_id'),
                    'user_id' => $request->input('user_id'),
                    'rental_id' => $id,
                    'return' => Carbon::now(),
                ]);
                $rentalCars->update([
                    'rates' =>$request->input('rates')
                ]);
            }
            if($available == '0' && $status == '0' && $returnCars){
                return redirect()->route('rentals.index')->with('errors', 'Your service is finished, forbidden access.');
            }
            $car->update([
                'available' => $available
            ]);
            $rentalCars->update([
                'status' => $status
            ]);
            return redirect()->route('rentals.index')->with('success', 'Rental car has been successfully updated.');
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
            $rentalCars = RentalCars::findOrFail($id);
            $rentalCars->delete();
            return redirect()->route('rentals.index')->with('success', 'Rental deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());
        }
    }
}
