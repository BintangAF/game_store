<?php

namespace App\Support;

use App\Models\Game;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Pemberitahuan yang bergeser di header (komponen ui/ticker).
 * Dua jenis: game yang banyak dimiliki orang, dan game yang segera rilis.
 *
 * Bentuk tiap item (dibaca view lewat $headerNotices):
 *   ['label' => 'Populer', 'tone' => 'sage', 'text' => '12 orang sudah memiliki Game 1', 'href' => url]
 */
class HeaderNotices
{
    private const CACHE_KEY = 'header_notices';
    private const CACHE_SECONDS = 600; // hitung ulang tiap 10 menit, bukan di setiap halaman

    public static function get(): array
    {
        // Yang disimpan di cache hanya data mentah. Alamat (URL) dibuat setiap request
        // supaya tidak terkunci pada host tertentu (localhost atau 127.0.0.1).
        $raw = Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, fn () => self::build());

        return array_map(function (array $notice) {
            $notice['href'] = route('games.show', $notice['game_id']);
            unset($notice['game_id']);

            return $notice;
        }, $raw);
    }

    private static function build(): array
    {
        return self::interleave(self::popular(), self::upcoming());
    }

    /** Game dengan pembeli terbanyak (hitung pengguna berbeda dari pesanan berstatus paid). */
    private static function popular(): array
    {
        $rows = OrderItem::query()
            ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
            ->where('orders.status', 'paid')
            ->groupBy('order_items.game_id')
            ->selectRaw('order_items.game_id, count(distinct orders.user_id) as buyers')
            ->orderByDesc('buyers')
            ->take(3)
            ->get();

        $games = Game::active()->whereIn('game_id', $rows->pluck('game_id'))->get()->keyBy('game_id');

        $notices = [];
        foreach ($rows as $row) {
            if (! $game = $games->get($row->game_id)) {
                continue;
            }

            $notices[] = [
                'label' => 'Populer',
                'tone' => 'sage',
                'text' => number_format($row->buyers, 0, ',', '.').' orang sudah memiliki '.$game->game_title,
                'game_id' => $game->game_id,
            ];
        }

        return $notices;
    }

    /** Game yang tanggal rilisnya masih di depan, yang terdekat lebih dulu. */
    private static function upcoming(): array
    {
        $today = Carbon::today();

        return Game::active()
            ->where('release_date', '>', $today->toDateString())
            ->orderBy('release_date')
            ->take(3)
            ->get()
            ->map(function (Game $game) use ($today) {
                $days = (int) abs($today->diffInDays($game->release_date->startOfDay()));
                $when = $days <= 1 ? 'besok' : "dalam {$days} hari";

                return [
                    'label' => 'Segera',
                    'tone' => 'accent',
                    'text' => "{$game->game_title} rilis {$when} ({$game->release_date->format('d/m/Y')})",
                    'game_id' => $game->game_id,
                ];
            })
            ->all();
    }

    /** Selang-seling dua daftar supaya kedua jenis pemberitahuan bergantian muncul. */
    private static function interleave(array $a, array $b): array
    {
        $result = [];
        for ($i = 0, $max = max(count($a), count($b)); $i < $max; $i++) {
            foreach ([$a, $b] as $list) {
                if (isset($list[$i])) {
                    $result[] = $list[$i];
                }
            }
        }

        return $result;
    }
}
