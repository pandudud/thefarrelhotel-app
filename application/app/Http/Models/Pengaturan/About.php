<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{

	use SoftDeletes;
    protected $table = 'abouts';
	protected $primaryKey = 'id';

    protected $fillable = [
        'about_us', 'about_us_eng', 'updated_at'];

    protected $dates = ['deleted_at'];

}
