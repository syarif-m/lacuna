@extends('layouts.app')

@section('content')

<div class="member-dashboard">
    <div class="member-dashboard-inner">

        {{-- Welcome Header --}}
        <header class="member-dashboard-header">
            <div>
                <p class="member-dashboard-kicker">
                    LACUNA / MEMBER AREA
                </p>

                <h1>Your Archive.</h1>

                <p>
                    Welcome back, {{ auth()->user()->name }}.
                    Manage your contributions and follow their review progress.
                </p>
            </div>

            <div class="member-dashboard-account">
                <span>ACCOUNT</span>
                <strong>{{ auth()->user()->username }}</strong>
                <small>MEMBER</small>
            </div>
        </header>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="member-success-message">
                {{ session('success') }}
            </div>
        @endif

        {{-- Submit a Case Action --}}
            <section class="member-dashboard-actions">

                <div>
                    <p class="member-dashboard-kicker">CONTRIBUTE TO THE ARCHIVE</p>
                    <h2>Have a mystery worth documenting?</h2>
                    <p>
                        Submit a case and help expand the Lacuna archive.
                    </p>
                </div>

                <a href="{{ route('member.cases.create') }}">
                    Submit a Case
                    <span>&rarr;</span>
                </a>

            </section>

        {{-- Contribution Statistics --}}
        <section class="member-dashboard-stats">

            <article class="member-stat">
                <span>TOTAL CONTRIBUTIONS</span>
                <strong>{{ $totalContributions }}</strong>
                <small>All submitted contributions</small>
            </article>

            <article class="member-stat">
                <span>PENDING REVIEW</span>
                <strong>{{ $pendingCount }}</strong>
                <small>Waiting for Admin review</small>
            </article>

            <article class="member-stat">
                <span>ACCEPTED / INTEGRATED</span>
                <strong>{{ $approvedCount }}</strong>
                <small>Accepted or used contributions</small>
            </article>

            <article class="member-stat">
                <span>REJECTED / NOT USED</span>
                <strong>{{ $rejectedCount }}</strong>
                <small>Contributions not selected</small>
            </article>

        </section>

        {{-- Recent Contributions --}}
        <section class="member-dashboard-history" id="contributions">

            <div class="member-section-heading">
                <div>
                    <p class="member-dashboard-kicker">
                        YOUR ACTIVITY
                    </p>

                    <h2>Recent Contributions</h2>
                </div>

                <span>{{ $totalContributions }} RECORDS</span>
            </div>

            @if ($recentContributions->isNotEmpty())

                <div class="member-contribution-list">

                    @foreach ($recentContributions as $contribution)

                        <article class="member-contribution-item">

                            <div class="member-contribution-main">

                                <span class="member-contribution-type">
                                    {{ \Illuminate\Support\Str::headline($contribution->contribution_type) }}
                                </span>

                                <strong>
                                    {{ \Illuminate\Support\Str::headline($contribution->contribution_type) }}
                                    Contribution
                                </strong>

                                <small>
                                    Submitted
                                    @if ($contribution->submitted_at)
                                        {{ $contribution->submitted_at->format('d M Y, H:i') }}
                                    @else
                                        date unavailable
                                    @endif
                                </small>

                            </div>

                            <div class="member-contribution-status">
                                <span class="status-{{ strtolower($contribution->current_status) }}">
                                    {{ \Illuminate\Support\Str::headline($contribution->current_status) }}
                                </span>
                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="member-dashboard-empty">

                    <p class="member-empty-index">
                        NO CONTRIBUTIONS YET
                    </p>

                    <h3>Your archive is waiting for its first record.</h3>

                    <p>
                        Contributions you submit to Lacuna will appear here.
                        You can track their review status from this page.
                    </p>

                </div>

            @endif

        </section>

        {{-- Account Actions --}}
        <footer class="member-dashboard-footer">
            <div>
                <p class="member-dashboard-kicker">ACCOUNT</p>
                <h2>Manage your session</h2>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="member-logout-button">
                    Log Out
                </button>
            </form>
        </footer>

    </div>
</div>

@endsection