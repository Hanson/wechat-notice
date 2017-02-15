<?php
/**
 * Created by PhpStorm.
 * User: HanSon
 * Date: 2017/2/15
 * Time: 13:26
 */

namespace Hanson\WechatNotice;


use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class NoticeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('WechatNotice', NoticeFacade::class);
    }

}