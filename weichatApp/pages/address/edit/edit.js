// pages/address/edit/edit.js
const util = require('../../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: 0,
    consignee: '',
    address: '',
    mobile: '',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({ id: options.id})
    this.loadAddress(options.id)
  },

  nameChange: function (e) {
    this.setData({ consignee: e.detail.value })
  },

  addressChange: function (e) {
    this.setData({ address: e.detail.value })
  },

  mobileChange: function (e) {
    this.setData({ mobile: e.detail.value })
  },

  //加载地址
  loadAddress: function(id) {
    var url = 'User/getAddressById'
    var params = {
      id: id,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        var address = data.info
        this.setData({ 
          id: address.id,
          consignee: address.consignee,
          address: address.address,
          mobile: address.mobile,
         })
      } else {
        app.globalData.login = false
        wx.showToast({
          title: '请重新登录',
          icon: 'none'
        })
      }
    }, data => { }, data => { })
  },

  //编辑
  submit: function () {
    var id = this.data.id
    var consignee = this.data.consignee
    var address = this.data.address
    var mobile = this.data.mobile
    var url = 'User/editAddress'
    var params = {
      id: id,
      consignee: consignee,
      address: address,
      mobile: mobile,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        wx.showToast({
          title: '编辑成功',
          icon: 'success'
        })
        //返回收货地址列表页
        wx.navigateBack()
      }else{
        app.globalData.login = false
        wx.showToast({
          title: '请重新登录',
          icon: 'none'
        })
      }
    }, data => { }, data => { })
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