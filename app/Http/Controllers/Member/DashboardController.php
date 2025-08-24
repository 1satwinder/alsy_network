<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BusinessPlan;
use App\Models\FundRequest;
use App\Models\MagicPoolIncome;
use App\Models\Member;
use App\Models\MemberPopup;
use App\Models\News;
use App\Models\Order;
use App\Models\Payout;
use App\Models\PayoutMember;
use App\Models\Pin;
use App\Models\ReferralBonusIncome;
use App\Models\RewardBonusIncome;
use App\Models\TeamBonusIncome;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use DB;
use Jorenvh\Share\Share;

class DashboardController extends Controller
{
    public function index()
    {
        $news = News::whereStatus(1)->orderBy('id', 'desc')->get();

        $businessPlan = BusinessPlan::with('media')->where(['status' => true])->first();

        $planUrl = optional($businessPlan)->getFirstMediaUrl(BusinessPlan::MC_WEBSITE_PLAN);

        $totalPayout = PayoutMember::where('member_id', $this->member->id)->sum('total');

        $bankingDetails = Bank::orderBy('id', 'desc')->with('media')->active()->limit(3)->get();

        $lastWeekPayout = 0.00;

        if (Payout::count() > 1) {
            $lastWeekPayout = round(optional(PayoutMember::where('member_id', $this->member->id)
                ->where('payout_id', Payout::orderBy('id', 'desc')->skip(1)->take(1)->first()->id)
                ->first())->total);
        }

        $totalSales = Member::where('sponsor_id', $this->member->id)->whereNotNull('package_id')->count();

        $profileImageUrl = $this->member->getFirstMediaUrl(Member::MC_PROFILE_IMAGE);

        $dayWiseEarnings = collect();
        $dayWiseDownline = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);

            $amount = WalletTransaction::where('member_id', $this->member->id)
                ->where('type', WalletTransaction::TYPE_CREDIT)
                ->whereDate('created_at', $date)
                ->sum('amount');

            $members = Member::where('sponsor_path', 'like', "{$this->member->sponsor_path}/%")
                ->whereDate('created_at', $date)
                ->get();

            $dayWiseEarnings->push([
                'day' => $date->format('d-m-Y'),
                'amount' => $amount,
            ]);

            $dayWiseDownline->push([
                'day' => $date->format('d-m-Y'),
                'count' => $members->count(),
            ]);
        }

        $popups = MemberPopup::with('media')->whereStatus(MemberPopup::STATUS_ACTIVE)->get();

        $totalApproved = FundRequest::whereMemberId($this->member->id)->whereStatus(FundRequest::STATUS_APPROVED)->sum('amount');

        $incomes = DB::table('wallet_transactions')
            ->whereMemberId($this->member->id)
            ->where('type', WalletTransaction::TYPE_CREDIT)
            ->where('responsible_type', '!=', WithdrawalRequest::class)
            ->select(
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() THEN amount ELSE 0 END),0) as today_total'),
                DB::raw('COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() - INTERVAL 1 DAY THEN amount ELSE 0 END),0) as last_day_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 6 DAY THEN amount ELSE 0 END),0) as last_seven_days_total'),
                DB::raw('COALESCE(SUM(CASE WHEN created_at >= CURDATE() - INTERVAL 29 DAY THEN amount ELSE 0 END),0) as last_thirty_days_total')
            )
            ->first();

        $referralBonusIncome = round(ReferralBonusIncome::whereMemberId($this->member->id)->sum('total'));
        $teamBonusIncome = round(TeamBonusIncome::whereMemberId($this->member->id)->sum('total'));
        $magicPoolBonusIncome = round(MagicPoolIncome::whereMemberId($this->member->id)->sum('total_amount'));

        $rewardAchievers = RewardBonusIncome::with('member.user')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('reward_bonus_incomes')
                    ->groupBy('member_id');
            })
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($income) {
                return [
                    'name' => $income->member->user->name,
                    'image' => $income->member->present()->profileImage(),
                    'reward' => $income->reward,
                ];
            });

        return view('member.dashboard.index', [
            'news' => $news,
            'rewardAchievers' => $rewardAchievers,
            'popups' => $popups,
            'todayIncome' => $incomes->today_total,
            'lastDayIncome' => $incomes->last_day_total,
            'last7DayIncome' => $incomes->last_seven_days_total,
            'last30DayIncome' => $incomes->last_thirty_days_total,
            'referralBonusIncome' => $referralBonusIncome,
            'teamBonusIncome' => $teamBonusIncome,
            'magicPoolBonusIncome' => $magicPoolBonusIncome,
            'businessPlan' => $businessPlan,
            'totalPayout' => $totalPayout,
            'totalOrders' => Order::where('member_id', $this->member->id)->count(),
            'totalPins' => Pin::where('member_id', $this->member->id)->count(),
            'planUrl' => $planUrl,
            'member' => $this->member,
            'totalEarning' => $this->member->walletTransactions()->credit()->sum('amount'),
            'lastWeekPayout' => $lastWeekPayout,
            'totalSales' => $totalSales,
            'profileImageUrl' => $profileImageUrl,
            'bankDetails' => $bankingDetails,
            'myDirects' => $this->member->sponsored()->count(),
            'myDownLine' => Member::where('sponsor_path', 'like', "{$this->member->sponsor_path}/%")->count(),
            'dayWiseEarnings' => $dayWiseEarnings,
            'dayWiseDownline' => $dayWiseDownline,
            'totalApproved' => $totalApproved,
            'socialMediaLinks' => (new Share)->page($this->member->present()->referralLink(), null, ['class' => 'social-link', 'title' => 'Referral Link'])
                ->facebook()
                ->whatsapp(),
        ]);
    }
}
