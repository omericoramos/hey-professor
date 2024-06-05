<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class DashBoardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'questions' => Question::withSum('votes', 'like')
                ->withSum('votes', 'unlike')->orderBy('votes_sum_like', 'desc')
                ->paginate(8),
        ]);
    }
}
