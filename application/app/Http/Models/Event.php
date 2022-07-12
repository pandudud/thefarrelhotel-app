<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{

	use SoftDeletes;
    protected $table = 'events';
	protected $primaryKey = 'id';

    protected $fillable = [
        'event_name', 'event_name_eng', 'event_name_slug', 'event_description', 'event_description_eng', 'event_slug', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function detailevent()
    {
        return $this->hasMany(DetailEvent::class, 'event_id');
    }

    public function first_detailevent()
    {
        return $this->hasOne(DetailEvent::class, 'event_id');
    }
}
