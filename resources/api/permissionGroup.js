import request from '../utils/request';

const basicRoute = '/api/permission-group';

export const getPermissionGroupList = params => {
  return request({
    url: basicRoute,
    method: 'get',
    params,
  });
};

export const guradNameForPermissions = guardName => {
  return request({
    url: `/api/guard-name-for-permissions/${guardName}`,
    method: 'get',
  });
};

export const addPermissionGroup = (id, data) => {
  return request({
    url: basicRoute,
    method: 'post',
    data,
  });
};

export const editPermissionGroup = (id, data) => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'patch',
    data,
  });
};

export const deletePermissionGroup = id => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'delete',
  });
};
