// pages/goods/detail/detail.js
const util = require('../../../utils/util.js')
var WxParse = require('../../../wxParse/wxParse.js');

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    tab: 0,
    tabClass: ['text-select', 'text-normal'],
    goodsId: 0, //商品ID
    images: [],
    goodsInfo: [],
    domain: app.globalData.domain,
    swiperHeight: 0,
    goodsNum: 1, //商品数量
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({ goodsId: options.goodsId, swiperHeight: util.getWindowSize().screenWidth })
    this.getGoodsInfo()
  },

  getGoodsInfo:function() {
    var url = 'Goods/goodsInfo'
    var params = { id: this.data.goodsId }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        WxParse.wxParse('article', 'html', data.info.content, this, 5)
        this.setData({ images: data.images, goodsInfo: data.info })
        // console.log(data.info)
      }
    }, data => { }, data => { })
  },

  /**
   * 购买数量减
   */
  bindMinus: function() {
    var num = this.data.goodsNum
    if(num >1 ){
      num--
    }
    this.setData({ goodsNum: num })
  },

  /**
   * 购买数量值
   */
  inputing: function(e){
    var num = e.detail.value
    if(num<1){
      num = 1
    }
    this.setData({ goodsNum: num })
  },

  /**
   * 购买数量加
   */
  bindPlus: function () {
    var num = this.data.goodsNum
    num++
    this.setData({ goodsNum: num })
  },

  /**
   * 商品收藏或取消收藏
   */
  addCollect: function (e){
    // 第三季修正
    if (util.getLoginStatus() == true){
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
        }
      }, data => { }, data => { })
    }
  },

  /**
   * 加入购物车
   */
  addCart: function(){
    // 第三季修正
    if (util.getLoginStatus() == true){
      var gid = this.data.goodsId
      var url = 'Cart/addCart'
      var params = {
        gid: gid,
        goodsNum: this.data.goodsNum,
        openid: app.globalData.openid,
        token: app.globalData.userInfo.token
      }
      util.wxRequest(url, params, data => {
        if (data.code == 200) {
          app.globalData.login = true
          wx.showToast({
            title: data.msg,
            icon: 'success',
            duration: 2000
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
    }
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
  
  },

  tabClick: function(e) {
    var index = e.currentTarget.dataset.index
    var classs = ['text-normal', 'text-normal']
    classs[index] = 'text-select'
    this.setData({ tabClass: classs, tab:index})
  },

  /**
   * 立即购买：检查该商品是否已加入购物车，
   * 加入则跳转购物车页面，未加入则先加入购物车再跳转
   */
  buy: function() {
    // 第三季修正
    if (util.getLoginStatus() == true){
      var url = 'Cart/checkCart'
      var params = {
        goodsNum: this.data.goodsNum,
        gid: this.data.goodsInfo.id,
        openid: app.globalData.openid,
        token: app.globalData.userInfo.token
      }
      util.wxRequest(url, params, data => {
        if (data.code == 200) {
          wx.switchTab({
            url: '../../cart/cart',
          })
        } else {
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