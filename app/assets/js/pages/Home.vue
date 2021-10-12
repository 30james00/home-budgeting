<template>
  <div :class="$style.component">
    <div :class="$style.banner">
      <div>Your budget,</div>
      <div>easier and faster</div>
    </div>
    <div :class="$style.function">
      <font-awesome-icon icon="plus-circle" :class="$style['function-icon']"></font-awesome-icon>
      <div>Quickly add your transactions from different categories</div>
    </div>
    <div :class="$style.function">
      <font-awesome-icon icon="chart-area" :class="$style['function-icon']"></font-awesome-icon>
      <div>Sort and filter your transactions</div>
    </div>
    <div :class="$style.function">
      <font-awesome-icon icon="sort-amount-up" :class="$style['function-icon']"></font-awesome-icon>
      <div>Analyze your budget using graphs and statistics</div>
    </div>
    <div :class="$style.buttons">
      <custom-button v-if="!store.state.user" @click="$router.push({name: 'Login'})" text="Login now" bg="#237A57"></custom-button>
      <custom-button v-if="store.state.user" @click="$router.push({name: 'Statistics'})" text="Show statistics" bg="#237A57"></custom-button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import CustomButton from "../components/common/CustomButton.vue";
import {useStore} from "../store";

export default defineComponent({
  name: 'Home',
  components: {CustomButton},
  data() {
    return {
      store: useStore(),
    }
  },
});
</script>

<style lang="scss" module>
@import '~styles/variables.scss';

.component {
  @include col;
  justify-content: center;
  height: 75vh;

  .banner {
    @include col;
    font-size: xxx-large;
    font-weight: 700;
    word-spacing: .15em;
    margin-bottom: .5em;

    background: #093028; /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, $dark, $light); /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, $dark, $light); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .function {
    @include row;
    align-items: center;
    flex-wrap: nowrap;
    font-size: larger;
    margin: .5em 0;

    .function-icon {
      margin-right: .25em;
    }
  }

  .buttons {
    margin-top: 1em;
  }
}
</style>