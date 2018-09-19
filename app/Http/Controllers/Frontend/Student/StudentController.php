<?php

namespace App\Http\Controllers\Frontend\Student;

use App\Models\Auth\User;
use App\Models\Examination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function joinTest(Request $request, User $user, Examination $examination) {
        dd($user);
    }
}
