<?php
namespace App\Http\Controllers;

use App\Models\MysteryCase;

class HomeController extends Controller
{
    public function index()
    {
        $recentCases = MysteryCase::query()
            ->with([
                'tags',
                'images' => function ($query) {
                    $query->orderBy('sort_order')
                          ->orderBy('id');
                },
            ])
            ->where('publication_status', 'PUBLISHED')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        return view('home', compact('recentCases'));
    }
}