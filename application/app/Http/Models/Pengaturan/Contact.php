<?php

namespace TheFarrelHotel\Http\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{

	use SoftDeletes;
    protected $table = 'contacts';
	protected $primaryKey = 'id';

    protected $fillable = [
        'contact_name', 'contact_phone', 'contact_email', 'contact_address', 'contact_website', 'updated_at'];

    protected $dates = ['deleted_at'];

}
