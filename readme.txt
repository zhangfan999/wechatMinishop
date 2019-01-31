一、web pc端请修改如下配置

WeChat_Mini-app_Shop\application\database.php

    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => '',
    // 用户名
    'username'        => '',
    // 密码
    'password'        => '',

WeChat_Mini-app_Shop\application\api\config.php

'wxpay' => [

   'appid' => '', //小程序应用id

   'secret' => '', //小程序secret
   'mch_id' => '', //商户ID

   'api_key' => '', //商户平台自己设定的32位API密钥

   'notify_url' => 'https://您的域名/index.php/api/Pay/notify', //回调地址

   'domain' => 'https://您的域名'
],



后台登录地址：您的域名
登录账号：admin
初始密码：123456
=======================================================

二、小程序端请修改如下配置

StudyFox_Mini-app_Shop\app.js

const appid = ''
 //小程序应用id

const secret = '' //小程序secret

globalData: {
  domain: 'https://您的域名/',
}



StudyFox_Mini-app_Shop\project.config.json

"appid": "",


三、微信公众平台 | 小程序配置
https://mp.weixin.qq.com
请登录——设置——开发设置——服务器域名
——request合法域名中加入您自己的域名（https的）

四、php5.6部分版本会出现token失效的情况（即需要不断重新手动点击登录）解决办法
打开php.ini配置文件，找到以下代码
;always_populate_raw_post_data = -1
改成
always_populate_raw_post_data = -1
