<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Around extends Model
{

	use SoftDeletes;
    protected $table = 'arounds';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url'];

    protected $fillable = [
       'around_name', 'around_name_eng', 'around_description_eng', 'around_description', 'path', 'link_map', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->path;
    }

}
