<template>
  <div class="wrapper">
    <p>{{ header }}</p>
    <div>
      <div
        class="option"
        v-for="option in options"
        :key="option.value"
        :value="option.label"
        @click="close = 'X'"
      >
        {{ option.label }} {{ close }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";
import { Prop } from "vue-property-decorator";

export interface OptionType {
  value: any;
  label: string;
}

export default class LabeledSelect extends Vue {
  @Prop({ required: true }) readonly options!: OptionType;
  @Prop() readonly header: string = "";

  private close = "";
}
</script>

<style scoped lang="scss">
.wrapper {
}
.option {
  &:hover {
    background-color: #b8c2d4;
    cursor: pointer;
  }
}
</style>