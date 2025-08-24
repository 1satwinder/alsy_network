<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use Illuminate\Http\RedirectResponse;

class BlockPinController extends Controller
{
    public function store(Pin $pin): RedirectResponse
    {
        if ($pin->isUsed()) {
            return redirect()->back()->with('error', 'Pin is already used');
        }

        $pin->status = Pin::STATUS_BLOCKED;
        $pin->save();

        return redirect()->back()->with('success', 'Pin blocked successfully');
    }

    public function destroy(Pin $pin): RedirectResponse
    {
        if (! $pin->isBlocked()) {
            return redirect()->back()->with('error', 'Pin is already un-blocked');
        }

        if ($pin->used_by) {
            $pin->status = Pin::STATUS_USED;
        } else {
            $pin->status = Pin::STATUS_UN_USED;
        }
        $pin->save();

        return redirect()->back()->with('success', 'Pin un-blocked successfully');
    }
}
