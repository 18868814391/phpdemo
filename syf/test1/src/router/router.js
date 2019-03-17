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
];

const router=new Router({
  routes 
});

export {
  router
};

