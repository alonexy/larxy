<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Overtrue\ChineseCalendar\Calendar;

class CrawlHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Crawl:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '启动抓取程序';

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
//        $ChromiumUrl = file_get_contents('/Users/alonex/Code/Crawl/puppeteerJs/wsEndpoint.json');
//        dd($ChromiumUrl);

    }
}
