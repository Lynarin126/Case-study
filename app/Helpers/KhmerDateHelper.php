<?php

namespace App\Helpers;

use Carbon\Carbon;

class KhmerDateHelper
{
    private static array $khmerNums = ['០','១','២','៣','៤','៥','៦','៧','៨','៩'];
    private static array $weekdays = ['ថ្ងៃអាទិត្យ', 'ថ្ងៃច័ន្ទ', 'ថ្ងៃអង្គារ', 'ថ្ងៃពុធ', 'ថ្ងៃព្រហស្បតិ៍', 'ថ្ងៃសុក្រ', 'ថ្ងៃសៅរ៍'];
    private static array $solarMonths = ['', 'មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];
    private static array $animals = ['ជូត', 'ឆ្លូវ', 'ខាល', 'ថោះ', 'រោង', 'ម្សាញ់', 'មមី', 'មមែ', 'វក', 'រកា', 'ច', 'កុរ'];
    private static array $saks = ['សំរឹទ្ធិស័ក', 'ឯកស័ក', 'ទោស័ក', 'ត្រីស័ក', 'ចត្វាស័ក', 'បញ្ចស័ក', 'ឆស័ក', 'សប្តស័ក', 'អដ្ឋស័ក', 'នព្វស័ក'];
    private static array $lunarMonths = ['មិគសិរ', 'បុស្ស', 'មាឃ', 'ផល្គុន', 'ចេត្រ', 'ពិសាខ', 'ជេស្ឋ', 'អាសាឍ', 'ស្រាពណ៍', 'ភទ្របទ', 'អស្សុជ', 'កត្តិក'];

    public static function toKhmerNum(int|string $num): string
    {
        return str_replace(['0','1','2','3','4','5','6','7','8','9'], self::$khmerNums, (string) $num);
    }

    private static function aharakoune(int $y): int { return ($y * 292207 + 373) % 800; }
    private static function harakoune(int $y): int { return (int) floor(($y * 292207 + 373) / 800) + 1; }
    private static function avomane(int $y): int { return (11 * self::harakoune($y) + 650) % 692; }
    private static function regularLeap(int $y): bool { return (800 - self::aharakoune($y)) <= 207; }

    private static function bodethey(int $y): int
    {
        $ha = self::harakoune($y);
        return ($ha + (int) floor((11 * $ha + 650) / 692)) % 30;
    }

    private static function jaisLeap(int $y): bool
    {
        $b0 = self::bodethey($y);
        $b1 = self::bodethey($y + 1);
        return $b0 > 24 || $b0 < 6 || ($b0 === 24 && $b1 === 6) || ($b0 === 25 && $b1 === 5);
    }

    private static function greatLeap(int $y): bool
    {
        $value = self::isProtetinLeap($y);
        if (self::jaisLeap($y) && $value) {
            $value = false;
        }
        return $value;
    }

    private static function isProtetinLeap(int $y): bool
    {
        $avomane0 = self::avomane($y);
        $avomane1 = self::avomane($y + 1);
        $normal = self::regularLeap($y);
        $value = $normal && $avomane0 < 127;

        if (!$normal) {
            if ($avomane0 === 137 && $avomane1 === 0) {
                $value = false;
            } elseif ($avomane0 < 138) {
                $value = true;
            }
        }

        if (!$value) {
            $value = self::isProtetinLeap($y - 1) && self::jaisLeap($y - 1);
        }
        return $value;
    }

    private static function daysInYear(int $year): int
    {
        if (self::jaisLeap($year)) return 384;
        if (self::greatLeap($year)) return 355;
        return 354;
    }

    private static function lunarDiffDays(Carbon $end): int
    {
        $count = 0;
        $x = 1970 - 638 + 1;
        $y = $end->year - 638;
        if ($x > $y) {
            $tmp = $x; $x = $y; $y = $tmp;
        }
        while ($x < $y) {
            $count += self::daysInYear($x++);
        }
        return $count;
    }

    private static function diffDays(Carbon $end): int
    {
        // Gist: Math.round(( (end - 7h) - 286596e5) / 86400000)
        // 286596e5 ms = 28659600s
        $adjustedTimestamp = $end->timestamp - (7 * 3600);
        return abs((int) round(($adjustedTimestamp - 28659600) / 86400));
    }

    private static function monthsOfYear(int $year): array
    {
        $ath = self::jaisLeap($year);
        $great = self::greatLeap($year);
        $items = [];
        $total = 12 + ($ath ? 1 : 0);
        for ($i = 0; $i < $total; $i++) {
            $j = $i;
            if ($ath && $j >= 8) {
                $j--;
            }
            $items[] = 29 + ($j % 2 != 0 ? 1 : 0) + ($j == 6 && $great ? 1 : 0);
        }
        return $items;
    }

    public static function format(?Carbon $date = null): array
    {
        $date = $date ? $date->copy() : Carbon::now('Asia/Phnom_Penh');
        $date = $date->setTimezone('Asia/Phnom_Penh')->setTime(12, 0, 0);

        $solarDay = $date->day;
        $solarMonth = $date->month;
        $solarYear = $date->year;
        $dayOfWeek = self::$weekdays[$date->dayOfWeek];

        $CE = $date->year;
        $y = $CE - 638;
        $day = abs(self::diffDays($date) - self::lunarDiffDays($date)) + 1;
        $BE = $CE + 543 + ($day > 162 ? 1 : 0);

        $len = self::daysInYear($y);
        if ($day > $len) {
            $day -= $len;
            $y++;
        }

        $m = 0;
        foreach (self::monthsOfYear($y) as $monthDays) {
            if ($day <= $monthDays) {
                break;
            }
            $day -= $monthDays;
            $m++;
        }

        $lunarDayNum = $day <= 15 ? $day : $day - 15;
        $lunarMoon = $day <= 15 ? 'កើត' : 'រោច';
        $lunarMonthIndex = max(0, $m - 1) % count(self::$lunarMonths);
        $lunarMonthName = self::$lunarMonths[$lunarMonthIndex];
        $animal = self::$animals[($CE + 8) % 12];
        $CS = $CE - 638;
        $sak = self::$saks[$CS % 10];

        $lunarText = "{$dayOfWeek} " . self::toKhmerNum($lunarDayNum) . "{$lunarMoon} ខែ{$lunarMonthName} ឆ្នាំ{$animal} {$sak} ព.ស " . self::toKhmerNum($BE);
        $solarText = "{$dayOfWeek} ទី" . self::toKhmerNum($solarDay) . " ខែ" . self::$solarMonths[$solarMonth] . " ឆ្នាំ" . self::toKhmerNum($solarYear);

        return [
            'lunar' => $lunarText,
            'solar' => $solarText,
            'full' => "{$lunarText} ត្រូវនឹង {$solarText}",
        ];
    }
}
