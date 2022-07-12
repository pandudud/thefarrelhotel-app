<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{

	use SoftDeletes;
    protected $table = 'galleries';
	protected $primaryKey = 'id';
    protected $appends = ['gallery_url', 'gallery_url_thumb'];

    protected $fillable = [
        'id', 'gallery_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getGalleryUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->gallery_path;
    }

    public function getGalleryUrlThumbAttribute()
    {
        return asset('application/public/storage') . '/' . $this->gallery_path_thumb;
    }

    public static function imageThumb()
    {
        $data = Gallery::get();
        foreach ($data as $item) {
            \Storage::makeDirectory('thumbnails/galleries');
            if($item->gallery_path_thumb && file_exists(storage_path('app/public/' . $item->gallery_path_thumb))) {
                unlink(storage_path('app/public/'.$item->gallery_path_thumb));
            }

            if($item->gallery_path && file_exists(storage_path('app/public/' . $item->gallery_path))) {
                $img = \Image::make(storage_path('app/public/' . $item->gallery_path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $item->gallery_path));
                $item->gallery_path_thumb = 'thumbnails/'.$item->gallery_path;
                $item->save();
            }
        }
    }

}
