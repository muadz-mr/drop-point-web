<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('imageFilepond')) {
            $folder = $request->get('target');
            $uploadPath = $request->file('imageFilepond')->store("uploads/{$folder}", 'public');

            return response()->json(['success' => true, 'data' => $uploadPath]);
        }

        return '';
    }

    public function revert(Request $request): JsonResponse
    {
        if ($imagePath = $request->get('image_path')) {
            $path  = $this->localPathAware(storage_path("app/public/{$imagePath}"));

            if (file_exists($path)) {
                // Storage::disk('public')->delete("app/public/{$imagePath}");
                unlink($path);

                return response()->json(['success' => true, 'data' => null]);
            }
        }
    }

    private function localPathAware(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
