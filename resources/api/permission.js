import request from '../utils/request';

const basicRoute = '/api/permissions';

export const loadPermissions = () => {
  return request({
    url: '/api/permission-user-all',
    method: 'get',
  });
};

export const getPermissionList = params => {
  return request({
    url: basicRoute,
    method: 'get',
    params,
  });
};

export const addPermission = data => {
  return request({
    url: basicRoute,
    method: 'post',
    data,
  });
};

export const editPermission = (id, data) => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'put',
    data,
  });
};

export const deletePermission = id => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'delete',
  });
};
