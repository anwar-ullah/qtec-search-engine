<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemInformation extends Model
{
    protected $fillable = [
    	'name',
        'phone',
        'mobile',
        'address',
        'email',
        'twitter',
        'facebook',
        'instagram',
        'skype',
        'linked_in',
        'logo',
        'icon',
        'report_file',
        'report_file_info',
        'status',
    ];
}
