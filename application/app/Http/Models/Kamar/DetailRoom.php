<?php

namespace TheFarrelHotel\Http\Models\Kamar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRoom extends Model
{

	use SoftDeletes;
    protected $table = 'picture_rooms';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url'];

    protected $fillable = [
        'room_id', 'picture_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_path;
    }
}
