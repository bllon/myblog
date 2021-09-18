import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/auth/login', // '/vue-element-admin/user/login',
    method: 'post',
    data
  })
}

export function getInfo() {
  return request({
    url: '/user', //'/vue-element-admin/user/info',
    method: 'get',
    params: {}
  })
}

export function logout() {
  return request({
    url: '/auth/logout',
    method: 'get'
  })
}

export function getRoutes() {
  return request({
    url: '/Routes',
    method: 'get'
  })
}