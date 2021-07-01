<template>
  <router-view />
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
html,
body {
  min-height: 100%;
  margin: 0 auto;
  padding: 0;
}
body {
  @media screen and (max-width: 800px) {
    background-image: url("~@assets/image_summer.png");
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0 auto;
}
</style>
