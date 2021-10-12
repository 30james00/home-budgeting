<template>
  <div :class="$style.component">
    <div :class="$style.wrapper">
      <app-header></app-header>
      <router-view :class="$style.content"></router-view>
      <app-footer></app-footer>
    </div>
  </div>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import AppHeader from "@/components/AppHeader.vue";
import AppFooter from "@/components/AppFooter.vue";

export default defineComponent({
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
  },
  beforeCreate() {
    if ((window as any).user) {
      this.$store.commit('setUser', {
        user: (window as any).user
      })
    }
  }
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  @include col;
  align-items: center;
  max-width: 1250px;

  .wrapper {
    @include col;
    align-items: stretch;

    .content {
      margin: 0 1em 1em 1em;
    }
  }

}

</style>