<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class proxyIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxyip:handle {type=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '代理ip池';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');

        if($type == 'ExtractIP'){ //执行爬取代理ip
            $this->getIps();
        }else if($type == 'VerifyIP'){ // ip 有效性测试

        }else{
            $this->error('type is not found!');
        }
    }

    public function getDatas($url='http://www.baidu.com',$proxy='',$proxyport='')
    {
        $CurlOptions = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_REFERER=>'http://www.baidu.com',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        );
        if($proxy){
            $CurlOptions[CURLOPT_PROXY] = $proxy;
            $CurlOptions[CURLOPT_PROXYPORT] = $proxyport;
        }
        $curl = curl_init();
        curl_setopt_array($curl, $CurlOptions);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return [false,$err];
        } else {
            return [true,$response];
        }
    }

    public function getIps()
    {
        $urlLists = [
            'xicidaili'=>[
                'urls'=>[
                    'http://www.xicidaili.com/wt/',
                    'http://www.xicidaili.com/nt/',
                    'http://www.xicidaili.com/nn/',
                ],
                'times'=>10
            ],
//            'kuaidaili'=>[
//                'urls'=>[
//                    'https://www.kuaidaili.com/free/inha/1/',
//                    'https://www.kuaidaili.com/free/inha/2/',
//                    'https://www.kuaidaili.com/free/intr/1/',
//                    'https://www.kuaidaili.com/free/intr/2/',
//                ],
//                'times'=>20
//            ],
//            'goubanjia'=>[
//                'urls'=>[
//                    'http://www.goubanjia.com',
//                ],
//                'times'=>20
//            ]

        ];
        while(true){
            try{
                foreach($urlLists as $lk=>$list){
                    foreach($list['urls'] as $url){
                        //                $dataSource = file_get_contents($url);
                        list($res,$dataSource) = $this->getDatas($url);
                        if(!$res){
                            continue;
                        }
                        $dataSource = preg_replace("/\\r\\n/", '', $dataSource);
                        $dataSource = preg_replace("/\\r/", '', $dataSource);
                        $dataSource = preg_replace("/\\n/", '', $dataSource);
                        $dataSource = preg_replace("/\\t/", '', $dataSource);
                        $dataSource = str_replace(" ", '', $dataSource);

                        if($lk == 'xicidaili'){
                            $reg = "/<trclass=[\"\w]+[^>].*?<td>([\d\.]+)<\/td><td>([\d]+)<\/td>/is";
                            preg_match_all($reg,$dataSource,$matchs);
                            if(isset($matchs[1])&&isset($matchs[2])){
                                foreach($matchs[1] as $key=>$val){
                                    $item['ip'] = $val;
                                    $item['port'] = $matchs[2][$key];
                                    \RedisDB::lpush('ProxyIp:list',json_encode($item));
                                }
                            }
                        }elseif($lk == 'kuaidaili'){

                        }elseif($lk == 'goubanjia'){
                            dd($dataSource);
                        }else{

                        }
                        sleep($list['times']);
                    }
                }
            }catch (\Exception $e){
                dd($e->getFile(),$e->getLine(),$e->getMessage());
            }
        }

    }
}
