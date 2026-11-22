@extends('layouts.app')

@section('content')

<div class="case-submission-page">
    <div class="case-submission-inner">

        {{-- Breadcrumb --}}
        <nav class="case-submission-breadcrumb">
            <a href="{{ route('member.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Submit a Case</span>
        </nav>

        {{-- Header --}}
        <header class="case-submission-header">
            <p class="submission-kicker">LACUNA / CONTRIBUTION</p>

            <h1>Document a Mystery.</h1>

            <p>
                Contribute a new case to the archive. Your submission
                will be reviewed by an Admin before publication.
            </p>
        </header>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="submission-errors">
                <strong>There are some issues with your submission:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('member.cases.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="case-submission-form"
        >
            @csrf

            {{-- Basic Information --}}
            <section class="submission-section">

                <div class="submission-section-heading">
                    <p class="submission-kicker">01 / BASIC INFORMATION</p>
                    <h2>Case Details</h2>
                    <p>Introduce the mystery you want to document.</p>
                </div>

                <div class="submission-field">
                    <label for="proposed_title">Case Title *</label>

                    <input
                        type="text"
                        id="proposed_title"
                        name="proposed_title"
                        value="{{ old('proposed_title') }}"
                        placeholder="e.g. The Dancing Plague of 1518"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="submission-field">
                    <label for="proposed_summary">Short Description *</label>

                    <textarea
                        id="proposed_summary"
                        name="proposed_summary"
                        rows="3"
                        placeholder="A concise introduction to this mystery..."
                        required
                    >{{ old('proposed_summary') }}</textarea>

                    <small>
                        A brief introduction that will help visitors understand the case.
                    </small>
                </div>

                <div class="submission-field">
                    <label for="central_mystery">Central Mystery *</label>

                    <textarea
                        id="central_mystery"
                        name="central_mystery"
                        rows="3"
                        placeholder="What is the main unanswered question?"
                        required
                    >{{ old('central_mystery') }}</textarea>

                    <small>
                        State the central question that makes this case mysterious.
                    </small>
                </div>

                <div class="submission-field">
                    <label for="overview_content">Overview</label>

                    <textarea
                        id="overview_content"
                        name="overview_content"
                        rows="8"
                        placeholder="Document the known information, timeline, background, and relevant details..."
                    >{{ old('overview_content') }}</textarea>

                    <small>
                        Provide factual background and known information.
                        Leave theories and speculation for separate contributions.
                    </small>
                </div>

            </section>

            {{-- Classification --}}
            <section class="submission-section">

                <div class="submission-section-heading">
                    <p class="submission-kicker">02 / CLASSIFICATION</p>
                    <h2>Classify the Case</h2>
                    <p>Select at least one classification.</p>
                </div>

                <div class="submission-classification-list">

                    @foreach ($classifications as $tag)
                        <label class="submission-checkbox">

                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                @checked(in_array(
                                    $tag->id,
                                    old('tags', [])
                                ))
                            >

                            <span>{{ $tag->name }}</span>

                        </label>
                    @endforeach

                </div>

            </section>

            {{-- Suggested Statuses --}}
            <section class="submission-section">

                <div class="submission-section-heading">
                    <p class="submission-kicker">03 / SUGGESTED STATUS</p>
                    <h2>Current Understanding</h2>
                    <p>
                        Suggest how the case should initially be classified.
                        Admin may review these selections.
                    </p>
                </div>

                <div class="submission-status-grid">

                    <div class="submission-field">
                        <label for="suggested_verification_status_tag_id">
                            Verification Status *
                        </label>

                        <select
                            name="suggested_verification_status_tag_id"
                            id="suggested_verification_status_tag_id"
                            required
                        >
                            <option value="">Select verification status</option>

                            @foreach ($verificationStatuses as $tag)
                                <option
                                    value="{{ $tag->id }}"
                                    @selected(old('suggested_verification_status_tag_id') == $tag->id)
                                >
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="submission-field">
                        <label for="suggested_explanation_status_tag_id">
                            Explanation Status *
                        </label>

                        <select
                            name="suggested_explanation_status_tag_id"
                            id="suggested_explanation_status_tag_id"
                            required
                        >
                            <option value="">Select explanation status</option>

                            @foreach ($explanationStatuses as $tag)
                                <option
                                    value="{{ $tag->id }}"
                                    @selected(old('suggested_explanation_status_tag_id') == $tag->id)
                                >
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </section>

            {{-- Gallery --}}
            <section class="submission-section">

                <div class="submission-section-heading">
                    <p class="submission-kicker">04 / VISUAL RECORDS</p>
                    <h2>Case Images</h2>
                    <p>
                        Add up to three images that help document this case.
                        Images are private until the submission is approved.
                    </p>
                </div>

                @foreach (range(0, 2) as $index)

                    <div class="submission-image-entry">

                        <h3>Image {{ $index + 1 }}</h3>

                        <div class="submission-field">
                            <label for="image_file_{{ $index }}">
                                Select Image
                            </label>

                            <input
                                type="file"
                                id="image_file_{{ $index }}"
                                name="images[{{ $index }}][file]"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <small>
                                JPG, PNG, or WebP. Maximum 5 MB per image.
                            </small>
                        </div>

                        <div class="submission-field">
                            <label for="image_alt_{{ $index }}">Alt Text</label>

                            <input
                                type="text"
                                id="image_alt_{{ $index }}"
                                name="images[{{ $index }}][alt_text]"
                                value="{{ old("images.$index.alt_text") }}"
                                placeholder="Describe what is visible in this image..."
                            >
                        </div>

                        <div class="submission-field">
                            <label for="image_caption_{{ $index }}">Caption</label>

                            <input
                                type="text"
                                id="image_caption_{{ $index }}"
                                name="images[{{ $index }}][caption]"
                                value="{{ old("images.$index.caption") }}"
                                placeholder="Optional image caption"
                            >
                        </div>

                        <div class="submission-field">
                            <label for="image_context_{{ $index }}">
                                Context Description
                            </label>

                            <textarea
                                id="image_context_{{ $index }}"
                                name="images[{{ $index }}][context_description]"
                                rows="2"
                                placeholder="Explain the image's relevance to the case..."
                            >{{ old("images.$index.context_description") }}</textarea>
                        </div>

                    </div>

                @endforeach

            </section>

            {{-- Submission Notice --}}
            <div class="submission-notice">
                <strong>Before submitting</strong>

                <p>
                    Your submission will enter the Admin review queue.
                    It will not appear in the public archive until it has
                    been reviewed and published.
                </p>
            </div>

            {{-- Actions --}}
            <div class="submission-actions">

                <a href="{{ route('member.dashboard') }}">
                    Cancel
                </a>

                <button type="submit">
                    Submit Case
                </button>

            </div>

        </form>

    </div>
</div>

@endsection