// pages/category/category.js
const util = require('../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    categoryList: [], //主分类
    subCategoryList: [], //主分类下某个子分类
    domain: app.globalData.domain,
    highlight:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getCategory()
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
   * 获取分类
   */
  getCategory: function (id) {
    if(id == undefined){
      id = 0
    }
    var url = 'Category/getCategory'
    var params = { pid: id} //一级分类ID
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        this.setData({ 
          categoryList: data.list, 
          subCategoryList: data.sublist
        })
        this.setHighlight(0)
        // console.log(data)
      }
    }, data => { }, data => { })
  },

  /**
   * 设置一级分类高亮
   */
  setHighlight: function(index) {
    var highlight = []
    for (var i = 0; i < this.data.categoryList; i++){
      highlight[i] = ''
    }
    highlight[index] = 'highlight'
    this.setData({ highlight: highlight})
  },

  /**
   * 点击一级分类获取子分类
   */
  getSubCategory: function(e) {
    var pid = e.currentTarget.dataset.id
    var index = e.currentTarget.dataset.index
    this.setHighlight(index)
    var url = 'Category/getCategory'
    var params = { pid:pid}
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        this.setData({
          subCategoryList: data.sublist
        })
      }
    }, data => { }, data => { })
  },

  /**
   * 显示分类列表
   */
  showList: function(e) {
    var cid = e.currentTarget.dataset.cid
    wx.navigateTo({
      url: '../goods/list/list?cid=' + cid
    })
  }

})