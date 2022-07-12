<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailEvent extends Model
{

	use SoftDeletes;
    protected $table = 'picture_events';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url', 'picture_url_thumb'];

    protected $fillable = [
        'event_id', 'picture_event', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_event;
    }

    public function getPictureUrlThumbAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_event_thumb;
    }

    public static function imageThumb()
    {
        $data = DetailEvent::get();
        foreach ($data as $item) {
            \Storage::makeDirectory('thumbnails/picture_events');
            if($item->picture_event_thumb && file_exists(storage_path('app/public/' . $item->picture_event_thumb))) {
                unlink(storage_path('app/public/'.$item->picture_event_thumb));
            }

            if($item->picture_event && file_exists(storage_path('app/public/' . $item->picture_event))) {
                $img = \Image::make(storage_path('app/public/' . $item->picture_event));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $item->picture_event));
                $item->picture_event_thumb = 'thumbnails/'.$item->picture_event;
                $item->save();
            }
        }
    }
}
