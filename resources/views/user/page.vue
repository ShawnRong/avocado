<template>
  <div class="app-container">
    <div class="filter-container">
      <el-form :inline="true" :model="queryParams"  size="mini">
        <el-input :placeholder="$t('name')" v-model="queryParams.name" style="width: 200px;" class="filter-item"></el-input>
        <el-input :placeholder="$t('email')" v-model="queryParams.email" style="width: 200px" class="filter-item"></el-input>
        <el-button type="primary" @click="requestData" icon="el-icon-search" class="filter-item">{{ $t('search') }}</el-button>
        <el-button type="primary" @click="dialogAddFormVisible = true" icon="el-icon-plus" class="filter-item">{{ $t('add') }}</el-button>
      </el-form>
    </div>

    <el-table
            :data="tableData"
            border
            style="width: 100%">
      <el-table-column :label="$t('id')" prop="id" sortable="custom" align="center" width="65">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column
              prop="name"
              align="center"
              :label="$t('name')">
      </el-table-column>
      <el-table-column
              prop="email"
              align="center"
              :label="$t('email')">
      </el-table-column>
      <el-table-column
              prop="created_at"
              align="center"
              :label="$t('createdAt')">
      </el-table-column>
      <el-table-column
              prop="updated_at"
              align="center"
              :label="$t('updatedAt')">
      </el-table-column>
      <el-table-column
              fixed="right"
              width="300px"
              :label="$t('actions')"
              align="center"
              >
        <template slot-scope="scope">
           <el-button size="mini"
                  type="primary"
                  @click="handleEdit(scope.$index, scope.row)">{{ $t('edit') }}</el-button>
           <el-button size="mini"
                  type="success"
                  @click="assignRole(scope.row)">{{ $t('assignRole') }}</el-button>
           <el-button size="mini"
                  type="danger"
                  @click="handleDelete(scope.$index, scope.row)">{{ $t('delete') }}</el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-pagination class="table-paginator"
                   @current-change="requestData"
                   :current-page.sync="pagination.currentPage"
                   :page-size="pagination.pageSize"
                   layout="total, prev, pager, next, jumper"
                   :total="pagination.total">
    </el-pagination>

    <el-dialog :title="$t('add')" :visible.sync="dialogAddFormVisible" width="30%">
      <el-form :model="addForm" :rules="addRules" ref="addForm">
        <el-form-item :label="$t('name')" prop="name" :label-width="formLabelWidth">
          <el-input v-model="addForm.name"></el-input>
        </el-form-item>
        <el-form-item :label="$t('email')" prop="email" :label-width="formLabelWidth">
          <el-input v-model="addForm.email"></el-input>
        </el-form-item>
        <el-form-item :label="$t('password')" prop="password" :label-width="formLabelWidth">
          <el-input  type="password" v-model="addForm.password"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogAddFormVisible = false">{{ $t('cancel') }}</el-button>
        <el-button type="primary" @click="handleAddAdminUser">{{ $t('confirm') }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :title="$t('edit')" :visible.sync="dialogEditFormVisible" width="30%">
      <el-form :model="editForm" :rules="editRules" ref="editForm">
        <el-form-item :label="$t('name')" prop="name" :label-width="formLabelWidth">
          <el-input v-model="editForm.name"></el-input>
        </el-form-item>
        <el-form-item :label="$t('password')" prop="password" :label-width="formLabelWidth">
          <el-input  type="password" v-model="editForm.password"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogEditFormVisible = false">{{ $t('cancel') }}</el-button>
        <el-button type="primary" @click="handleEditAdminUser">{{ $t('confirm') }}</el-button>
      </div>
    </el-dialog>

    <user-assign-role
            :user-id="assignRoleParams.id"
            :guard-name="assignRoleParams.guardName"
            :dialog-visible.sync="assignRoleParams.dialogVisible"></user-assign-role>
  </div>
</template>
<script>
import {
  getAdminUserList,
  addAdminUser,
  editAdminUser,
  deleteAdminUser
} from "../../api/user.js";
import {
  responseDataFormat,
  tableDefaultData,
  editSuccess,
  addSuccess,
  deleteSuccess
} from "../../utils/tableDataHandle.js";
import UserAssignRole from "../../components/User/AssignRole";

export default {
  name: "UserListTable",
  components: {
    UserAssignRole
  },
  data() {
    return {
      ...tableDefaultData(),
      assignRoleParams: {
        id: 0,
        guardName: "admin",
        dialogVisible: false
      },
      addForm: {
        name: "",
        email: "",
        password: ""
      },
      editForm: {
        name: "",
        password: ""
      },
      addRules: {
        name: [{ required: true }, { min: 3, max: 255 }],
        email: [{ type: "email", required: true }],
        password: [{ required: true }, { min: 8, max: 32 }]
      },
      editRules: {
        name: [{ required: true }, { min: 3, max: 255 }],
        password: [{ min: 8, max: 32 }]
      }
    };
  },
  methods: {
    assignRole(row) {
      this.assignRoleParams.id = row.id;
      this.assignRoleParams.dialogVisible = true;
    },
    handleEdit(index, row) {
      this.editForm.name = row.name;
      this.nowRowData = { index, row };
      this.dialogEditFormVisible = true;
    },
    handleDelete(index, row) {
      deleteAdminUser(row.id).then(response => {
        deleteSuccess(index, this);
      });
    },
    requestData() {
      getAdminUserList({
        ...this.queryParams,
        page: this.pagination.currentPage
      }).then(response => {
        responseDataFormat(response, this);
      });
    },
    handleAddAdminUser() {
      this.$refs["addForm"].validate(valid => {
        if (valid) {
          addAdminUser(this.addForm).then(response => {
            console.log(response);
            addSuccess(this);
          });
        } else {
          return false;
        }
      });
    },
    handleEditAdminUser() {
      this.$refs["editForm"].validate(valid => {
        if (valid) {
          editAdminUser(this.nowRowData.row.id, this.editForm).then(
            response => {
              editSuccess(this);
            }
          );
        } else {
          return false;
        }
      });
    }
  },
  created() {
    this.requestData();
  }
};
</script>
