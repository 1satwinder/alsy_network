<?php

use App\Library\Settings;
use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Math\RoundingMode;

if (! function_exists('settings')) {
    /**
     * @param  string|null  $key
     * @param  null  $default
     * @return Settings|mixed|null
     */
    function settings($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('settings');
        }

        if (is_array($key)) {
            return app('settings')->set($key);
        }

        return app('settings')->get($key, $default);
    }
}

if (! function_exists('currency')) {
    function currency($value)
    {
        return (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))
            ->formatCurrency($value, env('CURRENCY', 'INR'));
    }
}

if (! function_exists('currencyInWords')) {
    function currencyInWords($amount): string
    {
        return ucwords(
            (new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))
                ->format($amount)
        ).' only';
    }
}

if (! function_exists('currencySuffix')) {
    function currencySuffix($text): string
    {
        return sprintf(
            '%s (%s)',
            $text,
            env('APP_CURRENCY', ' र '),
        );
    }
}

if (! function_exists('currencyPrefix')) {
    function currencyPrefix($text): string
    {
        return sprintf(
            '(%s) %s',
            env('APP_CURRENCY', ' र '),
            $text,
        );
    }
}

if (! function_exists('deepAccess')) {
    function deepAccess($object, $path)
    {
        return array_reduce(
            explode('.', $path),
            function ($object, $property) {
                return is_numeric($property) ? ($object[$property] ?? null) : ($object->$property ?? null);
            },
            $object
        );
    }
}

if (! function_exists('toHumanReadable')) {
    /**
     * @throws MathException
     * @throws RoundingNecessaryException
     */
    function toHumanReadable($amount): float|int
    {
        return BigDecimal::of($amount)
            ->toScale(settings('decimal'), RoundingMode::HALF_UP)
            ->stripTrailingZeros()
            ->__toString();
    }
}
