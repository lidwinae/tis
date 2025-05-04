<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Menampilkan semua tugas
    public function index()
    {
        $tugas = Tugas::with(['dosen:id,name']) // Eager load relasi dosen
            ->orderBy('deadline', 'asc')
            ->get()
            ->map(function ($tugas) {
                return [
                    'id' => $tugas->id,
                    'judul' => $tugas->judul,
                    'deskripsi' => $tugas->deskripsi,
                    'deadline' => $tugas->deadline->toDateTimeString(),
                    'dosen' => $tugas->dosen,
                    'created_at' => $tugas->created_at->toDateTimeString(),
                ];
            });

        return response()->json($tugas);
    }

    public function show($id)
    {
        $tugas = Tugas::with(['dosen:id,name'])
            ->findOrFail($id, ['id', 'judul', 'deskripsi', 'deadline', 'dosen_id', 'created_at']);

        return response()->json([
            'id' => $tugas->id,
            'judul' => $tugas->judul,
            'deskripsi' => $tugas->deskripsi,
            'deadline' => $tugas->deadline->toDateTimeString(),
            'dosen' => $tugas->dosen,
            'created_at' => $tugas->created_at->format('d M Y H:i'),
            'is_past_due' => $tugas->deadline->isPast()
        ]);
    }

    // Menampilkan form create (opsional)
    // public function create()
    // {
    //     return Inertia::render('Tugas/Create');
    // }

    // Menyimpan tugas baru
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'judul' => 'required|string|max:255',
    //         'deskripsi' => 'required|string',
    //         'deadline' => 'required|date',
    //     ]);

    //     Tugas::create([
    //         'dosen_id' => auth()->id(),
    //         'judul' => $request->judul,
    //         'deskripsi' => $request->deskripsi,
    //         'deadline' => $request->deadline,
    //     ]);

    //     return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dibuat!');
    // }
}