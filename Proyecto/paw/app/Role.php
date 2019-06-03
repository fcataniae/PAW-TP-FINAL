<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

	protected $table = 'roles';
    
    protected $fillable = ['id','description','estado','name', 'display_name'];

    public function permissions() {
    	return $this->belongsToMany('App\Permission');
    }

    public function users() {
    	return $this->belongsToMany('App\User', 'role_user');
  	}
}
