// pages/member/index/index.js
const util = require('../../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo: null,
    login: false
  },

  /**
   * 生命周期函数--监听页面加载--只加载一次
   */
  onLoad: function (options) {
    
  },

  /**
   * 重新登录
   */
  login: function (e) {
    // console.log(e.detail.userInfo)
    wx.login({
      success: res => {
        if (res.code) {
          var that = this
          var url = 'User/getUser'
          var params = { 
            code: res.code, 
            openid: app.globalData.openid,
            // 第三季修正
            nickname: e.detail.userInfo.nickName,
            head: e.detail.userInfo.avatarUrl
          }
          util.wxRequest(url, params, data => {
            if (data.code == 200) {
              app.globalData.userInfo = data.data
              app.globalData.login = true
              this.setData({ login:true })
              wx.showToast({
                title: '登录成功',
                icon: 'success',
                duration: 2000
              })
            } else {
              //错误，需用户重新授权登录
              app.globalData.login = false
              wx.showToast({
                title: data.msg,
                icon: 'none',
                duration: 2000
              })
            }
          }, data => { }, data => { })
        }
      }
    })
  },

  /**
   * 我的钱包
   */
  navigateToMoney: function () {
    wx.navigateTo({
      url: '../money/money',
    })
  },

  /**
   * 全部订单
   */
  navigateToOrder: function () {
    wx.navigateTo({
      url: '../../order/list/list',
    })
  },

  /**
   * 我的收藏
   */
  navigateToCollect: function () {
    wx.navigateTo({
      url: '../collect/collect',
    })
  },

  /**
   * 地址管理
   */
  navigateToAddress: function () {
    wx.navigateTo({
      url: '../../address/list/list',
    })
  },

  /**
   * 关于我们
   */
  navigateToAboutus: function () {
    wx.navigateTo({
      url: '../aboutus/aboutus',
    })
  },

  orderList: function() {
    wx.navigateTo({
      url: '../../order/list/list',
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示--每次打开加载
   */
  onShow: function () {
    this.setData({
      userInfo: app.globalData.userInfo,
      login: app.globalData.login
    })
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})