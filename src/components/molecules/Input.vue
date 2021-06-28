<template>
  <div :class="{ '--hover --active': focus, '--hover': hover }">
    <input
      @mouseover="hover = true"
      @mouseleave="hover = false"
      @focusout="focus = false"
      @focus="focus = !focus"
      type="text"
      placeholder="Type your email address here…"
    />
    <ArrowButton :color="focus ? '#4066A5' : undefined" id="arrbtn" />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import ArrowButton from "@components/atoms/ArrowButton.vue";

@Options({
  components: {
    ArrowButton,
  },
})
export default class Input extends Vue {
  private focus = false;
  private hover = false;
}
</script>

<style scoped lang="scss">
#arrbtn {
  height: 70px;
  width: 111px;
}
.--active {
  border: 1px solid #4066a5;
}
.--hover {
  outline: none;
  outline-width: 0;
  box-shadow: 0px 30px 40px rgba(19, 24, 33, 0.06);
}
div {
  width: 663px;
  background-color: #4066a5;
  height: 70px;
  border: 1px solid #e3e3e4;
  margin: 0;

  & * {
    display: flex;
    align-items: center;
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
}
</style>
