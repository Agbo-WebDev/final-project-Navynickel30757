<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    protected $fillable = ['listing_id', 'borrower_id', 'start_date', 'end_date', 'status'];

    public function listing() {
        return $this->belongsTo(Listing::class);
    }

    public function borrower() {
        return $this->belongsTo(User::class, 'borrower_id');
    }
}
