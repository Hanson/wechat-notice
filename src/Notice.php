<?php
/**
 * Created by PhpStorm.
 * User: HanSon
 * Date: 2017/2/15
 * Time: 13:24
 */

namespace Hanson\WechatNotice;


use EasyWeChat\Foundation\Application;

class Notice
{

    /**
     * @var Application
     */
    public $wechat;

    private $failClosure;

    /**
     * Notice constructor.
     */
    public function __construct()
    {
        $config = config('services.wechat');
        $this->wechat = is_array($config) ? new Application(config('services.wechat')) : null;
    }

    /**
     * set a exist wechat instance
     *
     * @param $wechat
     * @return $this
     */
    public function setWechat($wechat)
    {
        $this->wechat = $wechat;
        return $this;
    }

    public function setConfig($config)
    {
        $this->wechat = new Application($config);
        return $this;
    }

    /**
     * send a wechat notice to one or more users
     *
     * @param $openIds
     * @param $templateId
     * @param $data
     * @param null $url
     */
    public function send($openIds, $templateId, $data, $url = null)
    {
        if (is_array($openIds)) {
            foreach ($openIds as $openid) {
                $this->sendNotice($openid, $templateId, $data, $url);
            }
        } else {
            $this->sendNotice($openIds, $templateId, $data, $url);
        }
    }

    public function sendNotice($openid, $templateId, $data, $url = null)
    {
        try {
            return $this->wechat->notice->send([
                'touser' => $openid,
                'template_id' => $templateId,
                'url' => $url,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            $this->executeWhileFail($e);
        }
    }

    /**
     * execute while send notice failed
     *
     * @param $e \Exception
     */
    private function executeWhileFail($e)
    {
        if (!is_callable($this->failClosure)) {
            call_user_func($this->failClosure, $e);
        }
    }

    /**
     * set a callable function to execute while send notice failed
     *
     * @param $closure
     * @throws \Exception
     */
    public function setFailClosure($closure)
    {
        if (!is_callable($closure)) {
            throw new \Exception('Notice Failed Closure must be a callable function');
        }

        $this->failClosure = $closure;
    }

}