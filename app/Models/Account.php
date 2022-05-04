<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'balance'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance / 100, 2);
    }
}
