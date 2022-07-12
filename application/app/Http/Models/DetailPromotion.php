<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPromotion extends Model
{

	use SoftDeletes;
    protected $table = 'picture_promotions';
	protected $primaryKey = 'id';
    protected $appends = ['picture_url'];

    protected $fillable = [
        'promotion_id', 'picture_path', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function getPictureUrlAttribute()
    {
        return asset('application/public/storage') . '/' . $this->picture_path;
    }
}
