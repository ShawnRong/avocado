import request from '../utils/request';

export const getAdminUserList = params => {
  return request({
    url: '/api/users',
    method: 'get',
    params,
  });
};

export const getUserRoles = id => {
  return request({
    url: `/api/user/${id}/roles`,
    method: 'get',
  });
};

export const assignRoles = (id, roles) => {
  return request({
    url: `/api/user/${id}/roles`,
    method: 'put',
    data: {
      roles,
    },
  });
};

export const addAdminUser = data => {
  return request({
    url: '/api/user/add',
    method: 'post',
    data,
  });
};

export const editAdminUser = (id, data) => {
  return request({
    url: `/api/user/${id}`,
    method: 'patch',
    data,
  });
};

export const deleteAdminUser = id => {
  return request({
    url: `/api/user/${id}`,
    method: 'delete',
  });
};
