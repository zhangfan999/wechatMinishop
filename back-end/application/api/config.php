<?php
//配置文件
return [
    'wxpay' => [
        'appid' => "wxb8e455b44bc083dd", //小程序应用id
        'secret' => "bb1c58b0fe526c209fe2054bda40c7ae", //小程序secret
        'mch_id' => '', //商户ID
        'api_key' => '', //商户平台自己设定的32位API密钥
        'notify_url' => 'http://www.myminishop.com/index.php/api/Pay/notify', //回调地址
        // 'domain' => 'https://dev.blogad.top'
        'domain' => 'http://www.myminishop.com'
    ],
];
