const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()

  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

const wxRequest = (url, params, successCallback, errorCallback, completeCallback) => {
  wx.request({
    url: getApp().globalData.domain + 'index.php/api/' + url,
    data: params || {},
    header: { 'content-type': 'application/json' },
    method: 'POST',
    success: function (res) {
      if(res.statusCode== 200){
        successCallback(res.data)
      }else{
        errorCallback(res)
      }
    },
    fail: function(res) {
      errorCallback(res)
    },
    complete: function (res) {
      completeCallback(res)
    }
  })
}

//设置信息
const getWindowSize = () => {
  var data = {}
  wx.getSystemInfo({
    success: function(res) {
      data.screenWidth = res.windowWidth
      data.screenHeight = res.windowHeight
    }
  })
  return data
}

// 第三季增加
const getLoginStatus = () => {
  if (getApp().globalData.login == false){
    // 未登录状态
    wx.showModal({
      title: '提示',
      content: '请先登录',
      success: function (res) {
        if (res.confirm) {
          // 跳转到我的页面进行登录授权操作
          wx.switchTab({
            url: '../../member/index/index',
          })
        } else if (res.cancel) {
          // 停留在当前页面
        }
      }
    })
    return false
  }else{
    return true
  }
}

// 自定义设置缓存（带有效期）
const setStorageNuomibaba = (key, value) => {
  //获取缓存有效期
  var time = getApp().globalData.storageTime
  var seconds = parseInt(time)
  if (seconds > 0){
    // 设缓存
    wx.setStorageSync(key, value)
    //获取当前时间戳
    var timestamp = Date.parse(new Date()) / 1000
    // 有效时间戳
    var destroytime = timestamp + seconds
    // 再设一个键名失效时间的缓存
    wx.setStorageSync(key + '_destroytime', destroytime + '')
  }else{
    console.log('缓存' + key + '设置失败')
  }
}

// 自定义获取缓存
const getStorageNuomibaba = (key) => {
  // 有效时间戳
  var destroytime = parseInt(wx.getStorageSync(key + '_destroytime'))
  //获取当前时间戳
  var timestamp = Date.parse(new Date()) / 1000
  //时间戳对比
  if (timestamp < destroytime){
    // 缓存在有效期内
    return wx.getStorageSync(key)
  }else{
    return false
  }
}

// 清除缓存
const remove = (key) => {
  wx.removeStorageSync(key)
  wx.removeStorageSync(key + '_destroytime')
}

// 清除所有缓存
const clear = () => {
  wx.clearStorageSync()
}

module.exports = {
  formatTime: formatTime,
  wxRequest: wxRequest,
  getWindowSize: getWindowSize,
  getLoginStatus: getLoginStatus,
  setStorageNuomibaba: setStorageNuomibaba,
  getStorageNuomibaba: getStorageNuomibaba,
  remove: remove,
  clear: clear
}
