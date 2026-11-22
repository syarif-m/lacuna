<?php

namespace App\Http\Controllers;

use App\Models\MysteryCase;

class CaseDetailController extends Controller
{
    public function show(string $slug)
    {
        $case = MysteryCase::query()
            ->with([
                'tags',
                'verificationStatus',
                'explanationStatus',
                'images' => function ($query) {
                    $query->orderBy('sort_order')
                        ->orderBy('id');
                },
            ])
            ->where('slug', $slug)
            ->where('publication_status', 'PUBLISHED')
            ->whereNotNull('published_at')
            ->firstOrFail();

        return view('cases.show', compact('case'));
    }
}