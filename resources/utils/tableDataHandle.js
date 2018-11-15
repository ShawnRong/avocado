import notify from './notify';

export function responseDataFormat(response, th) {
  th.tableData = response.data.data;

  let metaPagination = response.data.meta.pagination;
  th.pagination = {
    currentPage: metaPagination.current_page,
    pageSize: metaPagination.per_page,
    total: metaPagination.total,
    lastPage: metaPagination.last_page,
  };
}

export const editSuccess = th => {
  notify.editSuccess(th);
  th.dialogEditFormVisible = false;

  Object.assign(th.nowRowData.row, th.editForm);
  th.tableData[th.nowRowData.index] = th.nowRowData.row;

  th.$refs.editForm.resetFields();
};

export const addSuccess = th => {
  th.dialogAddFormVisible = false;
  notify.createSuccess(th);
  th.$refs.addForm.resetFields();
};

export const deleteSuccess = (index, th) => {
  th.tableData.splice(index, 1);
  notify.deleteSuccess(th);
};

export const tableDefaultData = () => {
  return {
    queryParams: {},
    tableData: [],
    pagination: {
      currentPage: 1,
      pageSize: 15,
      total: 0,
      from: 1,
      lastPage: 1,
      to: 1,
    },
    nowRowData: {
      index: 0,
      row: {},
    },
    dialogAddFormVisible: false,
    dialogEditFormVisible: false,
    formLabelWidth: '120px',
  };
};
