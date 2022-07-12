<?php

namespace TheFarrelHotel\Http\Models\Kamar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomRoomFacility extends Model
{

    use SoftDeletes;
    protected $table = 'room_room_facilities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'room_id', 'room_facility_id', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function roomfacility()
    {
        return $this->belongsTo(RoomFacility::class, 'room_facility_id', 'id');
    }

    public function roomkamar()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
