<template>
  <div @click="$router.push({name: link})" :class="$style.component">
    <slot>
      default header
    </slot>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: "MenuItem",
  props: {
    link: {
      type: String,
      required: true,
    },
  },
})
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  display: flex;
  cursor: pointer;
  color: $light;
  font-weight: bold;
  font-size: large;
  margin: .5em 0;
  transition: .5s;

  &:hover {
    color: $dark;
  }
}
</style>