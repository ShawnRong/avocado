import request from '../utils/request';

export const getAdminUserList = params => {
  return request({
    url: '/api/users',
    method: 'get',
    params,
  });
};

export const getUserRoles = (id, provider) => {
  return request({
    url: `/api/users/${id}/roles/${provider}`,
    method: 'get',
  });
};

export const assignRole = (id, provider, roles) => {
  return request({
    url: `/api/users/${id}/roles/${provider}`,
    method: 'put',
  });
};

export const addAdminUser = data => {
  return request({
    url: '/api/users',
    method: 'post',
    data,
  });
};

export const editAdminUser = (id, data) => {
  return request({
    url: `/api/users/${id}`,
    method: 'patch',
    data,
  });
};

export const deleteAdminUser = id => {
  return request({
    url: `/api/users/${id}`,
    method: 'delete',
  });
};
