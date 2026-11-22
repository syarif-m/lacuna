
@extends('layouts.app')

@section('title', 'Explore the Unknown | Lacuna')

@section('content')

{{-- HERO / INTRODUCTION --}}
<section class="home-editorial">

    <div class="home-editorial-inner">

        <div class="home-editorial-main">

            <div class="editorial-eyebrow">
                <span class="eyebrow-line"></span>
                A COMMUNITY-DRIVEN MYSTERY ARCHIVE
            </div>

            <h1>
                Explore the
                <em>Unknown.</em>
            </h1>

            <p class="editorial-description">
                An archive of mysteries, evidence, and possibilities.
                Explore documented cases and the questions surrounding them.
            </p>

            <form
                action="{{ route('discover') }}"
                method="GET"
                class="editorial-search"
            >
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search mysteries, phenomena, and cases..."
                    aria-label="Search cases"
                >

                <button type="submit">
                    Search <span>↗</span>
                </button>
            </form>

            <a href="{{ route('discover') }}" class="editorial-browse">
                Browse the archive <span>→</span>
            </a>

        </div>

      
{{-- ARCHIVE STACK --}}
<aside class="archive-index-panel archive-stack-panel"
       data-photo-stack>

    <div class="archive-panel-top">
        <span>LACUNA</span>
        <span>VISUAL ARCHIVE</span>
    </div>

    <div class="photo-stack-stage">

        {{-- 01: Dancing Mania --}}
        <figure class="archive-photo"
                data-stack-card
                data-slot="0"
                data-format="portrait">

            <img
                src="{{ asset('images/archive/01-dancing-mania.webp') }}"
                alt="Historical engraving depicting the Dancing Mania"
            >

            <figcaption>
                <span>HISTORICAL ENGRAVING</span>
                <span>001</span>
            </figcaption>
        </figure>

        {{-- 02: Voynich Manuscript --}}
        <figure class="archive-photo"
                data-stack-card
                data-slot="1"
                data-format="portrait">

            <img
                src="{{ asset('images/archive/02-voynich-manuscript.webp') }}"
                alt="Illustrated folio from the Voynich Manuscript"
            >

            <figcaption>
                <span>MANUSCRIPT</span>
                <span>002</span>
            </figcaption>
        </figure>

        {{-- 03: Antikythera Mechanism --}}
        <figure class="archive-photo"
                data-stack-card
                data-slot="2"
                data-format="square">

            <img
                src="{{ asset('images/archive/03-antikythera-mechanism.webp') }}"
                alt="Antikythera Mechanism archaeological artifact"
            >

            <figcaption>
                <span>ARCHAEOLOGICAL OBJECT</span>
                <span>003</span>
            </figcaption>
        </figure>

        {{-- 04: Atlantis Map --}}
        <figure class="archive-photo"
                data-stack-card
                data-slot="3"
                data-format="landscape">

            <img
                src="{{ asset('images/archive/04-atlantis-map.webp') }}"
                alt="Historical map of Atlantis by Athanasius Kircher"
            >

            <figcaption>
                <span>HISTORICAL CARTOGRAPHY</span>
                <span>004</span>
            </figcaption>
        </figure>

        {{-- 05: Shroud of Turin --}}
        <figure class="archive-photo"
                data-stack-card
                data-slot="4"
                data-format="landscape">

            <img
                src="{{ asset('images/archive/05-shroud-of-turin.webp') }}"
                alt="Historical photograph of the Shroud of Turin"
            >

            <figcaption>
                <span>HISTORICAL DOCUMENTATION</span>
                <span>005</span>
            </figcaption>
        </figure>

    </div>

    <div class="archive-stack-footer">
        <span>CURATED VISUAL REFERENCES</span>

        <button
            type="button"
            class="archive-next"
            data-stack-next
            aria-label="Show next photograph"
        >
            NEXT <span aria-hidden="true">↗</span>
        </button>
    </div>

</aside>




{{-- RECENTLY DOCUMENTED --}}
<section class="archive-section">

    <header class="archive-section-heading">

        <div>
            <span class="editorial-label">01 — THE ARCHIVE</span>

            <h2>Recently Documented</h2>

            <p>
                Explore the latest additions to the archive.
            </p>
        </div>

        <a href="{{ route('discover') }}" class="editorial-browse">
            View all cases <span>→</span>
        </a>

    </header>

    <div class="archive-record-list">

        @forelse(($recentCases ?? []) as $case)

           
<article class="archive-record">

    @php
        $coverImage = $case->images->first();
    @endphp

    <div class="archive-record-number">
        {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
    </div>

    @if($coverImage)
        <div class="archive-record-image">
            <img
                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverImage->image_path) }}"
                alt="{{ $coverImage->alt_text }}"
                loading="lazy"
            >
        </div>
    @else
        <div class="archive-record-image archive-record-no-image">
            <span>NO IMAGE</span>
        </div>
    @endif

    <div class="archive-record-content">

        <div class="archive-record-meta">
            @foreach($case->tags->take(2) as $tag)
                <span>{{ $tag->name }}</span>
            @endforeach

            <time>
                {{ $case->published_at->format('d M Y') }}
            </time>
        </div>

        <h3>{{ $case->title }}</h3>

        <p>{{ $case->short_description }}</p>

    </div>

    <div class="archive-record-arrow" aria-hidden="true">
        ↗
    </div>

</article>

        @empty

            <div class="archive-empty-state">

                <span class="archive-empty-number">—</span>

                <div class="archive-empty-content">
                    <span>NO PUBLIC RECORDS YET</span>

                    <h3>The archive is taking shape.</h3>

                    <p>
                        Newly documented Cases will appear here.
                        Explore the archive to discover what has been recorded.
                    </p>
                </div>

                <a href="{{ route('discover') }}">
                    Explore Discover →
                </a>

            </div>

        @endforelse

    </div>

</section>


{{-- ABOUT PREVIEW --}}
<section class="about-editorial">

    <div class="about-editorial-index">
        <span>02 — ABOUT LACUNA</span>
        <span>OUR PURPOSE</span>
    </div>

    <div class="about-editorial-content">

        <h2>
           <p>Find your</p>
           <p>answers</p>
        </h2>

        <div class="about-editorial-description">

            <p>
                Lacuna is a community-driven archive dedicated
                to documenting unexplained phenomena, examining
                theories, and exploring the knowledge surrounding them.
            </p>

            <a href="{{ route('about') }}">
                More about Lacuna <span>→</span>
            </a>

        </div>

    </div>

</section>

@endsection
