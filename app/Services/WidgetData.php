<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WidgetData
{
    public static function getData(string $group, int $userId, string $type = 'last', string $period = 'day', int $count = 5): \Illuminate\Support\Collection
    {

        $date = Carbon::now();
        $donationsQuery = DB::table('donations')
            ->where('user_to', $userId)
            ->limit($count);
        if ($type !== 'all') {
            ($type === 'last' ? $date->sub(1, $period) : $date->startOf($period));
            $donationsQuery->whereBetween('created_at', [$date, Carbon::now()]);
        }
        switch ($group) {
            case 'donators':
                $donationsQuery
                    ->orderBy('sum', 'desc')
                    ->select('donation_sender', DB::raw('sum(`sum`) as sum'))
                    ->groupBy('donation_sender');
                break;
            case 'donations':
                $donationsQuery
                    ->orderBy('sum', 'desc');
                break;
            default:
                $donationsQuery
                    ->orderBy('created_at', 'desc');
        }

        return $donationsQuery->get();
    }
}
