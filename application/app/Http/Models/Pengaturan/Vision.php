<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vision extends Model
{

	use SoftDeletes;
    protected $table = 'visions';
	protected $primaryKey = 'id';

    protected $fillable = [
        'vision', 'vision_eng', 'mission', 'mission_eng', 'updated_at'];

    protected $dates = ['deleted_at'];

}
