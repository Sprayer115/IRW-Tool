<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function getJsonFile(Request $request, $filename)
    {
        if (!Storage::disk('local')->exists('quiz/' . $filename)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        $fileContent = Storage::disk('local')->get('quiz/' . $filename);
        $jsonData = json_decode($fileContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON'], 400);
        }

        return response()->json($jsonData);
    }
}