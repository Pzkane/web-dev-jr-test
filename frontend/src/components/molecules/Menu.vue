<template>
  <div id="wrapper">
    <div id="logo">
      <Logo />
    </div>
    <div id="nav">
      <a href="#">About</a>
      <a href="#">How it works</a>
      <a href="#">Contact</a>
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Logo from "@components/atoms/Logo.vue";

@Options({
  components: {
    Logo,
  },
})
export default class Menu extends Vue {}
</script>

<style scoped lang="scss">
#wrapper {
  float: left;
  padding: 10px 0;
  display: flex;
  justify-content: center;
  align-items: center;
  justify-content: spa;

  @media screen and (max-width: 800px) {
    justify-content: space-between;
  }

  & #logo {
    margin-right: 113px;
    @media screen and (max-width: 800px) {
      margin-left: 20px;
      margin-right: 0;
    }
  }

  & #nav {
    @media screen and (min-width: 800px) {
      padding-top: 11px;
    }
  }

  & img {
    margin: 10px 20px 16px;
  }

  & a {
    font-family: Arial, Helvetica, sans-serif;
    align-self: flex-end;
    justify-content: flex-end;
    text-decoration: none;
    color: #6a707b;
    margin: 0 15px;

    &:active {
      color: #484b52;
    }

    @media screen and (max-width: 800px) {
      font-size: 14px;
      padding-bottom: 0;
      align-self: center;
      margin: 0;
      margin-right: 20px;
    }
  }
}
</style>
