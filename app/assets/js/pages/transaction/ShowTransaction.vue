<template>
  <div :class="$style.component">
    <h2>Your transactions</h2>
    <div :class="$style.filters">
      <div :class="$style['filters-row']">
        <div class="col">
          <label for="order">Order by:</label>
          <select name="order" id="order" v-model="filter.order">
            <option value="dateDesc">Date descending</option>
            <option value="dateAsc">Date ascending</option>
            <option value="valueDesc">Value descending</option>
            <option value="valueAsc">Value ascending</option>
          </select>
        </div>
        <div class="col">
          <label for="min-value">Min. value:</label>
          <input name="min-value" id="min-value" v-model="filter.minValue">
        </div>
        <div class="col">
          <label for="order">Max. value:</label>
          <input name="max-value" id="max-value" v-model="filter.maxValue">
        </div>
        <div class="col">
          <label for="time-period">Time period:</label>
          <select name="time-period" id="time-period" v-model="filter.dateRange">
            <option value="all">All</option>
            <option value="week">Last 7 days</option>
            <option value="month">Last 30 days</option>
            <option value="3month">Last 90 days</option>
            <option value="year">Last year</option>
            <option value="5year">Last 5 years</option>
            <option value="custom">Custom</option>
          </select>
        </div>
      </div>
      <div :class="$style['filters-row']" v-show="filter.dateRange==='custom'">
        <div class="col">
          <label for="from-date">From:</label>
          <input type="date" name="from-date" id="from-date" v-model="filter.fromDate">
        </div>
        <div class="col" :class="$style.toDate">
          <label for="to-date">To:</label>
          <input type="date" name="to-date" id="to-date" v-model="filter.toDate">
        </div>
      </div>
    </div>
    <transaction-list :filters="filter"></transaction-list>
  </div>
</template>

<script lang="ts">

import {defineComponent} from "vue";
import TransactionList from "../../components/transaction/TransactionList.vue";

export default defineComponent({
  name: 'ShowTransaction',
  components: {TransactionList},
  data() {
    return {
      filter: {
        order: "dateDesc",
        dateRange: "all",
        fromDate: "",
        toDate: "",
        minValue: "",
        maxValue: "",
      }
    }
  },
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  label {
    font-size: small;
    font-weight: bold;
    margin-bottom: .2em;
  }

  .filters {
    @include col;
    margin: .5em 0;
  }
  .filters-row {
    @include row;
    @include multi-margin;
  }
}
</style>