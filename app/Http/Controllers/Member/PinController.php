<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\PinListBuilder;
use App\Models\Pin;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PinController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return PinListBuilder::render(
            extras: [
                'member_id' => $this->member->id,
            ],
        );
    }

    public function show($code = null): JsonResponse
    {
        return response()->json([
            'pin' => Pin::whereCode($code)->with('package')->first(),
        ]);
    }
}
