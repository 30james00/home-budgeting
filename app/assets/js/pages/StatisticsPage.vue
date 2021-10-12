<template>
  <div :class="$style.component">
    <h2>Your statistics</h2>
    <div class="row">
      <div class="row">
        <div class="col">
          <label for="period">Split by:</label>
          <select name="period" id="period" v-model="period">
            <option value="day">Day</option>
            <option value="month">Month</option>
            <option value="year">Year</option>
          </select>
        </div>
        <div class="col" :class="$style.from">
          <label for="time-period">Time period:</label>
          <select name="time-period" id="time-period" v-model="timePeriod">
            <option value="week">Last 7 days</option>
            <option value="month">Last 30 days</option>
            <option value="3month">Last 90 days</option>
            <option value="year">Last year</option>
            <option value="5year">Last 5 years</option>
            <option value="custom">Custom</option>
          </select>
        </div>
      </div>
      <div class="row" :class="$style.from" v-show="timePeriod==='custom'">
        <div class="col">
          <label for="from-date">From:</label>
          <input type="date" name="from-date" id="from-date" v-model="fromDate">
        </div>
        <div class="col" :class="$style.toDate">
          <label for="to-date">To:</label>
          <input type="date" name="to-date" id="to-date" v-model="toDate">
        </div>
      </div>
    </div>
    <statistics-view :from="periodBalanceFromDate" :to="conditionalToDate"></statistics-view>
    <h3>Charts</h3>
    <div class="row" :class="$style['charts']">
      <period-balance-chart :period="period" :from="periodBalanceFromDate"
                            :to="conditionalToDate"></period-balance-chart>
      <category-sum-chart :from="periodBalanceFromDate" :to="conditionalToDate"></category-sum-chart>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import StatisticsView from "../components/StatisticsView.vue";
import CategorySumChart from "../components/charts/CategorySumChart.vue";
import PeriodBalanceChart from "../components/charts/PeriodBalanceChart.vue";
import {formDate, toDashDate} from "../helpers/DateHelpers";

export default defineComponent({
  name: 'StatisticsPage',
  components: {
    PeriodBalanceChart,
    CategorySumChart,
    StatisticsView,
  },
  data() {
    return {
      period: "day",
      timePeriod: "year",
      fromDate: formDate(),
      toDate: formDate(),
    }
  },
  computed: {
    periodBalanceFromDate(): string {
      let from = new Date()
      switch (this.timePeriod) {
        case "week":
          from.setDate(from.getDate() - 7)
          break;
        case "month":
          from.setMonth(from.getMonth() - 1)
          break;
        case "3month":
          from.setMonth(from.getMonth() - 3)
          break;
        case "year":
          from.setFullYear(from.getFullYear() - 1)
          break;
        case "5year":
          from.setFullYear(from.getFullYear() - 5)
          break;
        case "custom":
          return this.fromDate;
      }
      return toDashDate(from)
    },
    conditionalToDate(): string | null {
      return this.timePeriod === 'custom' ? this.toDate : null;
    },
  },
});
</script>

<style lang="scss" module>
@import '~styles/variables.scss';

.component {
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  h3 {
    margin: 1.2em 0 .2em 0;
  }

  label {
    font-size: small;
    font-weight: bold;
    margin-bottom: .2em;
  }

  select {
    margin: 0.4em 0;
  }

  .add-button {
    margin-bottom: 1em;
  }

  .charts {
    @include multi-margin;
  }

  .from, .toDate {
    margin-left: .5em;
  }

  select {
    justify-items: stretch;
  }
}
</style>