<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pin;
use App\Models\PinTransfer;
use DB;
use Illuminate\Http\Request;

class PinTransferController extends Controller
{
    public function member(Request $request)
    {
        if ($request->get('code') == $this->member->code) {
            return response()->json(['success' => false, 'message' => 'You cannot transfer your pin to yourself'], 200);
        }

        $memberDetails = Member::with('user')->where('code', $request->get('code'))->first();

        return response()->json(['success' => true, 'member_details' => $memberDetails], 200);
    }

    public function store(Request $request)
    {
        if ($request->get('code') == '') {
            return redirect()->back()->with(['error' => 'Member ID is required'])->withInput();
        }

        if ($request->get('code') === $this->member->code) {
            return redirect()->back()->with(['error' => 'You cannot transfer your pin to yourself'])->withInput();
        }

        return DB::transaction(function () use ($request) {
            if (isset($request->pins) && ! empty($request->pins)) {
                foreach ($request->pins as $key => $pin) {
                    if ($pin = Pin::whereCode($pin)->where('member_id', $this->member->id)->first()) {
                        $member = Member::whereCode($request->get('code'))->first();

                        if ($member) {

                            if ($member->isBlocked()) {
                                return redirect()->back()->with('error', 'Member ID is blocked.')->withInput();
                            }

                            $pin->member_id = $member->id;
                            $pin->save();

                            PinTransfer::create([
                                'pin_id' => $pin->id,
                                'from_id' => $this->member->id,
                                'to_id' => $member->id,
                            ]);
                        } else {
                            return redirect()->back()->with(['error' => 'Member ID is incorrect'])->withInput();
                        }

                    }
                }

                return redirect()->back()->with(['success' => 'Pin Transfer Successfully']);
            }

            return redirect()->back()->with(['error' => 'Invalid Member With Pin'])->withInput();
        });
    }
}
