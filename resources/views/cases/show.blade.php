@extends('layouts.app')

@section('content')

<div class="case-detail-page">
    <div class="case-detail-inner">

        {{-- Breadcrumb --}}
        <nav class="case-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('discover') }}">Discover</a>
            <span>/</span>
            <span>{{ $case->title }}</span>
        </nav>

        {{-- Case Header --}}
        <header class="case-detail-header">

            <p class="case-detail-kicker">
                LACUNA / CASE RECORD
            </p>

            <div class="case-detail-tags">
                @foreach ($case->tags as $tag)
                    <span>{{ $tag->name }}</span>
                @endforeach
            </div>

            <h1>{{ $case->title }}</h1>

            @if ($case->short_description)
                <p class="case-detail-description">
                    {{ $case->short_description }}
                </p>
            @endif

            <div class="case-detail-statuses">

                @if ($case->verificationStatus)
                    <span>
                        <small>VERIFICATION</small>
                        {{ $case->verificationStatus->name }}
                    </span>
                @endif

                @if ($case->explanationStatus)
                    <span>
                        <small>EXPLANATION</small>
                        {{ $case->explanationStatus->name }}
                    </span>
                @endif

                @if ($case->published_at)
                    <span>
                        <small>DOCUMENTED</small>
                        {{ $case->published_at->format('d M Y') }}
                    </span>
                @endif

            </div>

        </header>

        {{-- Central Mystery --}}
        @if ($case->central_mystery)
            <section class="case-central-mystery">

                <p class="case-section-kicker">
                    THE CENTRAL MYSTERY
                </p>

                <h2>{{ $case->central_mystery }}</h2>

            </section>
        @endif

        {{-- Overview --}}
        @if ($case->overview_content)
            <section class="case-overview">

                <div class="case-section-heading">
                    <p class="case-section-kicker">01 / DOCUMENTATION</p>
                    <h2>Overview</h2>
                </div>

                <div class="case-overview-content">
                    {!! nl2br(e($case->overview_content)) !!}
                </div>

            </section>
        @endif

        {{-- Gallery --}}
        <section class="case-gallery">

            <div class="case-section-heading">
                <p class="case-section-kicker">02 / VISUAL RECORDS</p>
                <h2>Gallery</h2>
            </div>

            @if ($case->images->isNotEmpty())

                <div class="case-gallery-grid">

                    @foreach ($case->images as $image)
                        <figure class="case-gallery-item">

                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                                alt="{{ $image->alt_text }}"
                                loading="lazy"
                            >

                            @if ($image->caption || $image->context_description)
                                <figcaption>
                                    @if ($image->caption)
                                        <strong>{{ $image->caption }}</strong>
                                    @endif

                                    @if ($image->context_description)
                                        <span>{{ $image->context_description }}</span>
                                    @endif
                                </figcaption>
                            @endif

                        </figure>
                    @endforeach

                </div>

            @else

                <p class="case-gallery-empty">
                    No visual records have been added to this case.
                </p>

            @endif

        </section>

        {{-- Coming sections --}}
        <section class="case-upcoming-sections">

            <div>
                <p class="case-section-kicker">03 / REFERENCES</p>
                <h2>Sources</h2>
                <p>References and supporting materials will appear here.</p>
            </div>

            <div>
                <p class="case-section-kicker">04 / COMMUNITY RESEARCH</p>
                <h2>Theories</h2>
                <p>Community-submitted theories will appear here.</p>
            </div>

            <div>
                <p class="case-section-kicker">05 / FINDINGS</p>
                <h2>Explanation</h2>
                <p>The current explanation will appear here.</p>
            </div>

        </section>

    </div>
</div>

@endsection