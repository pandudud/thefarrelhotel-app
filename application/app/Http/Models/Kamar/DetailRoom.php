<?php

namespace TheFarrelHotel\Http\Models\Kamar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRoom extends Model
{

	use SoftDeletes;
    protected $table = 'picture_rooms';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url', 'picture_url_thumb'];

    protected $fillable = [
        'room_id', 'picture_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_path;
    }

    public function getPictureUrlThumbAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_path_thumb;
    }

    public static function imageThumb()
    {
        $data = DetailRoom::get();
        foreach ($data as $item) {
            \Storage::makeDirectory('thumbnails/picture_rooms');
            if($item->picture_path_thumb && file_exists(storage_path('app/public/' . $item->picture_path_thumb))) {
                unlink(storage_path('app/public/'.$item->picture_path_thumb));
            }

            if($item->picture_path && file_exists(storage_path('app/public/' . $item->picture_path))) {
                $img = \Image::make(storage_path('app/public/' . $item->picture_path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $item->picture_path));
                $item->picture_path_thumb = 'thumbnails/'.$item->picture_path;
                $item->save();
            }
        }
    }
}
