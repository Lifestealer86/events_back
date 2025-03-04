<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'event_id',
        'text',
        'img_raiting',
        'raiting'
    ];

    public static function calculateRaiting($event_id, $new_raiting = null): void
    {
        $query = self::where('event_id', $event_id);

        $stats = $query->selectRaw('COUNT(*) as count, COALESCE(SUM(raiting), 0) as sum')
            ->first();
        $total_sum = $stats->sum + ($new_raiting ?? 0);
        $total_count = $stats->count + ($new_raiting !== null ? 1 : 0);

        $average = (int)($total_count > 0 ? $total_sum / $total_count : 0);
        Event::where(["id" => $event_id])->update(['raiting' => $average]);
    }
}
