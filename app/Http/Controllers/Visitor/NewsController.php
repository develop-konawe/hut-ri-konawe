<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request, NewsService $newsService): View
    {
        $filters = $request->only(['search', 'page', 'opd']);

        return view('visitor.news', [
            'sportsNews' => $newsService->sports($filters),
            'announcements' => $newsService->announcements($filters),
            'filters' => $filters,
        ]);
    }
}
