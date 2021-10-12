<template>
  <div :class="$style.component">
    <div v-show="loading">loading...</div>
    <div v-show="error">Error loading statistics</div>
    <div v-if="!loading" :class="$style.container">
      <label-value label="Balance" :value="normalizeFloat(statistics.balance)"></label-value>
      <label-value label="Transaction count" :value="statistics.count.toString()"></label-value>
      <label-value label="Expenditures" :value="normalizeFloat(statistics.expenditureSum)"></label-value>
      <label-value label="Income" :value="normalizeFloat(statistics.incomeSum)"></label-value>
      <label-value label="Average expenditure" :value="normalizeFloat(statistics.expenditureAvg)"></label-value>
      <label-value label="Average income operation" :value="normalizeFloat(statistics.incomeAvg)"></label-value>
    </div>
  </div>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import {IStatistics} from "../interfaces/IStatistics";
import {getStatistics} from "../services/StatisticsService";
import LabelValue from "./common/LabelValue.vue";
import {normalizeFloat} from "../helpers/NumberHelpers";

export default defineComponent({
  name: 'StatisticsView',
  components: {LabelValue},
  data() {
    return {
      loading: true,
      error: false,
      statistics: {} as IStatistics
    }
  },
  props: {
    from: {
      type: String,
      required: true,
    },
    to: {
      type: String,
      required: false,
    },
  },
  methods: {
    normalizeFloat(val: number) {
      return normalizeFloat(val)
    },
    async refresh(from: string, to?: string) {
      let stats = await getStatistics(from, to)
      if (stats) {
        this.statistics = stats
        this.error = false
      } else {
        this.error = true
      }
      this.loading = false
    }
  },
  async created() {
    await this.refresh(this.from, this?.to)
  },
  watch: {
    from: function (newFrom) {
      this.refresh(newFrom, this?.to)
    },
    to: function (newTo) {
      this.refresh(this.from, newTo)
    },
  }
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  @include col;
}

.container {
  @include row;
  transition: 1s;
  padding: .5em 0;
  border-radius: 1em;
  background-color: white;
}
</style>