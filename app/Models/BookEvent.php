<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'people_count',
    ];

    public static function calculatePeopleCount($user_id): void
    {
        $total = Peoples::where(['user_id' => $user_id])->count();
        BookEvent::where(["user_id" => $user_id])->update(["people_count" => $total + 1]);
        self::calculateAllPeopleCount();
    }
    public static function calculateAllPeopleCount(): void
    {
        foreach (Event::all() as $event) {
            $count = 0;
            foreach (BookEvent::all() as $book_event) {
                if($event->id === $book_event->event_id) {
                    $count += $book_event->people_count;
                }
            }
            Event::where(["id" => $event->id])->update(["current_people" => $count]);
        }
    }
}
