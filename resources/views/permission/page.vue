<template>
  <div class="app-container">
    <div class="filter-container">
      <el-form :inline="true" :model="queryParams"  size="mini">
        <el-input :placeholder="$t('name')" v-model="queryParams.name" style="width: 200px;" class="filter-item"></el-input>
        <el-input :placeholder="$t('permissionGroup')" v-model="queryParams.permissionGroup" style="width: 200px" class="filter-item"></el-input>
        <el-input :placeholder="$t('guardName')" v-model="queryParams.guardName" style="width: 200px" class="filter-item"></el-input>
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
              prop="display_name"
              align="center"
              :label="$t('displayName')">
      </el-table-column>
      <el-table-column
              prop="guard_name"
              align="center"
              :label="$t('guardName')">
      </el-table-column>
      <el-table-column
              prop="group.data.name"
              align="center"
              :label="$t('permissionGroup')">
      </el-table-column>
      <el-table-column
              prop="icon"
              align="center"
              :label="$t('icon')">
      </el-table-column>
      <el-table-column
              fixed="right"
              align="center"
              :label="$t('actions')"
              >
        <template slot-scope="scope">
          <el-button
                  type="primary"
                  size="mini"
                  @click="handleEdit(scope.$index, scope.row)">{{ $t('edit') }}</el-button>
          <el-button
                  size="mini"
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


    <el-dialog :title="$t('add')" :visible.sync="dialogAddFormVisible" width="40%">
      <el-form :model="addForm" :rules="rules" ref="addForm">
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('name')" prop="name" :label-width="formLabelWidth">
              <el-input v-model="addForm.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('displayName')" prop="display_name" :label-width="formLabelWidth">
              <el-input v-model="addForm.display_name"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('guardName')" prop="guard_name" :label-width="formLabelWidth">
              <guard-select :nowValue.sync="addForm.guard_name"></guard-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('permissionGroup')" prop="pg_id" :label-width="formLabelWidth">
              <permission-group-select :nowValue.sync="addForm.pg_id"></permission-group-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('icon')" prop="icon" :label-width="formLabelWidth">
              <el-input v-model="addForm.icon"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('sequence')" prop="sequence" :label-width="formLabelWidth">
              <el-input type="number" v-model="addForm.sequence"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item :label="$t('description')" prop="description" :label-width="formLabelWidth">
          <el-input v-model="addForm.description"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogAddFormVisible = false">{{ $t('cancel') }}</el-button>
        <el-button type="primary" @click="handleAddPermission">{{ $t('confirm') }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :title="$t('edit')" :visible.sync="dialogEditFormVisible" width="40%">
      <el-form :model="editForm" :rules="rules" ref="editForm">
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('name')" prop="name" :label-width="formLabelWidth">
              <el-input v-model="editForm.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('displayName')" prop="display_name" :label-width="formLabelWidth">
              <el-input v-model="editForm.display_name"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('guardName')" prop="guard_name" :label-width="formLabelWidth">
              <guard-select :nowValue.sync="editForm.guard_name"></guard-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('permissionGroup')" prop="pg_id" :label-width="formLabelWidth">
              <permission-group-select :nowValue.sync="editForm.pg_id"></permission-group-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item :label="$t('icon')" prop="icon" :label-width="formLabelWidth">
              <el-input v-model="editForm.icon"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="$t('sequence')" prop="sequence" :label-width="formLabelWidth">
              <el-input type="number" v-model="editForm.sequence"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item :label="$t('description')" prop="description" :label-width="formLabelWidth">
          <el-input v-model="editForm.description"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogEditFormVisible = false">{{ $t('cancel') }}</el-button>
        <el-button type="primary" @click="handleEditPermission">{{ $t('confirm') }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import {
  getPermissionList,
  addPermission,
  editPermission,
  deletePermission
} from "../../api/permission.js";
import {
  responseDataFormat,
  tableDefaultData,
  editSuccess,
  addSuccess,
  deleteSuccess
} from "../../utils/tableDataHandle.js";
import GuardSelect from "../../components/Select/Guard";
import PermissionGroupSelect from "../../components/Select/PermissionGroup";

export default {
  name: "permissionIndex",
  components: {
    GuardSelect,
    PermissionGroupSelect
  },
  data() {
    return {
      ...tableDefaultData(),
      addForm: {
        name: "",
        guard_name: "",
        description: ""
      },
      editForm: {
        name: "",
        guard_name: "",
        description: ""
      },
      rules: {
        name: [{ required: true }, { min: 1, max: 255 }],
        display_name: [{ required: true }, { min: 1, max: 255 }],
        guard_name: [{ required: true }, { min: 1, max: 255 }],
        pg_id: [{ required: true, type: "number" }]
      }
    };
  },
  methods: {
    requestData() {
      getPermissionList({
        ...this.queryParams,
        page: this.pagination.currentPage
      }).then(response => {
        responseDataFormat(response, this);
      });
    },
    handleAddPermission() {
      this.$refs["addForm"].validate(valid => {
        if (valid) {
          addPermission(this.addForm).then(response => {
            addSuccess(this);
          });
        } else {
          return false;
        }
      });
    },
    handleEdit(index, row) {
      this.editForm = row;
      this.nowRowData = { index, row };
      this.dialogEditFormVisible = true;
    },
    handleEditPermission() {
      this.$refs["editForm"].validate(valid => {
        if (valid) {
          editPermission(this.nowRowData.row.id, this.editForm).then(
            response => {
              editSuccess(this);
            }
          );
        } else {
          return false;
        }
      });
    },
    handleDelete(index, row) {
      deletePermission(row.id).then(response => {
        deleteSuccess(index, this);
      });
    }
  },
  created() {
    this.requestData();
  }
};
</script>

