<template>
  <div class="wrapper">
    <div :class="{ '--hover --active': focus, '--hover': hover }">
      <input
        v-model="inputVal"
        @mouseover="hover = true"
        @mouseleave="hover = false"
        @focusout="focus = false"
        @focus="focus = !focus"
        type="text"
        placeholder="Type your email address here…"
        @input="validate"
      />
      <ArrowButton
        :disabled="disabled"
        @click="submit()"
        :color="focus ? '#4066A5' : undefined"
        id="arrbtn"
      />
    </div>
    <div class="error-container">
      <p class="error" v-if="error">{{ error }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import ArrowButton from "@components/atoms/ArrowButton.vue";
import { Prop, Watch } from "vue-property-decorator";

@Options({
  components: {
    ArrowButton,
  },
  emits: ["validated"],
})

export default class Input extends Vue {
  @Prop() readonly customError?: string;
  
  @Watch('customError')
  onCustomErrorChanged(err: string): void {
    console.log(err);
    
    this.error = err;
  }

  private focus = false;
  private hover = false;
  private inputVal = "";
  private error = "";

  public validate(): boolean {
    this.error = "";

    if (!this.inputVal) {
      this.error = "Email address is required";
      return false;
    }
    if (
      this.inputVal.match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.co)|(([a-zA-Z\-0-9]+\.)+co))$/
      )
    ) {
      this.error = "We are not accepting subscriptions from Colombia emails";
      return false;
    }
    const EMAIL_PATTERN =
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!this.inputVal.match(EMAIL_PATTERN)) {
      this.error = "Please provide a valid e-mail address";
      return false;
    }

    return true;
  }

  public submit(): void {
    if (!this.validate()) return;
    this.$emit("validated", this.inputVal);
  }

  public get disabled(): number {
    return this.error.length;
  }
}
</script>

<style scoped lang="scss">
#arrbtn {
  height: 70px;
  width: 111px;
  @media screen and (max-width: 800px) {
    height: 60px;
  }
}
.error-container {
  float: left;
  width: 100%;
  @media screen and (max-width: 800px) {
    margin-bottom: 20px;
  }
}
.error {
  color: red;
  font-size: 12px;
  flex-flow: column wrap;
  margin: 0;
  margin-top: 10px;
}
.--active {
  border: 1px solid #4066a5;
}
.--hover {
  outline: none;
  outline-width: 0;
  box-shadow: 0px 30px 40px rgba(19, 24, 33, 0.06);
}
.wrapper {
  width: 663px;
  height: 70px;
  border: 1px solid #e3e3e4;
  margin: 0;
  max-width: 100%;
  background-color: #4066a5;

  @media screen and (max-width: 800px) {
    & div {
      width: 663px;
      height: auto;
      max-width: calc(100% - 45px);
      & div {
        max-width: 100%;
      }
    }
  }

  @media screen and (min-width: 800px) {
    & > div {
      width: 663px;
      height: auto;
    }
  }

  & > *:not(:last-child) {
    display: flex;
    align-items: center;
  }

  @media screen and (max-width: 800px) {
    & > *:last-child {
      display: flex;
    }
  }
}
input {
  padding-left: 40px;
  border: 0;
  height: 68px;
  width: 600px;
  margin-left: 4px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 16px;
  font-weight: 400;
  color: #6a707b;

  &:focus {
    outline: none;
  }

  @media screen and (max-width: 800px) {
    padding-left: 15px;
    height: 58px;
  }
}
</style>
