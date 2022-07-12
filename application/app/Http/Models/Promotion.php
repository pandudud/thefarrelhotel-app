<?php

namespace TheFarrelHotel\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{

	use SoftDeletes;
    protected $table = 'promotions';
	protected $primaryKey = 'id';

    protected $fillable = [
        'promotion_name', 'promotion_name_eng', 'promotion_name_slug', 'promotion_description', 'promotion_description_eng', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function detailpromotion()
    {
        return $this->hasMany(DetailPromotion::class, 'promotion_id');
    }

    public function first_detailpromotion()
    {
        return $this->hasOne(DetailPromotion::class, 'promotion_id');
    }
}
