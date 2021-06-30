<template>
  <div>
    <img src="@assets/ic_success.svg" alt="Trophy" />
    <h1>Thanks for subscribing!</h1>
    <h2>You have successfully subscribed to our email listing. Check your email for the discount code.</h2>
  </div>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";

export default class Thanks extends Vue {}
</script>

<style scoped lang="scss">
h1,
h2 {
  font-weight: 400;
  max-width: 500px;
  line-height: 28px;
}
h1 {
  font-family: Georgia, "Times New Roman", Times, serif;
  font-size: 32px;
  line-height: 44px;

  @media screen and (max-width: 800px) {
    font-size: 24px;
    padding-top: 20px;
  }
}
h2 {
  color: #6a707b;
  font-size: 16px;

  @media screen and (max-width: 800px) {
    font-size: 14px;
  }
}
</style>
