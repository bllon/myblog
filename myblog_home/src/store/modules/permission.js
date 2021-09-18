import { asyncRoutes, constantRoutes,componentMap } from '@/router'
import { getRoutes } from '@/api/user'

/**
 * Use meta.role to determine if the current user has permission
 * @param roles
 * @param route
 */
function hasPermission(roles, route) {
  if (route.meta && route.meta.roles) {
    return roles.some(role => route.meta.roles.includes(role))
  } else {
    return true
  }
}

/**
 * Filter asynchronous routing tables by recursion
 * @param routes asyncRoutes
 * @param roles
 */
export function filterAsyncRoutes(routes, roles) {
  const res = []

  routes.forEach(route => {
    const tmp = { ...route }
    if (hasPermission(roles, tmp)) {
      if (tmp.children) {
        tmp.children = filterAsyncRoutes(tmp.children, roles)
      }
      res.push(tmp)
    }
  })

  return res
}

const state = {
  routes: [],
  addRoutes: []
}

const mutations = {
  SET_ROUTES: (state, routes) => {
    state.addRoutes = routes
    state.routes = constantRoutes.concat(routes)
  }
}

// 替换route对象中的component
function replaceComponent(comp) {
  if(comp.component && typeof(comp.component)=='string'){
    comp.component = componentMap[comp.component];
  }

  if(comp.children && comp.children.length>0){
    for(let i=0;i<comp.children.length;i++){
      comp.children[i] = replaceComponent(comp.children[i]);
    }
  }
  return comp
}

const actions = {
  generateRoutes: async function({ commit }, roles) {
    // return new Promise(resolve => {
    //   let accessedRoutes
    //   //请求api获取角色路由
    //   if (roles.includes('admin')) {
    //     accessedRoutes = asyncRoutes || []
    //     console.log(accessedRoutes)
    //   } else {
    //     accessedRoutes = filterAsyncRoutes(asyncRoutes, roles)
    //   }
    //   commit('SET_ROUTES', accessedRoutes)
    //   resolve(accessedRoutes)
    // })
    // 从后台请求路由信息
    // return new Promise(resolve => {
      let res = await getRoutes() //  将异步方法调用改为同步执行
      let myAsyncRoutes = res.data

      // 替换组件名称，删除空children
      myAsyncRoutes = myAsyncRoutes.filter(curr => {
        if(curr.children == null || curr.children.length == 0){
          delete curr.children
        }
        return replaceComponent(curr);
      })

      // myAsyncRoutes = myAsyncRoutes.concat(asyncRoutes)
      // 定义一个变量，存放可以访问的路由表
      let accessedRoutes
      // 判断当前角色
      if (roles.includes('admin')) {
        // 所有路由都能访问
        accessedRoutes = myAsyncRoutes || []
      } else {
        // 根据角色过滤掉不能访问的路由表
        accessedRoutes = filterAsyncRoutes(myAsyncRoutes, roles)
      }
      commit('SET_ROUTES', accessedRoutes)
      return accessedRoutes
    // })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
