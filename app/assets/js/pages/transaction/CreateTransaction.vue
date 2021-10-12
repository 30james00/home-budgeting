<template>
  <div :class="$style.component">
    <h2>Add transaction</h2>
    <transaction-from @changeData="handleDataChange" @done="handleSubmit" button="Add transaction"></transaction-from>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import TransactionFrom from "../../components/transaction/TransactionFrom.vue";
import {addTransaction} from "../../services/TransactionService";
import {useToast} from "vue-toastification";
import {ITransactionFormData} from "../../interfaces/ITransactionFormData";

export default defineComponent({
  name: 'CreateTransaction',
  components: {TransactionFrom},
  data() {
    return {
      formData: {} as ITransactionFormData
    }
  },
  methods: {
    handleDataChange(formData: ITransactionFormData) {
      this.formData = formData
    },
    async handleSubmit() {
      try {
          await addTransaction({
            name: this.formData.name,
            value: parseInt((parseFloat(this.formData.value) * 100).toString()),
            category: this.formData.category,
            currency: this.formData.currency,
            createDate: this.formData.date + " " + this.formData.time,
            description: this.formData.description
          })
      } catch (e) {
        console.log(e)
        useToast().error("Error adding Transaction")
        return;
      }
      useToast().success("Transaction added")
      await this.$router.push({name: 'ListTransaction'})
    }
  }
})
</script>

<style lang="scss" module>
@import '~styles/app.scss';

.component {
  display: flex;
  flex-direction: column;

  h2 {
    @include no-space;
  }

  .add-button {
    margin-right: .5em;
  }
}
</style>