<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{

	use SoftDeletes;
    protected $table = 'galleries';
	protected $primaryKey = 'id';
    protected $appends = ['gallery_url'];

    protected $fillable = [
        'id', 'gallery_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getGalleryUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->gallery_path;
    }

}
