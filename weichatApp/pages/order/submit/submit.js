// pages/order/submit/submit.js
const util = require('../../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    address: [],
    cartList: [],
    cartIds: [],
    amount: 0.00,
    domain: app.globalData.domain,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      cartIds: app.globalData.cartIds,
      amount: app.globalData.amount
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this.getCarts()
  },

  //获取默认快递和购物车数据
  getCarts: function() {
    var url = 'Cart/orderInfo'
    var params = {
      cartIds: this.data.cartIds,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        this.setData({
          address: data.info.address,
          cartList: data.info.cartList
        })
      } else {
        app.globalData.login = false
        wx.showToast({
          title: data.msg,
          icon: 'none',
          duration: 2000
        })
      }
    }, data => { }, data => { })
  },

  //重新设置收货地址
  addressSelect: function() {
    wx.navigateTo({
      url: '../../address/list/list',
    })
  },

  //提交订单（微信需要两次验签）
  submit: function() {
    var url = 'Cart/submitOrder'
    var params = {
      cartIds: this.data.cartIds,
      addressId: this.data.address.id,
      amount: this.data.amount,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        app.globalData.wxdata = data.data.wdata
        app.globalData.order = data.order
        wx.showToast({
          title: '提交成功',
          icon: 'success',
          duration: 1500
        })
        setTimeout(function() {
          wx.navigateTo({
            url: '../payment/payment',
          })
        }, 1500)
      }else {
        app.globalData.login = false
        wx.showToast({
          title: data.msg,
          icon: 'none'
        })
      }
    }, data => { }, data => { })
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