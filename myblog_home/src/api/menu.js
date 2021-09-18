import request from '@/utils/request'

export function getMenus() {
  return request({
    url: '/menus',
    method: 'get'
  })
}

export function updateMenus(data) {
  return request({
    url: '/menus',
    method: 'put',
    data
  })
}