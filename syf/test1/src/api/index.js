import request from '@/utils/request'

export function register(params) { return request({ url: '/login/register.php', method: 'post', data: params }) }// 注册
export function loginIN(params) { return request({ url: '/login/login.php', method: 'post', data: params }) }// 登陆
