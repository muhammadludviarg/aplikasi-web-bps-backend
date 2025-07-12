<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; // Pastikan ini diimpor!

class PublikasiController extends Controller
{
    // Method untuk menampilkan semua publikasi
    public function index()
    {
        return Publikasi::all();
    }

    // Method untuk menyimpan publikasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'description' => 'nullable|string',
            'coverUrl' => 'nullable|url',
        ]);

        $publikasi = Publikasi::create($validated);
        return response()->json($publikasi, 201);
    }

    // Method untuk menampilkan detil publikasi
    public function show(Publikasi $publikasi)
    {
        return response()->json($publikasi);
    }

    // Method untuk mengupdate publikasi
    public function update(Request $request, Publikasi $publikasi)
    {
        \Log::info('Update Request Data:', $request->all());
        \Log::info('Files in request (seharusnya kosong jika alur Cloudinary):', $request->allFiles()); 

        try {
           
            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'releaseDate' => 'sometimes|required|date',
                'description' => 'sometimes|string|nullable',
                'coverUrl' => 'nullable|url', 
            ]);
           
            if (isset($validatedData['title'])) {
                $publikasi->title = $validatedData['title'];
            }
            if (isset($validatedData['releaseDate'])) {
                $publikasi->releaseDate = $validatedData['releaseDate'];
            }
            if (isset($validatedData['description'])) {
                $publikasi->description = $validatedData['description'];
            }
           
            if (isset($validatedData['coverUrl'])) {
                $publikasi->coverUrl = $validatedData['coverUrl'];
            }
            

            $publikasi->save();

            return response()->json($publikasi, 200);

        } catch (ValidationException $e) {
            \Log::error('Validation Error during update:', $e->errors());
            return response()->json([
                'message' => 'Gagal memperbarui data: Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('General Error during update:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan server.', 'error' => $e->getMessage()], 500);
        }
    }

    // Method untuk menghapus publikasi
    public function destroy(Publikasi $publikasi)
    {
        $publikasi->delete();
        return response()->json(['message' => 'Publikasi telah dihapus'], 200);
    }
}