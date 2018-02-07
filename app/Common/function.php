<?php
/**
 * @author:alonexy
 *
 * 公用静态方法
 */
namespace App\Common;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use RedisDB;
class Functions
{
    /**
     * 邮件发送
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function email($data,$blade='open.email',$sub='缘竹科技开放平台开发者注册认证')
    {

        Mail::send($blade, $data, function($message) use($data,$sub)
        {
            $message->to($data['email'], $data['name'])->subject($sub);
        });
    }
    /**
     * 生成随机字符串
     * @param int       $length  要生成的随机字符串长度
     * @param string    $type    随机码类型：0，数字+大小写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
     * @return string
     */
    public static function randCode($length = 7, $type = 0) {
        $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
        if ($type == 0) {
            array_pop($arr);
            $string = implode("", $arr);
        } elseif ($type == "-1") {
            $string = implode("", $arr);
        } else {
            $string = $arr[$type];
        }
        $count = strlen($string) - 1;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $string[rand(0, $count)];
        }
        return $code;
    }

    public static function randomstring() {
        $str="abcdefghijkmnpqrstuvwxyz0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ";//设置被随机采集的字符串
        $codeLen='18';//设置生成的随机数个数        
        function  str_rand($str,$codeLen){
            $rand="";
            for($i=0; $i<$codeLen-1; $i++){
                $rand .= $str[mt_rand(0, strlen($str)-1)];  //如：随机数为30  则：$str[30]
            }
            return $rand;
        }
        $code=str_rand($str,$codeLen);
        return $code;
    }
    
    
    /*
     * 邮箱验证跳转邮箱登陆
     * */
    public static function gotoEmail($mail) {
        $emial = strrchr($mail, '@');
        $t = strtolower($emial);
        if ($t == '@163.com') {
            return 'mail.163.com';
        } else if ($t == '@vip.163.com') {
            return 'vip.163.com';
        } else if ($t == '@126.com') {
            return 'mail.126.com';
        } else if ($t == '@qq.com' || $t == 'vip.qq.com' || $t == 'foxmail.com') {
            return 'mail.qq.com';
        } else if ($t == '@gmail.com') {
            return 'mail.google.com';
        } else if ($t == '@sohu.com') {
            return 'mail.sohu.com';
        } else if ($t == '@tom.com') {
            return 'mail.tom.com';
        } else if ($t == '@vip.sina.com') {
            return 'vip.sina.com';
        } else if ($t == '@sina.com.cn' || $t == 'sina.com') {
            return 'mail.sina.com.cn';
        } else if ($t == '@tom.com') {
            return 'mail.tom.com';
        } else if ($t == '@yahoo.com.cn' || $t == 'yahoo.cn') {
            return 'mail.cn.yahoo.com';
        } else if ($t == '@tom.com') {
            return 'mail.tom.com';
        } else if ($t == '@yeah.net') {
            return 'www.yeah.net';
        } else if ($t == '@21cn.com') {
            return 'mail.21cn.com';
        } else if ($t == '@hotmail.com') {
            return 'www.hotmail.com';
        } else if ($t == '@sogou.com') {
            return 'mail.sogou.com';
        } else if ($t == '@188.com') {
            return 'www.188.com';
        } else if ($t == '@139.com') {
            return 'mail.10086.cn';
        } else if ($t == '@189.cn') {
            return 'webmail15.189.cn/webmail';
        } else if ($t == '@wo.com.cn') {
            return 'mail.wo.com.cn/smsmail';
        } else if ($t == '@139.com') {
            return 'mail.10086.cn';
        } else {
            return 'www.ttqqa.com';
        }
    }

    /**
     * @param            $array
     * @param            $key
     * @param bool|FALSE $limit
     * @return array
     */
    public static function array_group($array, $key, $limit = false)
    {
        if (empty ($array) || !is_array($array)){
            return $array;
        }

        $_result = array ();
        foreach ($array as $item) {
            if ((isset($item->$key))) {
                $_result[$item->$key][] = $item;
            } else {
                $_result[count($_result)][] = $item;
            }
        }
        if (!$limit) {
            return $_result;
        }

        $result = array ();
        foreach ($_result as $k => $item) {
            $result[$k] = $item[0];
        }
        return $result;
    }

    /**
     * 验证手机号是否正确
     * @param INT $mobile
     */
    public static function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * 截取中文字符串
     * @param $text
     * @param $length
     * @return string
     */
    public static function subtext($text, $length)
    {
        if(mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8').'...';
        return $text;
    }
    /*
	*格式化显示时间
*/
    public static function getLastTimeFormt($time,$type=0){
        if($type==0) $f="m-d H:i";
        else if($type==1) $f="Y-m-d H:i";
        $agoTime = time() - $time;
        if ( $agoTime <= 60&&$agoTime >=0 ) {
            return $agoTime.'秒前';
        }elseif( $agoTime <= 3600 && $agoTime > 60 ){
            return intval($agoTime/60) .'分钟前';
        }elseif( $agoTime <= 86400 && $agoTime > 3600 ){
            return intval($agoTime/3600) .'小时前';
        }elseif( $agoTime <= 604800 && $agoTime > 86400 ){
            return intval($agoTime/86400) .'天前';
        }else{
            return '一周前';
        }
    }
    /*
     *  格式化显示时间
     */
    public static function getCycleTime($timestart,$timeover){

        $timeCycle = $timeover - $timestart;
        if($timeCycle < 3600 && $timeCycle >= 0){
            return intval($timeCycle/60) .'分钟';
        }elseif($timeCycle > 3600 && $timeCycle < 86400){
            return intval($timeCycle/3600) .'小时';
        }else{

            return intval($timeCycle/86400) .'天';
        }
    }
    /**
     * 发送json 数据
     *
     * @param array $content 要传递的参数数组
     * array('msg'=>'','data'=>array(),'status'=>'')
     */
    public static function sendjson($content)
    {
        echo json_encode($content);
        exit();
    }
    /**
     * 获取客户端ip
     *
     * @return string 客户端ip字符串,xxx.xxx.xxx.xxx格式
     */
    public static function getClientIp() {
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //处理多层代理的情况,或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        if (false !== strpos($ip, ',')) {
            $ip = reset(explode(',', $ip));
        }
        return $ip;
    }
    /**
     * 获取用户APIKEY生成
     * @param integer $userid
     * return string
     */

    public static function getapikey($userid=0)
    {
        if( $userid <= 0 || !is_numeric($userid) ){
            return 0;
        }

        $randstr = uniqid();
        $ip      = self::getClientIp();
        return md5($userid.$randstr.$ip);
    }
    //PHP stdClass Object转array
    public static function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }
    //生产唯一通行编码
    public static function uuids($prefix=''){
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }
    /**
     * 验证身份证号
     * @param $vStr
     * @return bool
     */
    public static function isCreditNo($vStr)
    {
        $vCity = array(
            '11','12','13','14','15','21','22',
            '23','31','32','33','34','35','36',
            '37','41','42','43','44','45','46',
            '50','51','52','53','54','61','62',
            '63','64','65','71','81','82','91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18)
        {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18)
        {
            $vSum = 0;

            for ($i = 17 ; $i >= 0 ; $i--)
            {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
            }

            if($vSum % 11 != 1) return false;
        }

        return true;
    }
    /**
    * 移除Html代码中的XSS攻击
    */
    public static function remove_xss($val) {
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
            $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val);
        }
        $ra1 = array('expression', 'applet', 'meta','script','xml', 'blink', 'link', 'style', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true;
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2);
                $val = preg_replace($pattern, $replacement, $val);
                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        return $val;
    }
    //获取 长度的数字
   public static function generate_code($length = 6) {
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }
    /**
    * 判断是否是json
     */
    public static function is_json($string) {
        @json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 检查用户apikey 同时返回用户资料
     * @param int    $userid    Y
     * @param string $apikey    Y
     * @param int    $flag      N 0 不返回资料 1 返回
     * @return json string
     */
    public static function check_apikey($userid,$apikey,$flag=0)
    {
        if(!is_numeric($userid) || strlen(trim($apikey))<=0){
            self::sendjson(array('msg'=>'UID或者APIKEY参数非法','data'=>array(),'status'=>50000));
        }
        $info = \RedisDB::get(env('FOREX_UID_PROFIX','forex:User:ID_').$userid);
        $info = json_decode($info,TRUE);
        if(empty($info)){
            $data['flag']   = 1;
            self::sendjson(array('msg'=>'缓存失效,重新登录.','data'=>$data,'status'=>50001,'code'=>'E1000003'));
        }
        if($info['apikey']!=$apikey){
            $data['apikey'] = $info['apikey'];
            $data['flag']   = 1;
            self::sendjson(array('msg'=>'您的账户已经在其他设备登录','data'=>$data,'status'=>50002,'code'=>'E1000004'));
        }
        if($flag){
            return $info;
        }
    }
    /**
     * 生成订单号
     */
    public static function create_order_code(){
        list ( $usec, $sec ) = explode ( " ", microtime () );
        $usec = substr ( str_replace ( '0.', '', $usec ), 0, 4 );
        $str = rand ( 10, 99 );
        return date ( "YmdHis" ) . $usec . $str;
    }
    // 使用curl模拟get
    public static function curlGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    // curl post
    public static function curlPost($url,$data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        }

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
    //xml  转 array
    public static function xml_to_json($source,$flag=FALSE) {
        if(is_file($source)){ //传的是文件，还是xml的string的判断
            $xml_array=simplexml_load_file($source);
        }else{
            $xml_array=simplexml_load_string($source);
        }
        if($flag)
        {
            return $xml_array;
        }
        $json = json_encode($xml_array); //php5，以及以上，如果是更早版本，请查看JSON.php
        return $json;
    }
    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $user_name 姓名
     * @return string 格式化后的姓名
     */
    public static function substr_cut($user_name){
        $strlen      = mb_strlen($user_name, 'utf-8');
        $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
    }
    //删除空格和回车
    public static  function trimall($str){
        $qian=array(" ","　","\t","\n","\r");
        return str_replace($qian, '', $str);
    }
    // 转换时间差
    public static function timediff($begin_time,$end_time,$diff=0,$type=0)
    {
        if(empty($diff)){
            if($begin_time < $end_time){
                $starttime = $begin_time;
                $endtime = $end_time;
            }else{
                $starttime = $end_time;
                $endtime = $begin_time;
            }
            //计算天数
            $timediff = $endtime-$starttime;
        }else{
            $timediff = $diff;
        }

        $days = intval($timediff/86400);
        //计算小时数
        $remain = $timediff%86400;
        $hours = intval($remain/3600);
        //计算分钟数
        $remain = $remain%3600;
        $mins = intval($remain/60);
        //计算秒数
        $secs = $remain%60;
        $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
        if($type){
            if(intval($timediff/86400) == 0)
            {
                return [false,$res];
            }
            return [true,intval($timediff/86400)]; //天
        }
        return $res;
    }
    //二维码数组排序
    public static function arrays_sort_by_item($arr,$direction='SORT_DESC',$field='id')
    {
        $sort = array(
            'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => $field,       //排序字段
        );
        $arrSort = array();
        foreach($arr AS $uniqid => $row){
            foreach($row AS $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }
        return $arr;
    }
    /**
     * 检查用户apikey 同时返回用户资料
     * @param int    $userid    Y
     * @param string $apikey    Y
     * @param int    $flag      N 0 不返回资料 1 返回
     * @return json string
     */
    public static function check_apikey_status($userid,$apikey,$flag=0)
    {
        $redis  = \RedisDB::connection('default');
        if(!is_numeric($userid) || strlen(trim($apikey))<=0){
            self::sendjson(array('msg'=>'UID或者APIKEY参数非法','data'=>array(),'status'=>50000));
        }
        $info = $redis->get('User:UID_'.$userid);
        $info = json_decode($info,true);
        if(empty($info)){
            $data['flag']   = 1;
            self::sendjson(array('msg'=>'登陆过期,请重新登录','data'=>$data,'status'=>50001,'code'=>'E1000003'));
        }
        if($info['apikey']!=$apikey){
            $data['apikey'] = $info['apikey'];
            $data['flag']   = 1;
            self::sendjson(array('msg'=>'您的账户已经在其他设备登录','data'=>$data,'status'=>50002,'code'=>'E1000004'));
        }
        if($flag){
            return $info;
        }
    }

    public static function alertJump($msg,$url='/')
    {
        echo "<script>";
        echo "alert('".$msg."');";
        echo "window.location.href='".$url."';";
        echo "</script>";
        exit;
    }

    /**
     * @name 获取消息主体
     * @param string $msg
     * @param array $arr
     * @param int $code
     * @return array
     */
    public static function getMessageBody($msg='系统错误',$arr=[],$code=0)
    {
        $data = array();
        $data['msg']  = "{$msg}";
        if(empty($arr)){
            $data['data'] = (object)$arr;
        }else{
            $data['data'] = $arr;
        }

        $data['status'] = $code;
        return $data;
    }
    /**
     * 验证密码规则
     * 必须且只含有数字和字母,不小于6位
     * @param $passwd
     * @return int
     */
    public static function checkPasswd($passwd)
    {
        return preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,}$/', $passwd);
    }
    /**
     * @name 自定义系统日志位置
     * @param string $name
     */
    public static function SysLog($name='debug',$msg='--',$errData=0,$type='info')
    {
        $logStorage = env('LOG_STORAGE',false);
        if( $logStorage == 'mongodb'){
            DB::connection('mongodb')       //选择使用mongodb
            ->collection($name.'_'.date('Ymd'))           //选择使用users集合
            ->insert([                          //插入数据
                'message'  => $msg,
                'log'      => $errData,
                'type'     => $type,
                'time'   => time()
            ]);
        }
        $log = new Logger(env('APP_ENV',$name));
        $logDir = storage_path("logs/{$name}");
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $log->pushHandler(new StreamHandler($logDir . '/laravel-' . date('Y-m-d') . '.log'));
        $log->pushHandler(new FirePHPHandler());
        if(empty($errData)){
            $errData = ['time'=>time()];
        }
        if(!in_array($type,['emergency','alert','critical','error','warning','notice','info','debug'])){
            $type='info';
        }
        $log->$type($msg,['log'=>$errData]);
    }

    /**
     * 判断是否是时间格式
     * @param $dateTime
     * @return bool
     */
    public static function isDateTime($dateTime){
        $ret = strtotime($dateTime);
        return $ret !== FALSE && $ret != -1;
    }
    /**
     * @name  获取策略直播用户列表
     */
    public static function getStrateUsersConfig()
    {
        //listen_ignore 1 开启严格模式  0关闭
        if(env('STRATE_SATATUS') == 'TEST'){
            $configs = file_get_contents('http://www.tbjapi.com/live_h5/article_type.json');
        }else{
            $configs = file_get_contents('http://www.tubiaojia.com/live_h5/article_type.json');
        }
        if(Functions::is_json($configs)){
            $configs = json_decode($configs,true);
        }
        foreach($configs as $key=>$val)
        {
            if($val['live_type'] !== 'zhimafx')
            {
                unset($configs[$key]);
            }
        }
        return $configs;
    }
    //将数字转成汉字对应的月份
    public static function str_to_month($str1)
    {
        $str_n = null;
        switch($str1)
        {
            case 1:$str_n="一月";break;
            case 2: $str_n="二月";break;
            case 3:$str_n="三月";break;
            case 4:$str_n="四月";break;
            case 5:$str_n="五月";break;
            case 6:$str_n="六月"; break;
            case 7:$str_n="七月";break;
            case 8:$str_n="八月";break;
            case 9:$str_n="九月";break;
            case 10:$str_n="十月";break;
            case 11:$str_n="十一月";break;
            case 12:$str_n="十二月";break;
        }
        return $str_n;
    }

    public static function setUrlRandPr($url)
    {
        str_replace('?','',$url,$cnt);
        if ($cnt> 0)
        {
            return $url .'&h5viewrandp='.time().rand(10,99);
        } else {
            return $url .'?h5viewrandp='.time().rand(10,99);
        }
    }
}//++end
