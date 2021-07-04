<template>
  <div>
    <label for="d-input">{{ label }}</label>
    <input
      v-model="input"
      name="d-input"
      id="d-input"
      @input="handleInput"
      type="text"
    />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { Prop } from "vue-property-decorator";

@Options({
  emits: ["out"],
})
export default class DebouncedInput extends Vue {
  @Prop() readonly delay?: number = 0;
  @Prop({ required: true }) readonly label!: string;

  private timeout: number | undefined = undefined;
  private input: string | null = "";

  public handleInput(): void {
    if (this.timeout) clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.$emit("out", this.input);
    }, this.delay);
  }
}
</script>