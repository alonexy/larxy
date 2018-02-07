<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRolesModel extends Model
{
    protected $table = 'roles';
    protected $guarded  = [ ]; //黑名单  字段不可填充

    public function __construct()
    {
        parent::__construct();
    }

}
