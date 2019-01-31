// pages/cart/cart.js
const util = require('../../utils/util.js')

//获取应用实例
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    carts: [],
    empty: true, //判断购物空是否为空
    domain: app.globalData.domain,
    selectAllStatus: true, //默认全选
    total: 0 //总金额
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
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

  /**
   * 加载购物车数据
   */
  getCarts: function() {
    var url = 'Cart/cartList'
    var params = {
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        this.setData({ carts: data.carts, empty:false })
        //总金额
        this.sum()
      }else{
        this.setData({ empty: true })
      }
    }, data => { }, data => { })
  },

  /**
   * 数量设置
   */
  inputing: function(e){
    //获取下标
    var index = e.currentTarget.dataset.index
    //获取数值
    var num = e.detail.value
    //购物车数据
    var carts = this.data.carts
    carts[index].num = num
    this.setData({ carts: carts })
    //更新数据库
    this.updateNum(carts[index].id, num)
    //更新总金额
    if(carts[index].selected == 1){
      this.sum()
    }
  },

  /**
   * 数量减
   */
  bindMinus: function (e) {
    //获取下标
    var index = e.currentTarget.dataset.index
    //购物车数据
    var carts = this.data.carts
    //获取数值
    var num = carts[index].num
    if (num > 1){
      num--
    }
    carts[index].num = num
    this.setData({ carts: carts })
    //更新数据库
    this.updateNum(carts[index].id, num)
    //更新总金额
    if (carts[index].selected == 1) {
      this.sum()
    }
  },

  /**
 * 数量加
 */
  bindPlus: function (e) {
    //获取下标
    var index = e.currentTarget.dataset.index
    //购物车数据
    var carts = this.data.carts
    //获取数值
    var num = carts[index].num
    num++
    carts[index].num = num
    this.setData({ carts: carts })
    //更新数据库
    this.updateNum(carts[index].id, num)
    //更新总金额
    if (carts[index].selected == 1) {
      this.sum()
    }
  },

  /**
   * 更新数据库购物车数量
   */
  updateNum: function (id, num){
    var url = 'Cart/updateNum'
    var params = {
      id: id,
      num: num,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => { }, data => { }, data => { })
  },

  /**
   * 总金额
   */
  sum: function() {
    var carts = this.data.carts
    var total = 0
    for (var i = 0; i < carts.length; i++){
      if (carts[i].selected){
        total += carts[i].price * carts[i].num
      }
    }
    //转换成两位小数
    this.setData({ total: total.toFixed(2) })
  },

  /**
   * 删除购物车
   */
  deleteCart: function(e) {
    //获取下标
    var index = e.currentTarget.dataset.index
    var id = this.data.carts[index].id
    var url = 'Cart/deleteCart'
    var params = {
      id: id,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => { 
      if(data.code == 200){
        //重新获取购物车数据
        this.getCarts()
      }
    }, data => { }, data => { })
  },

  /**
   * 选中或非选中状态
   */
  selectBox: function(e) {
    //获取下标值
    var index = e.currentTarget.dataset.index
    var carts = this.data.carts
    //状态取反
    carts[index].selected = !carts[index].selected
    //重新赋值
    this.setData({ carts: carts })
    //重新计算总金额
    this.sum()
    //最后更新数据库
    this.updateSelect(carts[index].id, carts[index].selected)
  },

  updateSelect: function(id, selected) {
    //参数为商品ID和状态
    if (selected){
      selected = 1
    }else{
      selected = 0
    }
    var url = 'Cart/updateSelect'
    var params = { 
      id: id, 
      selected: selected,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {}, data => { }, data => { })
  },

  /**
   * 全选与反选
   */
  selectAll: function(){
    var selectAllStatus = !this.data.selectAllStatus
    var carts = this.data.carts
    //遍历
    for(var i = 0; i<carts.length; i++){
      carts[i].selected = selectAllStatus
    }
    //重新赋值
    this.setData({ carts: carts, selectAllStatus: selectAllStatus })
    //重新计算总金额
    this.sum()
    //最后更新数据库
    this.updateSelectAll(selectAllStatus)
  },

  updateSelectAll: function (selectAllStatus) {
    //参数为商品ID和状态
    if (selectAllStatus) {
      selectAllStatus = 1
    } else {
      selectAllStatus = 0
    }
    var url = 'Cart/updateSelectAll'
    var params = {
      selected: selectAllStatus,
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => { }, data => { }, data => { })
  },

  //立即结算
  userPay: function() {
    var carts = this.data.carts
    if (carts.length<=0){
      wx.showToast({
        title: '请先勾选商品',
        icon: 'none'
      })
      return
    }else{
      //遍历取出已勾选的cid
      var cartIds = []
      for(var i = 0; i<carts.length; i++){
        if(carts[i].selected == 1){
          cartIds.push(carts[i].id)
        }
      }
    }
    //将cartIds由数组转字符串，例如1,2
    cartIds = cartIds.join(',')
    //存于全局变量中
    app.globalData.cartIds = cartIds
    app.globalData.amount = this.data.total

    //判断是否有默认收货地址，没有跳转到添加地址页面，有则跳转订单提交页面
    var url = 'User/haveAddress'
    var params = {
      openid: app.globalData.openid,
      token: app.globalData.userInfo.token
    }
    util.wxRequest(url, params, data => {
      if (data.code == 200) {
        wx.navigateTo({
          url: '../order/submit/submit',
        })
      } else if (data.code == 401){
        wx.navigateTo({
          url: '../address/add/add?returnType=submit',
        })
      } else {
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
  
  },

  see: function() {
    wx.switchTab({
      url: '../category/category',
    })
  }

})