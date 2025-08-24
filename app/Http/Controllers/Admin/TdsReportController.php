<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutMember;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Throwable;

class TdsReportController extends Controller
{
    public function index(Request $request)
    {
        $records = [];
        $monthYear = '';
        if ($request->monthYr) {
            try {
                $monthYear = Carbon::createFromFormat('M Y', $request->get('monthYr'));
            } catch (Throwable $e) {
                return redirect()->route('admin.tds.index')->with([
                    'error' => 'Invalid month and year selected',
                ]);
            }

            $records = PayoutMember::selectRaw('
                SUM(payout_members.tds) as total_tds, payout_members.member_id
            ')
                ->whereMonth('payout_members.created_at', '=', Carbon::parse($request->monthYr)->month)
                ->whereYear('payout_members.created_at', '=', Carbon::parse($request->monthYr)->year)
                ->groupBy('payout_members.member_id')
                ->with('member.user', 'member.kyc')
                ->paginate(10)->appends(request()->query());

        }

        $months = DB::table('payout_members')
            ->select([DB::raw("DATE_FORMAT(created_at, '%M %Y') as monthYear")])
            ->groupBy(DB::raw('monthYear'))->get()->groupBy('monthYear')->map(function ($monthYear, $monthYearIndex) {
                return (object) [
                    'monthYear' => $monthYearIndex,
                ];
            })->sortBy('monthYear')->values();

        return view('admin.tds-report.index', ['records' => $records, 'months' => $months, 'monthYear' => $monthYear]);
    }

    public function show(Request $request)
    {
        try {
            $monthYear = Carbon::createFromFormat('M Y', $request->get('monthYr'));
        } catch (Throwable $e) {
            return redirect()->route('admin.tds.index')->with([
                'error' => 'Invalid month and year selected',
            ]);
        }

        $payoutMembers = PayoutMember::selectRaw('
                SUM(payout_members.tds) as total_tds, payout_members.member_id
            ')
            ->whereMonth('payout_members.created_at', '=', Carbon::parse($request->monthYr)->month)
            ->whereYear('payout_members.created_at', '=', Carbon::parse($request->monthYr)->year)
            ->groupBy('payout_members.member_id')
            ->with('member.user', 'member.kyc')
            ->get();

        return view('admin.tds-report.show', compact('payoutMembers', 'monthYear'));
    }
}
