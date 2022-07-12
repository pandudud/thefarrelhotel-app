<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailEvent extends Model
{

	use SoftDeletes;
    protected $table = 'picture_events';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url'];

    protected $fillable = [
        'event_id', 'picture_event', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_event;
    }
}
