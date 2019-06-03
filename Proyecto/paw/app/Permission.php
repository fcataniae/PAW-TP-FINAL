<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

	protected $table = 'permissions';
    
    protected $fillable = ['id','description','estado','name', 'display_name'];

    public function roles() {
    	return $this->belongsToMany('App\Role');
    }

}
