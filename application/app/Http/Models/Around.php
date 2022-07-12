<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Around extends Model
{

	use SoftDeletes;
    protected $table = 'arounds';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url', 'picture_url_thumb'];

    protected $fillable = [
       'around_name', 'around_name_eng', 'around_description_eng', 'around_description', 'path', 'link_map', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->path;
    }

    public function getPictureUrlThumbAttribute()
    {
        return asset('application/public/storage') . '/' . $this->path_thumb;
    }

    public static function imageThumb()
    {
        $data = Around::get();
        foreach ($data as $item) {
            \Storage::makeDirectory('thumbnails/arounds');
            if($item->path_thumb && file_exists(storage_path('app/public/' . $item->path_thumb))) {
                unlink(storage_path('app/public/'.$item->path_thumb));
            }

            if($item->path && file_exists(storage_path('app/public/' . $item->path))) {
                $img = \Image::make(storage_path('app/public/' . $item->path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $item->path));
                $item->path_thumb = 'thumbnails/'.$item->path;
                $item->save();
            }
        }
    }

}
