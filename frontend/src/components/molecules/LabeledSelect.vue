<template>
  <div>
    <div class="header">
      <p>{{ header }}</p>
      <button v-if="selected" @click="chooseDomain(null)">Clear</button>
    </div>

    <div>
      <button
        class="option"
        v-for="option in options"
        :key="option.value"
        :value="option.label"
        @click="chooseDomain(option.value)"
      >
        {{ option.label }} {{ close }}
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Prop } from "vue-property-decorator";

export interface OptionType {
  value: string;
  label: string;
}

@Options({
  emits: ["domain"],
})
export default class LabeledSelect extends Vue {
  @Prop({ required: true }) readonly options!: OptionType;
  @Prop() readonly header: string = "";

  private close = "";
  private selected: string | null = "";

  public chooseDomain(opVal: string | null): void {
    this.selected = opVal;
    this.$emit("domain", opVal);
  }
}
</script>

<style scoped lang="scss">
.header {
  display: flex;
  align-items: center;

  & button {
    margin-left: 40px;
    background-color: white;
    border: solid 1px;
    border-radius: 20px;
    height: 18px;
    text-align: center;

    &:focus,
    &:hover {
      cursor: pointer;
    }

    &:active {
      background-color: rgb(131, 64, 64);
    }

    &:hover {
      background-color: rgb(238, 238, 238);
    }
  }
}
.option {
  &:hover {
    background-color: #b8c2d4;
    cursor: pointer;
  }
}
</style>