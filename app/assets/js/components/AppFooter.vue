<template>
  <footer :class="$style.component">
    <p>Made with Vue and Symfony</p>
    <p>2021</p>
  </footer>
</template>

<script lang="ts">

import {defineComponent} from "vue";

export default defineComponent({
  name: 'AppFooter',
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  align-items: center;
  //align-self: stretch;
  background: $light; /* fallback for old browsers */
  border: 0.5em solid darken($light, 5);
  border-radius: 5em;
  color: white;
  display: flex;
  font-weight: bolder;
  flex-direction: column;
  margin-bottom: .1em;
  padding: 1em  2em .8em 2em;

  p {
    margin: .3em 0;
  }
}
</style>