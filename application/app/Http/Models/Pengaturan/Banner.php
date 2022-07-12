<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{

	use SoftDeletes;
    protected $table = 'banners';
	protected $primaryKey = 'id';
    protected $appends = ['banner_url'];

    protected $fillable = [
        'banner_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getBannerUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->banner_path;
    }

}
