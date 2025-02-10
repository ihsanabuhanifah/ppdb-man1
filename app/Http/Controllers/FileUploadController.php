<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
    public function foto_profile(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',

        ]);

        // Simpan file
        if ($request->file('file')) {
            $path = $request->file('file')->store('uploads', 'public'); // Simpan ke storage/app/public/uploads

            // Simpan path ke tabel users (asumsikan user sedang login)
            $user = Auth::user();


            if($request-> key === 'foto_profile') {
                $user->foto_profile = asset("storage/$path");
            }
            if($request-> key === 'foto_kks') {
                $user->foto_kks = asset("storage/$path");
            }
            if($request-> key === 'foto_pkh') {
                $user->foto_pkh = asset("storage/$path");
            }
            if($request-> key === 'foto_kip') {
                $user->foto_kip = asset("storage/$path");
            }
            if($request-> key === 'dokumen_prestasi') {
                $user->dokumen_prestasi = asset("storage/$path");
            }

            $user->save();

            return response()->json([
                'message' => 'File uploaded successfully',
                'file_url' => asset("storage/$path"),
                'user' => $user
            ], 201);
        }

        return response()->json(['message' => 'File upload failed'], 400);
    }
}
