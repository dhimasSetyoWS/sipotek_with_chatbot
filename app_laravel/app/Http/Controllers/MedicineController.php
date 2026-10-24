<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $classification = $request->input('classification');

        $medicines = Medicine::with('category')
            // Filter pencarian teks (nama, brand, zat aktif)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('active_ingredients', 'like', "%{$search}%");
                });
            })
            // Filter klasifikasi (jika dipilih dan bukan "all")
            ->when($classification && $classification !== 'all', function ($query) use ($classification) {
                $query->where('classification', $classification);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Medicine/Index', [
            'medicines' => $medicines,
            'categories' => Category::all(),
            'filters' => $request->only(['search', 'classification']),
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
        $validated = $request->validate([
            'category_id'         => 'required|exists:categories,id',
            'name'                => 'required|string|max:150',
            'brand'               => 'nullable|string|max:100',
            'active_ingredients'  => 'nullable|string',
            'strength'            => 'nullable|string|max:50',
            'dosage_form'         => 'required|string|max:50',
            'registration_number' => 'required|string|max:50|unique:medicines,registration_number',
            'classification'      => 'required|in:bebas,bebas_terbatas,keras,narkotika,psikotropika,jamu,herbal',
        ]);

        // Simpan data ke tabel medicines
        Medicine::create($validated);

        // Redirect kembali dengan membawa pesan sukses (opsional untuk flash message)
        return redirect()->back()->with('success', 'Data obat baru berhasil ditambahkan.');
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
        $validated = $request->validate([
            'category_id'         => 'required|exists:categories,id',
            'name'                => 'required|string|max:150',
            'brand'               => 'nullable|string|max:100',
            'active_ingredients'  => 'nullable|string',
            'strength'            => 'nullable|string|max:50',
            'dosage_form'         => 'required|string|max:50',
            'registration_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('medicines', 'registration_number')->ignore($id)
            ],
            'classification'      => 'required|in:bebas,bebas_terbatas,keras,narkotika,psikotropika,jamu,herbal',
        ]);

        $obat = Medicine::findOrFail($id);
        $obat->update($validated);

        return redirect()->back()->with('success', 'Data obat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $obat = Medicine::findOrFail($id);

        $obat->delete();

        return redirect()->back()->with('success', 'Data obat berhasil dihapus.');
    }
}
