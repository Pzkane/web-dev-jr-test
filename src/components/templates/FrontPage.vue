<template>
  <div id="wrapper">
    <div id="content">
      <Menu />
      <Newsletter />
    </div>
    <div id="image-wrapper">
      <img src="@assets/image_summer.png" alt="Image Summer" />
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue, setup } from "vue-class-component";
import { onMounted, ref } from "@vue/runtime-core";
import Menu from "@components/molecules/Menu.vue";
import Newsletter from "@components/organisms/Newsletter.vue";

@Options({
  components: {
    Menu,
    Newsletter,
  },
})
export default class FrontPage extends Vue {
  myContext = setup(() => {
    const count = ref(0);

    function increment() {
      count.value++;
    }

    onMounted(() => {
      console.log("onMounted");
    });

    return {
      count,
      increment,
    };
  });
}
</script>

<style scoped lang="scss">
#wrapper {
  display: flex;
}
#content {
  padding: 100px 0 0 100px;
  width: 30%;
  min-width: 580px;
  z-index: 1;
}
#image-wrapper {
  overflow: hidden;
  display: contents;
  max-width: 50%;

  & img {
    height: 100vh;
    width: 100%;
    object-fit: cover;
    overflow: hidden;
  }
}
</style>
