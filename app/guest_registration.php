<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestRegistration extends Model
{
    //
    protected $table = 'guest_registration';
    protected $primaryKey = 'id';
    protected $fillable=
    [
        'personal_id',
        'first_name',
        'last_name',
        'email_address',
        'brand',
        'email_list_flag',
        'ship',
        'sail_date',
        'comments'
    ];
}
