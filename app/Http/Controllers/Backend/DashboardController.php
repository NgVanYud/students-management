<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Examination;
use App\Models\Question;
use App\Models\Subject;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $subjects_count = Subject::all()->count();
        $users_count = User::all()->count();
        $examinations_count = Examination::all()->count();
        $questions_count = Question::all()->count();
        return view('backend.dashboard', [
            'subjects_count' => $subjects_count,
            'users_count' => $users_count,
            'examinations_count' => $examinations_count,
            'questions_count' => $questions_count
        ]);
    }
}
