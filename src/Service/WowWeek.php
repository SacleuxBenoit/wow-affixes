<?php

namespace App\Service;


use DateTimeImmutable;

class WowWeek
{
    const EU_DELAY = 0;

    const EU_Start_Week = 1625036400;

    /**
     * @var array|(int[]|string)[]
     */
    private static array $affixesTurn = [
        [10, 11, 124, 128],
        [9, 6, 3, 128],
        [10, 122, 12, 128],
        [9, 123, 4, 128],
        [10, 7, 14, 128],
        [9, 8, 124, 128],
        [10, 6, 13, 128],
        [9, 11, 3, 128],
        [10, 123, 12, 128],
        [9, 122, 14, 128],
        [10, 8, 4, 128],
        [9, 7, 13, 128],
    ];

    private int $weekNumber;

    public function __construct()
    {
        $this->weekNumber = self::getCurrentWeekNumber();
    }

    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    public function nextWeek(): void
    {
        $this->weekNumber += 1;
    }

    public function setWeekNumber(int $weekNumber): void
    {
        $this->weekNumber = $weekNumber;
    }

    /**
     * @return int[]|string
     */
    public function getCurrentAffixes()
    {
        return self::$affixesTurn[($this->weekNumber + self::EU_DELAY) % count(self::$affixesTurn)];
    }

    public function getWednesday(): DateTimeImmutable
    {
        $wednesday = strtotime('wednesday +' . $this->weekNumber . ' week', self::EU_Start_Week);

        return (new DateTimeImmutable())->setTimestamp($wednesday);
    }

    public static function getCurrentWeekNumber(): float
    {
        $week0 = (new DateTimeImmutable())->setTimestamp(self::EU_Start_Week);

        $now = strtotime('now');
        $startWeek = strtotime('this Tuesday -6 day + 9 hour', $now);
        $endWeek = strtotime('this Tuesday +32 hour +59 minute +59 second', $now);
        if (!($now >= $startWeek && $now <= $endWeek)) {
            $startWeek = strtotime('this Tuesday +1 week -6 day + 9 hour', $now);
            $endWeek = strtotime('this Tuesday +1 week +32 hour +59 minute +59 second', $now);
            if (!($now >= $startWeek && $now <= $endWeek)) {
                $startWeek = strtotime('this Tuesday -1 week -6 day + 9 hour', $now);
                $endWeek = strtotime('this Tuesday -1 week +32 hour +59 minute +59 second', $now);
            }
        }

        $thisWeek = (new DateTimeImmutable())->setTimestamp($startWeek);

        return floor($week0->diff($thisWeek)->format('%a') / 7);
    }
}
