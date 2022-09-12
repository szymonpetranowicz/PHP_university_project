<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use Faker\Provider\Base;
use Faker\Provider\DateTime;

final class ImmutableDateTime extends Base
{
    public static function immutableDateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable(
            DateTime::dateTimeBetween($startDate, $endDate, $timezone)
        );
    }
}
