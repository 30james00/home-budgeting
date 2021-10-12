<template>
  <div :class="$style.component">
    <div :class="$style.label">{{ label }}</div>
    <div :class="$style.value">{{ value }}</div>
  </div>
</template>

<script lang="ts">

import {defineComponent} from "vue";

export default defineComponent({
  name: 'LabelValue',
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: String,
      required: true,
    },
  }
});
</script>

<style lang="scss" module>
.component {
  padding: .5em 1em;
}

.label {
  font-size: small;
  color: darkslategray;
  margin-bottom: .25em;
}

.value {
  font-size: x-large;
  font-weight: bolder;
}
</style>