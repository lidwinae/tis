<?php

namespace App\Http\Controllers\Api;

use App\Models\Jawaban;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabanController extends Controller
{
    // Submit jawaban
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'tugas_id' => 'required|exists:tugas,id',
    //         'jawaban_text' => 'required|string',
    //     ]);

    //     // Cek apakah sudah pernah submit
    //     $existing = Jawaban::where('tugas_id', $request->tugas_id)
    //         ->where('mahasiswa_id', Auth::id())
    //         ->first();

    //     if ($existing) {
    //         return back()->with('error', 'Anda sudah mengumpulkan jawaban untuk tugas ini');
    //     }

    //     Jawaban::create([
    //         'tugas_id' => $request->tugas_id,
    //         'mahasiswa_id' => Auth::id(),
    //         'jawaban_text' => $request->jawaban_text,
    //     ]);

    //     return redirect()->route('tugas.index')->with('success', 'Jawaban berhasil dikumpulkan!');
    // }

    public function store(Request $request, $tugasId)
    {
        $request->validate([
            'jawaban_text' => 'required|string'
        ]);

        // Cek apakah sudah pernah mengumpulkan
        $existing = Jawaban::where('tugas_id', $tugasId)
            ->where('mahasiswa_id', Auth::id())
            ->exists();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah mengumpulkan jawaban untuk tugas ini'
            ], 422);
        }

        $jawaban = Jawaban::create([
            'tugas_id' => $tugasId,
            'mahasiswa_id' => Auth::id(),
            'jawaban_text' => $request->jawaban_text
        ]);

        return response()->json([
            'message' => 'Jawaban berhasil dikumpulkan',
            'data' => $jawaban
        ], 201);
    }

    public function show($id)
    {
        $userId = Auth::id();
        $jawaban = Jawaban::where('tugas_id', $id)
                          ->where('mahasiswa_id', $userId)
                          ->first();

        if (!$jawaban) {
            return response()->json(null, 204); // tidak ada jawaban
        }

        return response()->json($jawaban);
    }

    // Update nilai oleh dosen
    // public function updateNilai(Request $request, $id)
    // {
    //     if (auth()->user()->role !== 'dosen') {
    //         abort(403);
    //     }

    //     $request->validate([
    //         'nilai' => 'required|numeric|min:0|max:100',
    //         'feedback' => 'nullable|string',
    //     ]);

    //     $jawaban = Jawaban::findOrFail($id);
    //     $jawaban->update([
    //         'nilai' => $request->nilai,
    //         'feedback' => $request->feedback,
    //     ]);

    //     return back()->with('success', 'Nilai berhasil diperbarui');
    // }
}