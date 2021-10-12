<template>
  <div :class="$style.component">
    <h2>Log in</h2>
    <form @submit.prevent="handleSubmit">
      <label for="email">Email</label>
      <input v-model="email" required type="email" name="email" id="email">
      <label for="password">Password</label>
      <input v-model="password" required type="password" name="password" id="password">
      <custom-button :class="$style.button" text="Login" bg="#237A57"></custom-button>
    </form>
    <div class="error">{{ error }}</div>
  </div>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import CustomButton from "../../components/common/CustomButton.vue";
import {login} from "../../services/AuthService";
import {useToast} from "vue-toastification";

export default defineComponent({
  name: 'Login',
  components: {CustomButton},
  data() {
    return {
      email: "",
      password: "",
      error: "",
    }
  },
  methods: {
    async handleSubmit() {
      let response;
      try {
        response = await login(this.email, this.password)
        useToast().success(`Logged in successfully`)
        await this.$store.dispatch('getCurrentUser', {
              iri: response.headers["location"]
            }
        )
        await this.$router.push({name: 'Home'})
      } catch
          (error) {
        this.error = error.message
      }
    }
  }
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  @include col;

  h2 {
    margin-bottom: 1em;
  }

  form {
    @include col;
    max-width: 300px;
  }

  label {
    margin-bottom: .25em;
  }

  .button {
    align-self: flex-start;
    margin-top: 1em;
    max-width: 100px;
  }
}
</style>