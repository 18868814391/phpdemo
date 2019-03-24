import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

// export default new Router({
//   routes:[
//     {
//       path: '/login',
//       name: 'login',
//       component: () => import('@/view/login'),
//       meta: {
//         title: '登录'      
//       }
//     }
//   ]
// })

const routes = [
  {
    path: '*',
    redirect: '/index'
  },  
  {
    path: '/login',
    name: 'login',
    component: () => import('@/view/login'),
    meta: {
      title: '登录'
    }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/view/login/register'),
    meta: {
      title: '注册'
    }
  },
  {
    path: '/index',
    name: 'index',
    component: () => import('@/view/index'),
    meta: {
      title: 'syf'
    }
  },
  {
    path: '/upLoad',
    name: 'upLoad',
    component: () => import('@/view/index/upLoad'),
    meta: {
      title: '上传'
    }
  }, 
  {
    path: '/read',
    name: 'read',
    component: () => import('@/view/index/read'),
    meta: {
      title: '浏览'
    }
  },    
];

const router=new Router({
  routes 
});

export {
  router
};

