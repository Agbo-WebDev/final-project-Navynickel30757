<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Listing extends Model
{
    protected $fillable = ['title', 'description', 'category', 'status', 'user_id', 'image'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function isRequested()
    {
        return $this->requests()
                    ->where('borrower_id', Auth::id())
                    ->where('status', 'requested')
                    ->exists();
    }
}
?>
