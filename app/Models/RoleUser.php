<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Zizaco\Entrust\EntrustRole;

class RoleUser extends EntrustRole
{
    protected $fillable = ['user_id','role_id'];

    public function users()
    {
        return $this->belongsToMany(
            Config::get('auth.providers.users.model'),
            Config::get('entrust.role_user_table'),
            Config::get('entrust.role_foreign_key'),
            Config::get('entrust.user_foreign_key'));

    }
}
