<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\PinListBuilder;
use App\Models\Member;
use App\Models\Package;
use App\Models\Pin;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class PinController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return PinListBuilder::render();
    }

    public function create(): Renderable
    {
        return view('admin.pins.create', [
            'packages' => Package::active()->get(),
            'statuses' => Pin::STATUSES,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'no_of_pins' => 'required|numeric|min:1|max:1000',
            'package_id' => 'required|exists:packages,id',
            'code' => 'required|exists:members,code',
        ], [
            'no_of_pins.required' => 'The number of pins is required',
            'no_of_pins.numeric' => 'The number of pins must be a number',
            'no_of_pins.max' => 'The number of pins may not be greater than 1000',
            'code.required' => 'The Transfer To is required',
            'code.exist' => 'The Transfer code is invalid',
        ]);

        $member = Member::whereCode($request->get('code'))->first();

        if ($member->isBlocked()) {
            return redirect()->back()->with('error', 'Member ID is blocked')->withInput();
        }

        try {
            DB::transaction(function () use ($member, $request) {
                $package = Package::find($request->get('package_id'));

                for ($i = 0; $i < $request->get('no_of_pins'); $i++) {
                    Pin::create([
                        'package_id' => $package->id,
                        'member_id' => $member->id,
                        'code' => strtoupper(Str::random(10)),
                        'amount' => $package->amount,
                        'status' => Pin::STATUS_UN_USED,
                    ]);
                }
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }

        return redirect()->route('admin.pins.index')->with(['success' => 'Pin(s) created successfully']);
    }

    public function show(Pin $pin): Pin
    {
        return $pin->load('package');
    }
}
