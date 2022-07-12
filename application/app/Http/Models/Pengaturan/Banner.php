<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{

	use SoftDeletes;
    protected $table = 'banners';
	protected $primaryKey = 'id';
    protected $appends = ['banner_url', 'banner_url_thumb'];

    protected $fillable = [
        'banner_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getBannerUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->banner_path;
    }

    public function getBannerUrlThumbAttribute()
    {
        return asset('application/public/storage') . '/' . $this->banner_path_thumb;
    }

    public static function imageThumb()
    {
        $data = Banner::get();
        foreach ($data as $item) {
            \Storage::makeDirectory('thumbnails/banners');
            if($item->banner_path_thumb && file_exists(storage_path('app/public/' . $item->banner_path_thumb))) {
                unlink(storage_path('app/public/'.$item->banner_path_thumb));
            }

            if($item->banner_path && file_exists(storage_path('app/public/' . $item->banner_path))) {
                $img = \Image::make(storage_path('app/public/' . $item->banner_path));
                $img->resize(1600, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $item->banner_path));
                $item->banner_path_thumb = 'thumbnails/'.$item->banner_path;
                $item->save();
            }
        }
    }
}
