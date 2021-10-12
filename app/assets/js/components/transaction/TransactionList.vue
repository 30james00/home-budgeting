<template>
  <div :class="$style.component">
    <p v-show="loading">Loading...</p>
    <p v-show="!loading && transactions.length === 0"></p>
    <transaction-item v-for="transaction in transactions" :transaction="transaction"
                      :key="transaction['@id']" @refresh="refresh(filters)"></transaction-item>
  </div>
</template>

<script lang="ts">

import {defineComponent, PropType} from "vue";
import TransactionItem from "../../components/transaction/TransactionItem.vue";
import {ITransaction} from "../../interfaces/ITransaction";
import {fetchTransactions} from "../../services/TransactionService";
import {ITransactionFilter} from "../../interfaces/ITransactionFilter";

export default defineComponent({
  name: 'TransactionList',
  components: {
    TransactionItem
  },
  props: {
    filters: {
      type: Object as PropType<ITransactionFilter>,
      required: true,
    }
  },
  data() {
    return {
      loading: true,
      transactions: new Array<ITransaction>(),
    }
  },
  created() {
    this.refresh(this.filters)
  },
  methods: {
    refresh(filters: ITransactionFilter) {
      this.loading = true;
      fetchTransactions(filters).then(transactions => {
        if (transactions) this.transactions = transactions
        this.loading = false;
      });
    }
  },
  watch: {
    filters: {
      handler(newFilters) {
        this.refresh(newFilters)
      },
      deep: true,
    },
  },
});
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  @include col;
  justify-content: center;
}
</style>