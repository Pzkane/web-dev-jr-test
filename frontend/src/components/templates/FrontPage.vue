<template>
  <div id="wrapper">
    <div id="content">
      <Menu class="menu" />
      <div class="newsletter">
        <Newsletter />
      </div>
    </div>
    <div id="image-wrapper">
      <img src="@assets/image_summer.png" alt="Image Summer" />
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Menu from "@components/molecules/Menu.vue";
import Newsletter from "@components/organisms/Newsletter.vue";

@Options({
  components: {
    Menu,
    Newsletter,
  },
})
export default class FrontPage extends Vue {}
</script>

<style scoped lang="scss">
.menu {
  @media screen and (max-width: 800px) {
    background-color: white;
    margin: 0;
    width: 100%;
    height: 46px;
  }
}
.newsletter {
  @media screen and (max-width: 800px) {
    background: linear-gradient(180deg, #ffffff 0%, #f2f5fa 100%);
    margin: 0 auto;
    max-width: 92%;
    margin-top: 254px;
  }
}
#wrapper {
  display: flex;
}
#content {
  padding: 100px 0 0 100px;
  width: 30%;
  min-width: 580px;
  z-index: 1;

  @media screen and (max-width: 800px) {
    padding: 0;
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    width: 100%;
    min-width: 375px;
  }
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

  @media screen and (max-width: 800px) {
    display: none;
  }
}
</style>
