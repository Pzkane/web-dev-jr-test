<template>
  <div>
    <div id="logo">
      <Logo />
    </div>
    <a href="#">About</a>
    <a href="#">How it works</a>
    <a href="#">Contact</a>
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
div:first-child {
  float: left;
  margin: 10px 0;
  display: flex;
  justify-content: center;
  align-items: center;

  & #logo {
    margin-right: 113px;
  }

  & img {
    margin: 10px 20px 16px;
  }

  & a {
    font-family: Arial, Helvetica, sans-serif;
    align-self: flex-end;
    padding-bottom: 11px;
    text-decoration: none;
    color: #6a707b;
    margin: 0 15px;

    &:active {
      color: #484b52;
    }
  }
}
</style>
