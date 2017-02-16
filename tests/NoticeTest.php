<?php

class NoticeTest extends \Orchestra\Testbench\TestCase
{

    private $app_id = '';

    private $secret = '';

    private $openId = '';

    private $templateId = '';

    public function testExistApplication()
    {
        $wechat = new \EasyWeChat\Foundation\Application([
            'app_id'  => $this->app_id,
            'secret'  => $this->secret,
        ]);

        $response = \WechatNotice::setWechat($wechat)->sendNotice($this->openId, $this->templateId, [
            'first' => 'test3',
            'keyword1' => get_class($this),
        ], null, '#af0505');

        $response = json_decode($response, true);

        $this->assertEquals(0, $response['errcode']);
    }

    public function testConfigSend()
    {
        $response = \WechatNotice::setConfig([
            'app_id'  => $this->app_id,
            'secret'  => $this->secret,
        ])->sendNotice($this->openId, $this->templateId, [
            'first' => 'test2',
            'keyword1' => get_class($this),
        ], null, '#af0505');

        $response = json_decode($response, true);

        $this->assertEquals(0, $response['errcode']);
    }

    public function testSend()
    {
        $response = \WechatNotice::sendNotice($this->openId, $this->templateId, [
            'first' => 'test1',
            'keyword1' => get_class($this),
        ], null, '#af0505');

        $response = json_decode($response, true);

        $this->assertEquals(0, $response['errcode']);
    }

    protected function getPackageProviders($app)
    {
        return ['Hanson\WechatNotice\NoticeServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'WechatNotice' => \Hanson\WechatNotice\NoticeFacade::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.wechat', [
            'app_id'   => $this->app_id,
            'secret' => $this->secret,
        ]);
    }
}