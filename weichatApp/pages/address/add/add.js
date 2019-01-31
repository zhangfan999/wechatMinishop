// pages/address/add/add.js
const util = require('../../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    consignee: '',
    address: '',
    mobile: '',
    //说明从购物车跳转过来的，添加成功后跳转到order/submit/submit
    returnType: '',
  },

  nameChange: function(e) {
    this.setData({ consignee: e.detail.value })
  },

  addressChange: function (e) {
    this.setData({ address: e.detail.value })
  },

  mobileChange: function (e) {
    this.setData({ mobile: e.detail.value })
  },

  //保存
  submit: function() {
    var consignee = this.data.consignee
    var address = this.data.address
    var mobile = this.data.mobile
    var url = 'User/addAddress'
    var params = {
      consignee: consignee,
      address: address,
      mobile: mobile,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        wx.showToast({
          title: '新增成功',
          icon: 'success'
        })
        //判断是否为购物车跳转过来
        if (this.data.returnType == 'submit'){
          wx.navigateTo({
            url: '../../order/submit/submit',
          })
        }else{
          //返回收货地址列表页
          wx.navigateBack()
        }
      }
    }, data => { }, data => { })
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({ returnType: options.returnType })
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