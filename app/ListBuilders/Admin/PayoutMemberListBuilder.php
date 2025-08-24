<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\Models\PayoutMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PayoutMemberListBuilder extends ListBuilder
{
    public static string $name = 'Payout Preview';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            PayoutMember::query(),
            $request
        );
    }

    public static function columns(): array
    {
        return [

        ];
    }
}
