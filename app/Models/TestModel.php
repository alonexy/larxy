<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'articles_strate';
    protected $guarded  = [ ]; //黑名单  字段不可填充
    public    $timestamps = false;
    public function __construct()
    {
        parent::__construct();
    }

}
