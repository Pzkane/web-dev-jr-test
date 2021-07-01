<template>
  <div class="wrapper">
    <div class="container">
      <div v-if="!subscribed">
        <h1>Subscribe to newsletter</h1>
        <h2>
          Subscribe to our newsletter and get 10% discount on pineapple glasses.
        </h2>
        <Input class="input" :customError="inputError" @validated="submit" />
        <TermsOfService
          :displayError="tosInvalid"
          @change="assignToS"
          class="tos"
        />
      </div>
      <div v-if="subscribed" class="thanks-container">
        <Thanks class="thanks" />
      </div>
      <div>
        <hr />
        <div class="social-buttons">
          <SocialButton
            :imageFile="'ic_facebook.svg'"
            :onHoverBgColor="'#4267B2'"
            :onClickBgColor="'#2F4A80'"
            :onClickBorderColor="'#2F4A80'"
            :onHoverBorderColor="'#4267B2'"
            :onActiveIconContrast="3"
          />
          <SocialButton
            :imageFile="'ic_instagram.svg'"
            :onHoverBgColor="'#C13584'"
            :onClickBgColor="'#8F2762'"
            :onClickBorderColor="'#8F2762'"
            :onHoverBorderColor="'#C13584'"
            :onActiveIconContrast="3"
          />
          <SocialButton
            :imageFile="'ic_twitter.svg'"
            :onHoverBgColor="'#1DA1F2'"
            :onClickBgColor="'#177FBF'"
            :onClickBorderColor="'#177FBF'"
            :onHoverBorderColor="'#1DA1F2'"
            :onActiveIconContrast="3"
          />
          <SocialButton
            :imageFile="'ic_youtube.svg'"
            :onHoverBgColor="'#FF0000'"
            :onClickBgColor="'#CC0000'"
            :onClickBorderColor="'#CC0000'"
            :onHoverBorderColor="'#FF0000'"
            :onActiveIconContrast="3"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { baseURL } from "@/constants";
import { Vue, Options } from "vue-class-component";
import Input from "@/components/molecules/Input.vue";
import TermsOfService from "@/components/molecules/TermsOfService.vue";
import SocialButton from "@/components/atoms/SocialButton.vue";
import Thanks from "@components/organisms/Thanks.vue";

@Options({
  components: {
    Input,
    SocialButton,
    TermsOfService,
    Thanks,
  },
  emits: ["subscribed"],
})
export default class Newsletter extends Vue {
  private tosCheckbox = false;
  private tosInvalid = false;
  private subscribed = false;
  private inputError = "";

  public async submit(email: string): Promise<void> {
    if (this.tosInvalid) return;
    if (!this.tosCheckbox) {
      this.tosInvalid = true;
      return;
    }

    const fData = new FormData;
    fData.append("email", email);

    try {
      this.inputError = "";
      const { data:data } = await this.axios.post(`${baseURL}/subscribe.php`, fData);

      console.log(data);
      

      if (Object.prototype.hasOwnProperty.call(data, "error")) {
        this.inputError = data.error;
      }

      if (Object.prototype.hasOwnProperty.call(data, "success")) {
        this.subscribed = true;
      }
    } catch (error) {
      console.log(error);
    }
  }

  public assignToS(value: boolean): void {
    this.tosCheckbox = value;
    this.tosCheckbox ? (this.tosInvalid = false) : null;
  }
}
</script>

<style scoped lang="scss">
.tos {
  margin-top: 173px;
  @media screen and (max-width: 800px) {
    margin-top: 0;
    display: inline-flex;
  }
}
.input {
  position: absolute;
  left: 100px;
  margin-top: 35px;
  @media screen and (max-width: 800px) {
    margin-top: 20px;
    position: static;
  }
}
.social-buttons {
  margin-top: 50px;
  display: flex;
  width: auto;
  justify-content: center;

  @media screen and (max-width: 800px) {
    margin-top: 20px;
    padding-bottom: 30px;
  }
}
.social-buttons *:not(:last-child) {
  margin-right: 20px;
}
.container {
  margin: 54px 0 0 36px;
  margin-top: 234px;
  margin-bottom: 50px;
  max-width: 400px;

  @media screen and (max-width: 800px) {
    margin: 20px 20px 20px;
    max-width: 100%;
    margin-bottom: 20px;
    margin-top: 0;
  }
}
.thanks-container {
  margin-top: -30px;
}
.thanks {
  @media screen and (max-width: 800px) {
    padding-top: 30px;
  }
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

  @media screen and (max-width: 800px) {
    font-size: 24px;
    padding-top: 20px;
    margin-bottom: 0;
  }
}
h2 {
  color: #6a707b;
  font-size: 16px;

  @media screen and (max-width: 800px) {
    font-size: 14px;
  }
}
hr {
  margin-top: 50px;
  border-top: #e3e3e4;

  @media screen and (max-width: 800px) {
    margin-top: 20px;
  }
}
</style>
