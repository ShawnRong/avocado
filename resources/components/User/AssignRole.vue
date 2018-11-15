<template>
  <el-dialog :title="$t('assignRole')" :visible.sync="visible" width="40%">
    <el-row>
      <el-checkbox-group v-model="userRoles">
        <el-col
                class="item"
                :span="4"
                v-for="role in roles"
                :key="role"><el-checkbox :label="role" border>{{ role }}</el-checkbox>
        </el-col>
      </el-checkbox-group>
    </el-row>
    <div slot="footer" class="dialog-footer">
      <el-button @click="visible = false">{{ $t('cancel') }}</el-button>
      <el-button type="primary" @click="assignRole">{{ $t('confirm') }}</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { getUserRoles, assignRoles } from "../../api/user.js";
import { guardNameRoles } from "../../api/role.js";
import notify from "../../utils/notify.js";

export default {
  name: "UserAssignRole",
  props: ["userId", "guardName", "dialogVisible"],
  data() {
    return {
      visible: this.dialogVisible,
      roles: [],
      userRoles: []
    };
  },
  methods: {
    assignRole() {
      assignRoles(this.userId, this.userRoles).then(response => {
        this.visible = false;
        notify.editSuccess(this);
      });
    }
  },
  watch: {
    dialogVisible(newValue) {
      this.roles = [];
      this.userRoles = [];
      this.visible = newValue;
      if (newValue) {
        let guardRoles = guardNameRoles(this.guardName);
        let userRoles = getUserRoles(this.userId);

        Promise.all([guardRoles, userRoles])
          .then(result => {
            let roles = [];
            result[0].data.roles.forEach(role => {
              roles.push(role.name);
            });

            let userRoles = [];

            result[1].data.forEach(role => {
              userRoles.push(role);
            });

            this.roles = roles;
            this.userRoles = userRoles;
          })
          .catch(error => {
            this.visible = false;
          });
      }
    },
    visible(newValue) {
      this.$emit("update:dialogVisible", newValue);
    }
  }
};
</script>
<style rel="stylesheet/scss" lang="scss" scoped>
.item {
  margin-bottom: 15px;
}
</style>