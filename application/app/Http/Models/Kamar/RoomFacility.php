<?php

namespace TheFarrelHotel\Http\Models\Kamar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomFacility extends Model
{

    use SoftDeletes;
    protected $table = 'room_facilities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'facility_name', 'icon_fa', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function rrmfacility()
    {
         return $this->hasMany(RoomRoomFacility::class, 'rrm_id');
    }
}
