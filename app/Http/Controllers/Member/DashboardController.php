<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $contributions = Contribution::where('submitted_by', $userId);

        $totalContributions = (clone $contributions)->count();

        $pendingCount = (clone $contributions)
            ->where('current_status', 'PENDING')
            ->count();

        $approvedCount = (clone $contributions)
            ->whereIn('current_status', ['APPROVED', 'INTEGRATED'])
            ->count();

        $rejectedCount = (clone $contributions)
            ->whereIn('current_status', ['REJECTED', 'NOT_USED'])
            ->count();

        $recentContributions = (clone $contributions)
            ->orderByDesc('submitted_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact(
            'totalContributions',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'recentContributions'
        ));
    }
}