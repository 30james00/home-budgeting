<template>
  <div :class="$style.component">
    <h2>Edit transaction</h2>
    <transaction-from v-if="!isLoading" :data-seed="formData" @changeData="handleDataChange" @done="handleEdit"
                      button="Edit transaction"></transaction-from>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import TransactionFrom from "../../components/transaction/TransactionFrom.vue";
import {ITransactionFormData} from "../../interfaces/ITransactionFormData";
import {editTransaction, getTransaction} from "../../services/TransactionService";
import {useToast} from "vue-toastification";
import {ITransaction} from "../../interfaces/ITransaction";
import {AxiosResponse} from "axios";
import {formDate, formTime} from "../../helpers/DateHelpers";
import {ICategory} from "../../interfaces/ICategory";
import {ICurrency} from "../../interfaces/ICurrency";

export default defineComponent({
  name: 'EditTransaction',
  components: {TransactionFrom},
  data() {
    return {
      isLoading: true,
      transaction: {} as ITransaction,
      formData: {} as ITransactionFormData,
    }
  },
  async mounted() {
    let response: AxiosResponse
    this.isLoading = true;
    try {
      response = await getTransaction(this.$route.params.id.toString());
    } catch (e) {
      useToast().error("Can't get Transaction data")
      await this.$router.push('/');
      this.isLoading = false
      return;
    }
    this.transaction = response.data as ITransaction
    this.formData = {
      name: this.transaction.name,
      value: (this.transaction.value / 100).toString(),
      description: this.transaction.description,
      category: (this.transaction.category as ICategory)['@id'],
      currency: (this.transaction.currency as ICurrency)['@id'] ?? "",
      date: formDate(this.transaction.createDate),
      time: formTime(this.transaction.createDate),
    }
    this.isLoading = false
  },
  methods: {
    handleDataChange(formData: ITransactionFormData) {
      this.formData = formData
    },
    handleCancel() {
      this.$router.push('/')
    },
    async handleEdit() {
      try {
          await editTransaction({
            "@id": this.transaction["@id"],
            id: this.transaction.id,
            name: this.formData.name,
            value: parseInt((parseFloat(this.formData.value) * 100).toString()),
            category: this.formData.category,
            currency: this.formData.currency,
            createDate: this.formData.date + " " + this.formData.time,
            description: this.formData.description
          })
      } catch (e) {
        useToast().error("Error editing Transaction")
        await this.$router.push({name: 'ListTransaction'})
        return;
      }
      useToast().success("Transaction edited")
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

}
</style>