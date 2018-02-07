<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DemoModel extends Model
{
    public $tableName;
    public function __construct(){
        parent::__construct();
        $this->tableName = 'demo';

        $this->TablesInit();
    }

    /**
     * @name 初始化表
     *
     */
    public function TablesInit()
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function ($table) {
                $table->bigIncrements('id',20);
                $table->string('url')->comment('请求url');
                $table->string('action')->comment('请求action');
                $table->string('method')->comment('请求method');
                $table->text('params')->comment('请求参数');
                $table->text('return')->comment('返回');
                $table->string('req_time')->comment('请求时间');
                $table->string('httpcode')->comment('状态码');

                $table->integer('create_time')->comment('创建时间');
                $table->integer('update_time')->comment('更新时间');
            });
        }
    }

    /**
     * @name 插入数据
     * @param $addData
     * @return mixed
     */
    public function SaveData($addData){
        return DB::table($this->tableName)->insertGetId($addData);
    }

    /**
     * @name 获取数据记录
     * @return mixed
     */
    public function getDatas($page=1,$pageSize=10){
        $page = max(1,$page);
        $offset = ($page-1)*$pageSize;
        return DB::table($this->tableName)->skip($offset)->take($pageSize)->orderBy('id','desc')->get();
    }
    public function getTotal(){
        return DB::table($this->tableName)->count();
    }
}
