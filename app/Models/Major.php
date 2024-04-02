<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOption\None;

class Major extends Model
{
    use HasFactory;

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function total_book_borrowed($start_date=NULL, $end_date=NULL)
    {
        $major_id = $this->id;

        $move_ids = BookMove::whereIn('user_id', function($query) use ($major_id) {
            $query->select('id')->from('users')->where('major_id', $major_id);
        });

            
        if ($start_date !== null) {
            $move_ids->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date !== null) {
            $move_ids->whereDate('created_at', '<=', $end_date);
        }

        $move_ids = $move_ids->get();

        return count($move_ids);
    }
    
    public function total_visitors($start_date=NULL, $end_date=NULL)
    {
        $major_id = $this->id;

        $history_ids = LoginHistory::whereIn('user_id', function($query) use ($major_id) {
            $query->select('id')->from('users')->where('major_id', $major_id);
        });

        if ($start_date !== null) {
            $history_ids->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date !== null) {
            $history_ids->whereDate('created_at', '<=', $end_date);
        }

        $history_ids = $history_ids->get();

        return count($history_ids);
    }
}
