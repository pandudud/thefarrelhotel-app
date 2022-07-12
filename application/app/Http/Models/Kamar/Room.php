<?php

namespace TheFarrelHotel\Http\Models\Kamar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{

    use SoftDeletes;
    protected $table = 'rooms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'room_name', 'room_name_eng', 'room_name_slug',  'room_price', 'room_description', 'room_description_eng', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function rrmroom()
    {
        return $this->hasMany(RoomRoomFacility::class, 'room_id');
    }

    public function detailroom()
    {
        return $this->hasMany(DetailRoom::class, 'room_id');
    }

    public function first_detailroom()
    {
        return $this->hasOne(DetailRoom::class, 'room_id');
    }
}
