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
  return request({
    url: '/api/me',
    method: 'post',
  });
}
