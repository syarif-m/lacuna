@extends('layouts.app')

@section('content')

<div class="discover-page">
    <div class="discover-inner">

        {{-- Page Introduction --}}
       <header class="discover-intro">
    <p class="discover-kicker">LACUNA / THE ARCHIVE</p>

    <h1>
        Discover the
        <em>Unknown.</em>
    </h1>

    <p class="discover-description">
        Explore documented mysteries, examine the evidence,
        and discover the possibilities behind each case.
    </p>
</header>
        {{-- Search and Filters --}}
        <form action="{{ route('discover') }}" method="GET" class="discover-filter-panel">

            <div class="discover-search">
                <label for="search">Search the archive</label>

                <input
                    type="search"
                    id="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search by title, question, or description..."
                >
            </div>

            <div class="discover-filter-grid">

                {{-- Classification --}}
                <div class="discover-filter-group">
                    <label for="classification">Classification</label>

                    <select name="classification" id="classification">
                        <option value="">All classifications</option>

                        @foreach ($classifications as $tag)
                            <option
                                value="{{ $tag->slug }}"
                                @selected($selectedClassification?->slug === $tag->slug)
                            >
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Verification Status --}}
                <div class="discover-filter-group">
                    <label for="verification">Verification status</label>

                    <select name="verification" id="verification">
                        <option value="">All statuses</option>

                        @foreach ($verificationStatuses as $tag)
                            <option
                                value="{{ $tag->slug }}"
                                @selected($selectedVerification?->slug === $tag->slug)
                            >
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Explanation Status --}}
                <div class="discover-filter-group">
                    <label for="explanation">Explanation status</label>

                    <select name="explanation" id="explanation">
                        <option value="">All statuses</option>

                        @foreach ($explanationStatuses as $tag)
                            <option
                                value="{{ $tag->slug }}"
                                @selected($selectedExplanation?->slug === $tag->slug)
                            >
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Additional Classification Tags --}}
            <div class="discover-tags-filter">
                <p class="discover-filter-label">
                    Additional tags
                    <span>— all selected tags must match</span>
                </p>

                <div class="discover-tags-list">
                    @foreach ($classifications as $tag)
                        <label class="discover-checkbox">
                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->slug }}"
                                @checked($selectedTags->contains($tag->slug))
                            >

                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="discover-filter-actions">
                <button type="submit" class="discover-submit">
                    Apply Filters
                </button>

                <a href="{{ route('discover') }}" class="discover-reset">
                    Clear all filters
                </a>
            </div>

        </form>

        {{-- Results Heading --}}
        <section class="discover-results">

            <div class="discover-results-heading">
                <div>
                    <p class="discover-kicker">ARCHIVE RECORDS</p>
                    <h2>Documented Cases</h2>
                </div>

                <p class="discover-result-count">
                    {{ $cases->total() }} records found
                </p>
            </div>

            {{-- Case List --}}
            @forelse ($cases as $case)

                @php
                    $image = $case->images->first();

                    $description = $case->short_description
                        ?: ($case->central_mystery ?: $case->overview_content);
                @endphp

                <article class="discover-record">

                    <div class="discover-record-media">
                        @if ($image)
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                                alt="{{ $image->alt_text }}"
                            >
                        @else
                            <div class="discover-image-placeholder">
                                <span>LACUNA</span>
                                <small>ARCHIVE RECORD</small>
                            </div>
                        @endif
                    </div>

                    <div class="discover-record-content">

                        <div class="discover-record-meta">
                            <span>
                                RECORD {{ sprintf('%02d', ($cases->firstItem() ?? 1) + $loop->index) }}
                            </span>

                            @if ($case->published_at)
                                <span>
                                    PUBLISHED {{ $case->published_at->format('d M Y') }}
                                </span>
                            @endif
                        </div>

                        <h3>{{ $case->title }}</h3>

                        @if ($description)
                            <p class="discover-record-description">
                                {{ \Illuminate\Support\Str::limit($description, 220) }}
                            </p>
                        @endif

                        <div class="discover-record-status">
                            @if ($case->verificationStatus)
                                <span>
                                    {{ $case->verificationStatus->name }}
                                </span>
                            @endif

                            @if ($case->explanationStatus)
                                <span>
                                    {{ $case->explanationStatus->name }}
                                </span>
                            @endif
                        </div>

                        @if ($case->tags->isNotEmpty())
                            <div class="discover-record-tags">
                                @foreach ($case->tags as $tag)
                                    <span>{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </article>

            @empty

                <div class="discover-empty">
                    <p class="discover-empty-index">NO RECORDS FOUND</p>

                    <h3>
                        No mysteries found matching your search.
                    </h3>

                    <p>
                        Try changing your search terms or removing some filters.
                    </p>

                    <a href="{{ route('discover') }}">
                        Return to the archive
                    </a>
                </div>

            @endforelse

            {{-- Pagination --}}
            @if ($cases->hasPages())
                <div class="discover-pagination">
                    {{ $cases->links() }}
                </div>
            @endif

        </section>

    </div>
</div>

@endsection