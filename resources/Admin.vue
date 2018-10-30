<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>
<script>
export default {
  name: "App",
  mounted() {
    console.log("App component mounted");
  }
};
</script>
