<template>
  <div class="chart">
    <div class="title">Expenditures by category</div>
    <DoughnutChart v-if="values.length !== 0" ref="doughnutRef" :chartData="elData"/>
    <div v-show="values.length === 0 && !loading">No Transactions in chosen time period</div>
  </div>
</template>

<script lang='ts'>
import {defineComponent} from "vue";
import {DoughnutChart} from "vue-chart-3";
import {Chart, ChartData, registerables} from "chart.js";
import {fetchCategorySums} from "../../services/StatisticsService";

Chart.register(...registerables);

export default defineComponent({
  name: "CategorySumChart",
  components: {DoughnutChart},
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
  data() {
    return {
      loading: true,
      values: [] as Array<number>,
      labels: [] as Array<string>,
      colors: [] as Array<string>,
    }
  },
  computed: {
    elData(): ChartData<"doughnut"> {
      return {
        labels: this.labels,
        datasets: [
          {
            data: this.values,
            backgroundColor: this.colors,
          }
        ]
      }
    },
  },
  methods: {
    refresh(from: string, to?: string) {
      fetchCategorySums(from, to).then((categories) => {
        if (categories) {
          this.values = []
          this.labels = []
          this.colors = []
          for (let category of categories) {
            this.values.push(category.sum / 100)
            this.labels.push(category.name)
            this.colors.push(category.color)
          }
        }
        this.loading = false;
      })
    }
  },
  created() {
    this.refresh(this.from, this?.to);
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
</style>
