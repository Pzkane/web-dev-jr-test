<template>
  <button v-if="imageFile">
    <img :src="getStaticPath" alt="Social Button" />
  </button>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";
import { Prop } from "vue-property-decorator";

export default class SocialButton extends Vue {
  @Prop({ required: true }) readonly imageFile?: string;

  public get getStaticPath(): string {
    return require("@assets/" + this.imageFile);
  }
}
</script>

<style scoped lang="scss">
button {
  width: 46px;
  height: 46px;
  border: 2px solid #e3e3e4;
  border-radius: 25px;
  background-color: white;
  place-content: center;
  z-index: 1;

  &:hover {
    cursor: pointer;
  }
}
</style>
