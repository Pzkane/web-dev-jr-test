<template>
  <div class="wrapper">
    <div class="chkbox">
      <Checkbox @change="returnChange" />
      <span>I agree to <a href="#">terms of service</a></span>
    </div>
    <div>
      <p v-if="displayError">You must accept the terms and conditions</p>
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Checkbox from "@components/atoms/Checkbox.vue";
import { Prop } from "vue-property-decorator";

@Options({
  components: {
    Checkbox,
  },
  emits: ["change"],
})
export default class TermsOfService extends Vue {
  @Prop() readonly displayError = false;

  public returnChange(value: boolean): void {
    this.$emit("change", value);
  }
}
</script>

<style scoped lang="scss">
.chkbox {
  display: flex;
  align-items: center;
}
.wrapper {
  display: flex;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 16px;
  align-items: flex-start;
  flex-direction: column;

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

  & div > p {
    color: red;
    font-size: 12px;
  }
}
</style>
