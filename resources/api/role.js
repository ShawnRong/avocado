import request from '../utils/request';

const basicRoute = 'api/roles';

export const getRoleList = params => {
  return request({
    url: basicRoute,
    method: 'get',
    params,
  });
};

export const guardNameRoles = guardName => {
  return request({
    url: `/api/guard-name-roles/${guardName}`,
    method: 'get',
  });
};

export const rolePermission = id => {
  return request({
    url: `/api/role/${id}/permissions`,
    method: 'get',
  });
};

export const roleAssignPermission = (id, permissions) => {
  return request({
    url: `/api/role/${id}/permissions`,
    method: 'put',
    permissions,
  });
};

export const addRole = data => {
  return request({
    url: basicRoute,
    method: 'post',
    data,
  });
};

export const editRole = (id, data) => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'patch',
    data,
  });
};

export const deleteRole = id => {
  return request({
    url: `${basicRoute}/${id}`,
    method: 'delete',
  });
};
