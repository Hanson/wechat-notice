# wechat-notice

wechat-notcie 是基于 `laravel` 和 [EasyWechat](https://github.com/overtrue/wechat) 开发的微信消息模板通知功能

## 安装

```
composer require hanson/wechat-notice
```

添加 `Hanson\WechatNotice\NoticeServiceProvider::class` 到 `app.php` 的 `providers` 中

## 使用

### config

当不做任何设置时，Notice会自动读取 `config('services.wechat')` 的配置

```
\WechatNotice::send($openId, $templateId, [
    'first' => '系统异常',
    'keyword1' => '',
    'keyword2' => '',
    'keyword3' => '',
    'remark' => '请及时处理'
]);
```

### 已存在实例


```
$wechat = new Application([
    'app_id'  => $appId,
    'secret'  => $secret,
]);

\WechatNotice::setWechat($wechat)->send($openId, $templateId, [
    'first' => '系统异常',
    'keyword1' => '',
    'keyword2' => '',
    'keyword3' => '',
    'remark' => '请及时处理'
], null, '#af0505');
```


### 直接设置配置

```
\WechatNotice::setConfig([
    'app_id'  => $appId,
    'secret'  => $secret,
])->send($openId, $templateId, [
    'first' => '系统异常',
    'keyword1' => '',
    'keyword2' => '',
    'keyword3' => '',
    'remark' => '请及时处理'
]);
```

### 发送给多个用户

```
\WechatNotice::send([$openId, $openId2, $openId3, ...], $templateId, [
    'first' => '系统异常',
    'keyword1' => '',
    'keyword2' => '',
    'keyword3' => '',
    'remark' => '请及时处理'
]);
```
