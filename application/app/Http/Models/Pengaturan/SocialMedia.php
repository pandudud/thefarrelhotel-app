<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{

	use SoftDeletes;
    protected $table = 'social_medias';
	protected $primaryKey = 'id';

    protected $fillable = [
        'instagram', 'facebook', 'twitter', 'youtube', 'updated_at'];

    protected $dates = ['deleted_at'];

}
