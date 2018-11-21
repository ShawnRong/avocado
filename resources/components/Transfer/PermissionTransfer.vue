<template>
    <el-transfer v-model="temp" :data="assignList" :titles="[ $t('toAssign'), $t('assigned')]"></el-transfer>
</template>
<script>
export default {
  name: "PermissionTransfer",
  props: ["assignList", "submitData"],
  data() {
    return {
      temp: []
    };
  },
  created() {
    this.temp = this.submitData;
  },
  watch: {
    temp() {
      let assignedTransferList = this.temp.map(
        index => this.assignList[index - 1].label
      );
      this.$emit("update:submitData", assignedTransferList);
    }
  }
};
</script>

