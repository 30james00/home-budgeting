<template>
  <div :class="$style.component" :style="{'background-color': bg}">
    <div :class="$style.title">{{ title }}</div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: "Tag",
  props: {
    title: {
      type: String,
      required: true
    },
    bg: {
      type: String,
      required: false
    }
  }
})
</script>

<style lang="scss" module>
.component {
  background-color: green;
  border-radius: 2em;
  display: flex;
  font-size: small;
  margin: .5em 0;
  padding: .6em 0.8em;

  .title {
    color: white;
  }
}
</style>