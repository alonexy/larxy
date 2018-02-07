<?php

/*
|--------------------------------------------------------------------------
| 路由分割
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

foreach(File::allFiles(__DIR__.'/routes') as $partial)
{
    require_once $partial->getPathname();
}