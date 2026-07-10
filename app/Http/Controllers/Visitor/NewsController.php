<?php

namespace App\Http\Controllers\Visitor;

use App\Application\Content\ListNews;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request, ListNews $news): View
    {
        $filters = $request->only(['search', 'page', 'opd']);

        return view('visitor.news', [
            'sportsNews' => $news->sports($filters),
            'announcements' => $news->announcements($filters),
            'filters' => $filters,
        ]);
    }
}
