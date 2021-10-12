<template>
  <div class="chart">
    <div class="title">{{ `Period balance by ${this.period}` }}</div>
    <BarChart v-if="values.length !== 0" ref="barRef" :chartData="elData" :options="elOptions"/>
    <div v-show="values.length === 0 && !loading">No Transactions in chosen time period</div>
  </div>
</template>

<script lang='ts'>
import {defineComponent} from "vue";
import {BarChart} from "vue-chart-3";
import {Chart, ChartData, ChartOptions, registerables} from "chart.js";
import {fetchPeriodBalance} from "../../services/StatisticsService";

Chart.register(...registerables);

export default defineComponent({
  name: "PeriodBalanceChart",
  components: {BarChart},
  props: {
    period: {
      type: String,
      required: true,
    },
    from: {
      type: String,
      required: true,
    },
    to: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      loading: true,
      values: [] as Array<number>,
      labels: [] as Array<string>,
    }
  },
  computed: {
    elData(): ChartData<"bar"> {
      return {
        labels: this.labels,
        datasets: [
          {
            data: this.values,
            backgroundColor: this.backgroundColors,
            borderRadius: 50/this.values.length,
          }
        ]
      }
    },
    elOptions(): ChartOptions {
      return {
        plugins: {
          legend: {
            display: false,
          },
        }
      }
    },
    backgroundColors(): Array<string> {
      let colors = new Array<string>()
      for (let value of this.values) {
        if (value >= 0) colors.push("#008800")
        else colors.push("#dd0000")
      }
      return colors;
    }
  },
  methods: {
    refresh(period: string, from: string, to?: string) {
      fetchPeriodBalance(period, from, to).then((balance) => {
        if (balance) {
          this.values = []
          this.labels = []
          for (let period of balance) {
            this.values.push(period.value / 100)
            this.labels.push(period.period)
          }
        }
        this.loading = false;
      })
    }
  },
  created() {
    this.refresh(this.period, this.from, this?.to);
  },
  watch: {
    period: function (newPeriod) {
      this.refresh(newPeriod, this.from, this?.to)
    },
    from: function (newFrom) {
      this.refresh(this.period, newFrom, this?.to)
    },
    to: function (newTo) {
      this.refresh(this.period, this.from, newTo)
    },
  }
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";
</style>
