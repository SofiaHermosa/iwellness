<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $ads;

    public function __construct(){
        $this->ads = array(
            '//www.youtube-nocookie.com/embed/Rm_aiDpkGmQ',
            '//www.youtube-nocookie.com/embed/9fl3c4GH8rI',
            '//www.youtube-nocookie.com/embed/XKfgdkcIUxw&t=9s',
            '//www.youtube-nocookie.com/embed/Ez_XbKdDZHo',
            '//www.youtube-nocookie.com/embed/7RBaluuj9Ng',
            '//www.youtube-nocookie.com/embed/gKCmezkfWbE',
            '//www.youtube-nocookie.com/embed/p0y--Oo6yAI',
            '//www.youtube-nocookie.com/embed/hzvaoDd_Uk8',
            '//www.youtube-nocookie.com/embed/wVP3bdw8uyE',
            '//www.youtube-nocookie.com/embed/SRBJGBdprJI',
            '//www.youtube-nocookie.com/embed/fz1aiqtGErk',
            '//www.youtube-nocookie.com/embed/0UUpyKFPimY',
            '//www.youtube-nocookie.com/embed/keOaQm6RpBg',
            '//www.youtube-nocookie.com/embed/1z73AKLBgLg',
            '//www.youtube-nocookie.com/embed/cbMGBp4EoT0',
            '//www.youtube-nocookie.com/embed/sY2djp46FeY',
            '//www.youtube-nocookie.com/embed/4QBzoGwZuCk',
            '//www.youtube-nocookie.com/embed/hsLP5SLsUY0',
            '//www.youtube-nocookie.com/embed/lNcMCwuBw_E',
            '//www.youtube-nocookie.com/embed/p5NNA6uvTig',
            '//www.youtube-nocookie.com/embed/ABHNLUV2458',
            '//www.youtube-nocookie.com/embed/4zQZSFxl6Qs',
            '//www.youtube-nocookie.com/embed/H6D6CYueCCI',
            '//www.youtube-nocookie.com/embed/m1W6h3qnVzY',
            '//www.youtube-nocookie.com/embed/OdFr7wd-DWA',
            '//www.youtube-nocookie.com/embed/TN06GznK8z4',
            '//www.youtube-nocookie.com/embed/SpA7BOLPZcg',
            '//www.youtube-nocookie.com/embed/SLTtMsVtt8s',
            '//www.youtube-nocookie.com/embed/ADfK93iM8_M',
            '//www.youtube-nocookie.com/embed/OroH4-D524E',
            '//www.youtube-nocookie.com/embed/1tV42XJdMjc'
        );
    }

    public function run()
    {
        foreach($this->ads as $ad){
            DB::table('ads_videos')->insert([
                'link' => $ad,
            ]);
        }
    }
}
