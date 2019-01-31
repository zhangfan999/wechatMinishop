//app.js
const util = require('/utils/util.js')
const appid = 'wxb8e455b44bc083dd'
const secret = 'bb1c58b0fe526c209fe2054bda40c7ae'

App({
  onLaunch: function () {
    // 展示本地存储能力
    // var logs = wx.getStorageSync('logs') || []
    // logs.unshift(Date.now())
    // wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        // console.log(res.code) //每次变化
        if(res.code){
          //发送网络请求，获取openId
          var that = this
          var url = 'User/getOpenid'
          var params = {
            appid: appid,//小程序唯一标识
            secret: secret,//小程序的secret
            grant_type: 'authorization_code',
            js_code: res.code
          }
          util.wxRequest(url, params, data => {
            if (data.code == 200) {
              //openid赋值
              that.globalData.openid = data.result
              // 第三季修正
              that.getUser()
              // 询问用户是否授权是wx.getUserInfo发起的
              // wx.getUserInfo({
              //   success: function (successData) {
              //     //用户信息进行赋值
              //     // console.log(data)
              //     that.globalData.userInfo = successData.userInfo
              //     //获取数据库用户信息，类似于用户登录功能
              //     that.getUser()
              //   },
              //   fail: function (failData) {
              //     console.log('用户拒绝授权')
              //   }
              // })
            } else {
              console.log('获取用户openId失败')
            }
          }, data => { }, data => { })
        }
      }
    })

    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })
  },

  //用户登录，传入code和openid进行核对
  getUser: function() {
    wx.login({
      success: res => {
        if(res.code) {
          var that = this
          var url = 'User/getUser'
          var params = { code: res.code, openid: this.globalData.openid}
          util.wxRequest(url, params, data => {
            if (data.code == 200) {
              that.globalData.userInfo = data.data
              // 第三季修正
              if (data.data.nickname != '' && data.data.head != ''){
                that.globalData.login = true
              }
            } else if (data.code == 400){
              //无此用户
              that.register()
            }else{
              //错误，需用户重新授权登录
              that.globalData.login = false
              wx.showToast({
                title: '请重新登录',
                icon: 'none',
                duration: 2000
              })
            }
          }, data => { }, data => { })
        }
      }
    })
  },

  // 用户注册
  register: function() {
    var url = 'User/register'
    var params = {
      openid: this.globalData.openid,
      // 第三季修正
      // nickname: this.globalData.userInfo.nickName,
      // head: this.globalData.userInfo.avatarUrl
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        this.globalData.userInfo = data.data
        // 第三季修正
        // this.globalData.login = true
      }else{
        this.globalData.login = false
      }
    }, data => { }, data => { })
  },

  globalData: {
    // domain: 'https://dev.blogad.top/',
    domain: 'http://www.myminishop.com/', //正式使用是https
    userInfo: null,
    openid:'',
    login: false, //登录状态，token过期为false
    cartIds: '', //订单id集合
    amount: 0.00, //订单总金额
    wxdata: [], //微信返回信息
    order:[], //订单信息
    storageTime: 60, //缓存有效期（秒）
  }
})