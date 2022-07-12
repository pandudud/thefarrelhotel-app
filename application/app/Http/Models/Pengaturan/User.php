<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'is_active'	=> 'boolean',
        'is_heading' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'username', 'email', 'password', 'name', 'level_id', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function level()
    {
    	return $this->belongsTo(Level::class, 'level_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->formatLocalized('%e %B %Y');
    }

    public function isSuperadmin()
    {
        if(auth()->user()->level_id == 1)
            return true;
        return false;
    }
}
