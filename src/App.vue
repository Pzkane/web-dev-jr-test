<template>
  <FrontPage />
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import FrontPage from "@templates/FrontPage.vue";

@Options({
  components: {
    FrontPage,
  },
})
export default class App extends Vue {}
</script>

<style lang="scss">
body {
  margin: 0 auto;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0 auto;
}
</style>
