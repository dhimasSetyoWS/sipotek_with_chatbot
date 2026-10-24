<?php

namespace App\Http\Controllers;

use App\Models\MedicineBatch;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Medicine;
class MedicineBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');

        $batches = MedicineBatch::with('medicine.category')
            ->when($search, function ($query, $search) {
                $query->where('batch_number', 'like', "%{$search}%")
                    ->orWhereHas('medicine', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%");
                    });
            })
            ->orderBy('expiry_date', 'asc') // Urutkan dari yang paling cepat ED (FEFO)
            ->paginate(10)
            ->withQueryString();

        $medicines = Medicine::select('id', 'name', 'brand', 'strength')->orderBy('name')->get();
        return Inertia::render('Medicine/BatchIndex', [
            'batches' => $batches,
            'filters' => $request->only(['search']),
            'medicines' => $medicines
        ]);
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
        //
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'batch_number' => 'required|string|max:50|unique:medicine_batches,batch_number,NULL,id,medicine_id,' . $request->medicine_id,
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
        ]);

        MedicineBatch::create($request->all());

        return redirect()->back()->with('success', 'Batch obat baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
