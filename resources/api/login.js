import request from '../utils/request';

export function loginByUsername(username, password) {
  const data = {
    email: username,
    password,
  };
  return request({
    url: '/api/login',
    method: 'post',
    data,
  });
}

export function logout() {}

export function getUserInfo() {
  // TODO 获取用户信息 + 角色
  return request({
    url: '/api/me',
    method: 'post',
  });
}
