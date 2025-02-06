<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Storage::disk('local')->get('quiz_questions.json');
        
        return Inertia::render('Quiz/Index', [
            'quizQuestions' => json_decode($questions, true)['questions']
        ]);
    }
}
