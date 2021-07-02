<template>
  <button v-if="imageFile" :style="generateClass" class="socialButton">
    <img :src="getStaticPath" alt="Social Button" />
  </button>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";
import { Prop } from "vue-property-decorator";

interface StyleVars {
  "--bg-color-hover"?: string;
  "--bg-color-active"?: string;
  "--border-color-hover"?: string;
  "--border-color-active"?: string;
  "--icon-contrast-active"?: number;
}

export default class SocialButton extends Vue {
  @Prop({ required: true }) readonly imageFile!: string;
  @Prop() readonly onHoverBgColor?: string;
  @Prop() readonly onClickBgColor?: string;
  @Prop() readonly onHoverBorderColor?: string;
  @Prop() readonly onClickBorderColor?: string;
  @Prop() readonly onActiveIconContrast?: number = 0;

  public get getStaticPath(): string {
    let svgImg = require("@assets/" + this.imageFile);
    return svgImg;
  }

  public get generateClass(): StyleVars {
    let style: StyleVars = {};
    style["--bg-color-hover"] = this.onHoverBgColor;
    style["--bg-color-active"] = this.onClickBgColor;
    style["--border-color-hover"] = this.onHoverBorderColor;
    style["--border-color-active"] = this.onClickBorderColor;
    style["--icon-contrast-active"] = this.onActiveIconContrast;

    return style;
  }
}
</script>

<style scoped lang="scss">
.socialButton {
  & img {
    padding-top: 3px;
  }

  &:hover {
    background-color: var(--bg-color-hover);
    border-color: var(--border-color-hover);
  }

  &:active {
    background-color: var(--bg-color-active);
    border-color: var(--border-color-active);
  }

  &:hover,
  &:active {
    box-shadow: 0px 20px 40px rgba(19, 24, 33, 0.3);
    & img {
      filter: #{"contrast(var(--icon-contrast-active))"};
    }
  }
}
button {
  width: 46px;
  height: 46px;
  border: 2px solid #e3e3e4;
  border-radius: 25px;
  background-color: transparent;
  place-content: center;
  z-index: 1;

  &:hover {
    cursor: pointer;
  }
}
</style>
