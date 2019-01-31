// pages/member/collect/collect.js
const util = require('../../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    page:1,
    collects: [],
    domain: app.globalData.domain,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getCollects(1) //默认第1页
  },

  /**
   * 获取收藏数据
   */
  getCollects: function(page) {
    var url = 'Goods/getCollects'
    var params = {
      page: page,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        app.globalData.login = true
        var collects = this.data.collects
        var newCollect = data.info
        if (newCollect.length > 0){
          for (var i in newCollect){
            collects.push(newCollect[i])
          }
          this.setData({ collects: collects})
          // console.log(collects)
        }else{
          wx.showToast({
            title: '没有更多记录了',
            icon: 'none'
          })
        }
      }else{
        app.globalData.login = false
        wx.showToast({
          title: data.msg,
          icon: 'none'
        })
      }
    }, data => { }, data => { })
  },

  deleteGoods: function(e) {
    var that = this
    wx.showModal({
      title: '提示',
      content: '确定取消该收藏吗？',
      success: function (res) {
        if (res.confirm) {
          var gid = e.currentTarget.dataset.id
          var url = 'Goods/collectGoods'
          var params = {
            gid: gid,
            openid: app.globalData.openid,
            token: app.globalData.userInfo.token
          }
          util.wxRequest(url, params, data => {
            if (data.code == 200) {
              wx.showToast({
                title: data.msg,
                icon: 'success',
                duration: 2000
              })
              that.setData({ collects: [], page:1})
              that.getCollects(1)
            }
          }, data => { }, data => { })
        }
      }
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
    wx.showToast({
      title: '刷新中',
      icon: 'loading'
    })
    this.setData({ collects: [], page: 1 })
    this.getCollects(1)
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    this.getCollects(++this.data.page)
    wx.showToast({
      title: '加载中',
      icon: 'loading'
    })
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})