## 一个基于laravel5.1的后台系统

模版采用 Adminlte.io
样式参照：[Adminlte.io](https://adminlte.io/themes/AdminLTE/index.html)
#### 执行命令
```
composer upadte

#配置完成后

php artisan migrate

php artisan db:seed --class=addAdminUserData
```

```
菜单生成规则

    Controllers/Admin/*

            ---xxxController.php
            ---xxxController.php
            ---xxxController.php
            ---xxxController.php

    /**
     * @Cname:控制面板            父级菜单名称
     * @Cstyle:fa-dashboard     菜单显示样式
     * @Csort:1                 排序
     */
    class HomeController extends Controller
    {
        /**
         * @Fname:首页      二级菜单名称
         * @Fdisplay:true   是否显示
         * @Fstyle:fa-circle-o   样式
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index(Request $request)
        {
                ...


```
## 配置
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=byYIgBzue7JzD22RB5edAYN01Tp6rM0t
APP_LOG=daily
LOG_STORAGE=false #日志存储（同时在mongodb存一份） LOG_STORAGE=mongodb
APP_MD5_SALT=FSUd52148e8

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis
CACHE_PREFIX=lar51

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=**
REDIS_DB='0'
REDIS_SESSION_DB=1
REDIS_PORT=6379

MG_HOST=192.168.0.51
MG_PORT=27017
MG_DB=admin
MG_USER=admin
MG_PASS=123321


MAIL_DRIVER=smtp
MAIL_HOST=smtp.exmail.qq.com
MAIL_PORT=465
MAIL_USERNAME=123321@qq.com
MAIL_PASSWORD=123321
MAIL_ENCRYPTION=ssl

```

## 其它
```
log控制台查看

http://{domain}/admin/log-viewer?f=二级的文件夹名称
```



