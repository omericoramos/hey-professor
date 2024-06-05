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
                ->withSum('votes', 'unlike')->orderBy('created_at', 'desc')
                ->paginate(8),
        ]);
    }
}
