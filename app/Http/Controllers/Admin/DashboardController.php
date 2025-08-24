<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectSellerContract;
use App\Models\FundRequest;
use App\Models\KYC;
use App\Models\Member;
use App\Models\Payout;
use App\Models\PayoutMember;
use App\Models\Pin;
use App\Models\SupportTicket;
use App\Models\TopUp;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class DashboardController extends Controller
{
    public function index()
    {
        $lastFiveRegisterMembers = Member::with('user', 'sponsor', 'media')->take(5)->latest('id')->get();

        $lastFiveActivation = Member::with('user', 'sponsor', 'media')
            ->whereNotNull('activated_at')
            ->take(5)
            ->latest('activated_at')
            ->get();

        $dayCountMembersJoins = collect();
        $dayWisePackageSubscriptions = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $totalMember = Member::select(DB::raw('count(*) as total_members'))
                ->whereDate('created_at', $date)->first();

            $amount = TopUp::leftJoin('packages', 'packages.id', '=', 'top_ups.package_id')
                ->whereDate('top_ups.created_at', $date)
                ->sum('packages.amount');

            $dayCountMembersJoins->push([
                'day' => $date->format('d-m-Y'),
                'total_member' => $totalMember->total_members,
            ]);
            $dayWisePackageSubscriptions->push([
                'day' => $date->format('d-m-Y'),
                'amount' => $amount,
            ]);
        }
        $totalApproved = FundRequest::count();

        $topUps = DB::table('top_ups')
            ->select(
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() THEN amount ELSE 0 END),0) as today_total'),
                DB::raw('COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() - INTERVAL 1 DAY THEN amount ELSE 0 END),0) as last_day_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 6 DAY THEN amount ELSE 0 END),0) as last_seven_days_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 29 DAY THEN amount ELSE 0 END),0) as last_thirty_days_total')
            )
            ->first();

        $deposits = DB::table('fund_requests')
            ->whereStatus(FundRequest::STATUS_APPROVED)
            ->select(
                DB::raw('COALESCE(SUM(amount),0) as total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() THEN amount ELSE 0 END),0) as today_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 6 DAY THEN amount ELSE 0 END),0) as last_seven_days_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 29 DAY THEN amount ELSE 0 END),0) as last_thirty_days_total')
            )
            ->first();

        $totalPayout = PayoutMember::sum('payable_amount');
        $totalLastWeekPayout = Payout::latest()->first();

        $totalLastMonthPayout = Payout::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum('payable_amount');

        $openSupportTicket = SupportTicket::whereStatus(SupportTicket::STATUS_OPEN)->count();

        return view('admin.dashboard', [
            'totalMembers' => Member::count(),
            'openSupportTicket' => $openSupportTicket,
            'totalPayout' => $totalPayout,
            'totalLastWeekPayout' => $totalLastWeekPayout ?: 0,
            'totalLastMonthPayout' => $totalLastMonthPayout,
            'todayTopUps' => $topUps->today_total,
            'lastDayTopUps' => $topUps->last_day_total,
            'last7DayTopUps' => $topUps->last_seven_days_total,
            'last30DayTopUps' => $topUps->last_thirty_days_total,
            'totalDeposits' => $deposits->total,
            'todayDeposits' => $deposits->today_total,
            'last7DayDeposits' => $deposits->last_seven_days_total,
            'last30DayDeposits' => $deposits->last_thirty_days_total,
            'paidMembers' => Member::where('is_paid', Member::IS_PAID)->count(),
            'blockedMembers' => Member::whereStatus(Member::STATUS_BLOCKED)->count(),
            'todayActivation' => Member::whereDate('activated_at', '=', Carbon::today())->count(),
            'totalUsedPins' => Pin::whereStatus(Pin::STATUS_USED)->count(),
            'totalUnusedPins' => Pin::whereStatus(Pin::STATUS_UN_USED)->count(),
            'pendingKYCCount' => KYC::where('status', '=', KYC::STATUS_PENDING)->count(),
            'lastFiveRegisterMembers' => $lastFiveRegisterMembers,
            'lastFiveActivation' => $lastFiveActivation,
            'totalTurnOver' => TopUp::sum('amount'),
            'openSupportTickets' => SupportTicket::open()->count(),
            'dayCountMembersJoins' => $dayCountMembersJoins,
            'dayWisePackageSubscriptions' => $dayWisePackageSubscriptions,
            'totalApproved' => $totalApproved,
            'fundRequestCount' => FundRequest::where('status', FundRequest::STATUS_PENDING)->count(),
        ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws ValidationException
     */
    public function directSellerContract(Request $request): RedirectResponse|Renderable
    {
        $direct_seller_pdf = DirectSellerContract::first();

        if ($request->isMethod('post')) {

            $rules['status'] = 'required';

            $this->validate($request, $rules);

            if (isset($direct_seller_pdf)) {
                $direct_seller_pdf->status = $request->status;
                $direct_seller_pdf->save();
            } else {

                $direct_seller_pdf = DirectSellerContract::create([
                    'status' => $request->status,
                ]);
            }

            if ($fileName = $request->get('direct_seller_contract')) {
                $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

                $direct_seller_pdf->addMediaFromDisk($filePath)
                    ->usingFileName($fileName)
                    ->toMediaCollection(DirectSellerContract::MC_DIRECT_SELLER_CONTRACT);
            }

            return redirect()->route('admin.websetting.direct-seller-contract')
                ->with(['success' => 'Direct Seller Contract updated successfully']);
        }

        return view('admin.web-settings.direct-seller-contract', ['direct_seller_pdf' => $direct_seller_pdf]);
    }
}
