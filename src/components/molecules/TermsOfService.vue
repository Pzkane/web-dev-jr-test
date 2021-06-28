<template>
  <div>
    <Checkbox />
    <span>I agree to <a href="#">terms of service</a></span>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Checkbox from "@components/atoms/Checkbox.vue";

@Options({
  components: {
    Checkbox,
  },
})
export default class TermsOfService extends Vue {}
</script>

<style scoped lang="scss">
div {
  display: flex;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 16px;
  align-items: center;

  & span {
    margin-left: 15px;
    color: #6a707b;
  }
  & a {
    color: #131821;
    &:hover {
      color: #4066a5;
    }
    &:focus {
      color: #233759;
    }
  }
}
</style>
