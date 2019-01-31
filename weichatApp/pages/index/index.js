//index.js
const util = require('../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    banner: [],
    ad: [],
    goods: [],
    domain: app.globalData.domain,
    random: '',
    keywords: '',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.loadIndex()
    this.createNonceStr()
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

  /**
   * 加载幻灯片、广告、楼层分类
   */
  loadIndex: function () {
    var banner = util.getStorageNuomibaba('banner')
    var ad = util.getStorageNuomibaba('ad')
    var goods = util.getStorageNuomibaba('goods')
    //先判断缓存
    if (banner && ad && goods){
      this.setData({ banner: banner, ad: ad, goods: goods })
    }else{
      var url = 'Index/index'
      var params = {}
      util.wxRequest(url, params, data => {
        if (data.code == 200) {
          this.setData({ banner: data.banner, ad: data.ad, goods: data.goods })
          util.setStorageNuomibaba('banner', data.banner)
          util.setStorageNuomibaba('ad', data.ad)
          util.setStorageNuomibaba('goods', data.goods)
        }
      }, data => { }, data => { })
    }
    // console.log(wx.getStorageSync('banner'))
    // console.log(wx.getStorageSync('ad'))
  },

  /**
   * 生成一个随机数
   */
  createNonceStr: function () {
    var random = Math.random().toString().substr(2,15)
    this.setData({ random: random })
  },

  /**
   * 获取搜索框的值
   */
  inputing: function(e){
    this.setData({ keywords: e.detail.value })
  },

  /**
   * 搜索功能
   */
  searchGoods: function(){
    var keywords = this.data.keywords
    if (keywords != ''){
      wx.navigateTo({
        url: '../search/search?keywords=' + keywords
      })
    }
  },

  /**
  * 商品详情
  */
  showDetail: function (e) {
    // console.log(e)
    var goodsId = e.currentTarget.dataset.goodsId
    wx.navigateTo({
      url: '../goods/detail/detail?goodsId=' + goodsId
    })
  },

  // 全部分类
  showCategory: function() {
    wx.switchTab({
      url: '../category/category',
    })
  },

  // 购物车
  showCarts: function () {
    wx.switchTab({
      url: '../cart/cart',
    })
  },

  // 地址管理
  showAddress: function () {
    wx.navigateTo({
      url: '../address/list/list',
    })
  },

  // 我的钱包
  showMoney: function () {
    wx.navigateTo({
      url: '../member/money/money',
    })
  },

  // 我的订单
  showOrder: function () {
    wx.navigateTo({
      url: '../order/list/list',
    })
  },

  // 我的收藏
  showCollect: function () {
    wx.navigateTo({
      url: '../member/collect/collect',
    })
  },

  // 个人中心
  showMine: function () {
    wx.switchTab({
      url: '../member/index/index',
    })
  },

  // 关于我们
  showAboutus: function () {
    wx.navigateTo({
      url: '../member/aboutus/aboutus',
    })
  }

})
