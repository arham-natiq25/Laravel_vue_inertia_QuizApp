<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $questions = Question::with(['answers'=>function($query){
        $query->inRandomOrder();
       }])->inRandomOrder()->get();

       return Inertia::render('Quiz',[
        'questions'=>$questions
       ]);
    }

    public function results(Request $request)
    {
        $score =  $request[0]['results']['score'];
       $totalQuestions =  $request[0]['results']['totalQuestions'];

       $percentage = ceil(($score/$totalQuestions)*100);

       $comment = match(true) {
        $percentage>=80 && $percentage<=100 => 'Congratulations',
        $percentage>=60 && $percentage<=79 => 'Impressive',
        $percentage>=40 && $percentage<=59 => 'Almost there',
        $percentage<40 => 'Uh-no',
        default => 'WELL HOW DID YOU REACH HERE ? '
       };

       return Inertia::render('Result',[
        'percentage' => $percentage,
        'comments' => $comment
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
