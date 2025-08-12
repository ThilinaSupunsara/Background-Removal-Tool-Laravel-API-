<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageRemoveController extends Controller
{
    public function showForm()
    {
        return view('removebg.form');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $image = $request->file('image');
        $response = Http::attach(
            'image_file', file_get_contents($image), $image->getClientOriginalName()
        )->withHeaders([
            'X-Api-Key' => config('services.removebg.api_key'),
        ])->post('https://api.remove.bg/v1.0/removebg');

        if ($response->successful()) {
            $filename = 'removed_' . time() . '.png';
            Storage::disk('public')->put($filename, $response->body());
            return response()->download(storage_path("app/public/{$filename}"));
        }

        return back()->with('error', 'Background removal failed: ' . $response->json('errors')[0]['title'] ?? 'Unknown error');
    }
}


