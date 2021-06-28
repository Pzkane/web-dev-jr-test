<template>
  <div>
    <div class="wrapper">
      <h1>Subscribe to newsletter</h1>
      <h2>
        Subscribe to our newsletter and get 10% discount on pineapple glasses.
      </h2>
    </div>
    <Input />
    <div class="wrapper">
      <TermsOfService />
      <hr />
      <div class="social-buttons">
        <SocialButton :imageFile="'ic_facebook.svg'" />
        <SocialButton :imageFile="'ic_instagram.svg'" />
        <SocialButton :imageFile="'ic_twitter.svg'" />
        <SocialButton :imageFile="'ic_youtube.svg'" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Input from "@/components/molecules/Input.vue";
import TermsOfService from "@/components/molecules/TermsOfService.vue";
import SocialButton from "@/components/atoms/SocialButton.vue";

@Options({
  components: {
    Input,
    TermsOfService,
    SocialButton,
  },
})
export default class Newsletter extends Vue {}
</script>

<style scoped lang="scss">
.social-buttons {
  margin-top: 50px;
  display: flex;
  width: auto;
  justify-content: center;
}
.social-buttons *:not(:last-child) {
  margin-right: 20px;
}
div {
  & .wrapper:first-child {
    margin-top: 234px;
    margin-bottom: 50px;
  }
}
.wrapper {
  margin: 54px 0 0 36px;
  max-width: 400px;
}
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
}
h2 {
  color: #6a707b;
  font-size: 16px;
}
hr {
  margin-top: 50px;
  border-top: #e3e3e4;
}
</style>
