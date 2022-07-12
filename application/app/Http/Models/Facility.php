<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{

	use SoftDeletes;
    protected $table = 'facilities';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url'];

    protected $fillable = [
        'facility_name', 'facility_name_eng', 'facility_description', 'facility_description_eng', 'path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->path;
    }
}
