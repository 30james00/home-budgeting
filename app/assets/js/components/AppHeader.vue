<template>
  <header :class="$style.component">
    <div :class="$style.left">
      <div @click="$router.push({name:'Home'})" :class="$style.brand">
        <font-awesome-icon :class="$style.icon" icon="donate" size="2x"/>
        <h1 :class="$style.text">Home Budgeting</h1>
      </div>
      <div v-if="store.state.user" :class="$style.menu">
        <menu-item link="Statistics">Statistics</menu-item>
        <menu-item link="ListTransaction">List Transactions</menu-item>
        <menu-item link="CreateTransaction">Add Transaction</menu-item>
      </div>
    </div>
    <div :class="$style.user">
      <font-awesome-icon :class="$style.icon" icon="user-circle" size="lg"/>
      <menu-item v-if="!store.state.user" link="Login">Login</menu-item>
      <menu-item @click="handleLogout" v-if="store.state.user" link="">Logout</menu-item>
    </div>
  </header>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import MenuItem from "./MenuItem.vue";
import {useStore} from "../store";
import {logout} from "../services/AuthService";

export default defineComponent({
  name: 'AppHeader',
  components: {MenuItem},
  data() {
    return {
      store: useStore(),
    }
  },
  methods: {
    async handleLogout() {
      this.store.commit('deleteUser')
      await logout()
      await this.$router.push({name: 'Home'})
    },
  },
});
</script>

<style lang="scss" module>
@import '~styles/variables.scss';

.component {
  @include row;
  align-items: center;
  justify-content: space-between;
  margin: 0 1em 1.25em 1em;
  flex-wrap: nowrap;

  h1 {
    @include no-space;
    margin: .5em 1em .25em 0;
    background: #093028; /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, $dark, $light); /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, $dark, $light); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  @media screen and (max-width: 600px) {
    h1 {
      font-size: x-large;
    }
  }

  .left {
    @include row;
    align-items: center;
  }

  .brand {
    @include row;
    align-items: center;
    cursor: pointer;
    flex-wrap: nowrap;
  }

  .icon {
    margin-right: .25rem;
    color: $dark;
  }


  .menu {
    @include row;
    @include multi-margin;

  }

  .user {
    @include row;
    align-items: center;
    flex-wrap: nowrap;
    margin-left: 1em;
  }
}
</style>