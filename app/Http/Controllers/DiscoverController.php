<?php

namespace App\Http\Controllers;

use App\Models\MysteryCase;
use App\Models\Tag;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pilihan filter dari database.
        $classifications = Tag::where('tag_kind', 'CLASSIFICATION')
            ->orderBy('name')
            ->get();

        $verificationStatuses = Tag::where('tag_kind', 'VERIFICATION_STATUS')
            ->orderBy('name')
            ->get();

        $explanationStatuses = Tag::where('tag_kind', 'EXPLANATION_STATUS')
            ->orderBy('name')
            ->get();

        // Ambil parameter pencarian dan filter dari URL.
        $search = $request->query('q');

        $selectedClassification = $classifications->firstWhere(
            'slug',
            $request->query('classification')
        );

        $selectedVerification = $verificationStatuses->firstWhere(
            'slug',
            $request->query('verification')
        );

        $selectedExplanation = $explanationStatuses->firstWhere(
            'slug',
            $request->query('explanation')
        );

        // Pastikan tag tambahan yang dipilih memang termasuk klasifikasi.
        $selectedTags = collect($request->query('tags', []))
            ->filter(fn ($slug) => $classifications->contains('slug', $slug))
            ->unique()
            ->values();

        // Query utama: hanya Case yang sudah dipublikasikan.
        $casesQuery = MysteryCase::query()
            ->with([
                'tags',
                'verificationStatus',
                'explanationStatus',
                'images' => function ($query) {
                    $query->orderBy('sort_order')
                        ->orderBy('id');
                },
            ])
            ->where('publication_status', 'PUBLISHED')
            ->whereNotNull('published_at');

        // Pencarian berdasarkan judul, deskripsi, pertanyaan,
        // dan isi overview.
        if ($search) {
            $casesQuery->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('central_mystery', 'LIKE', "%{$search}%")
                    ->orWhere('overview_content', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan satu klasifikasi utama.
        if ($selectedClassification) {
            $casesQuery->whereHas('tags', function ($query) use ($selectedClassification) {
                $query->where('tags.slug', $selectedClassification->slug)
                    ->where('tags.tag_kind', 'CLASSIFICATION');
            });
        }

        // Filter berdasarkan status verifikasi.
        if ($selectedVerification) {
            $casesQuery->whereHas('verificationStatus', function ($query) use ($selectedVerification) {
                $query->where('slug', $selectedVerification->slug);
            });
        }

        // Filter berdasarkan status penjelasan.
        if ($selectedExplanation) {
            $casesQuery->whereHas('explanationStatus', function ($query) use ($selectedExplanation) {
                $query->where('slug', $selectedExplanation->slug);
            });
        }

        // Setiap tag tambahan harus dimiliki oleh Case.
        // Pengulangan whereHas menghasilkan logika AND.
        foreach ($selectedTags as $slug) {
            $casesQuery->whereHas('tags', function ($query) use ($slug) {
                $query->where('tags.slug', $slug)
                    ->where('tags.tag_kind', 'CLASSIFICATION');
            });
        }

        // Urutkan dari Case yang paling baru dipublikasikan.
        $cases = $casesQuery
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('discover', compact(
            'cases',
            'classifications',
            'verificationStatuses',
            'explanationStatuses',
            'search',
            'selectedClassification',
            'selectedVerification',
            'selectedExplanation',
            'selectedTags'
        ));
    }
}