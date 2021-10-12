<template>
  <Form v-if="!loading" @submit="handleSubmit" :class="$style.component" @change="handleChange"
        :validation-schema="schema">
    <label for="name">Name</label>
    <Field name="name" type="text" id="name" v-model="formData.name"></Field>
    <ErrorMessage class="error" name="name"></ErrorMessage>
    <div class="col">
      <label for="value">Value</label>
      <div class="row">
        <Field name="value" type="number" id="value" v-model="formData.value"></Field>
        <ErrorMessage class="error" name="value"></ErrorMessage>
        <Field :class="$style['currency-select']" as="select" name="currency" id="currency" v-model="formData.currency">
          <option v-for="currency in currencies" :key="currency['@id']" :value="currency['@id']">{{
              currency.acronym
            }}
          </option>
        </Field>
        <ErrorMessage class="error" name="currency"></ErrorMessage>
      </div>
    </div>
    <div class="col">
      <label for="category">Category</label>
      <div class="row">
        <Field as="select" name="category" id="category" v-model="formData.category">
          <option v-for="category in categories" :key="category['@id']" :value="category['@id']">{{ category.name }}
          </option>
        </Field>
        <div>
          <custom-button @click="showCategoryForm = true" :class="$style['add-category']"
                         text="Add category"></custom-button>
          <modal v-show="showCategoryForm" @close="addCategoryForm" @cancel="cancelCategoryForm">
            <template v-slot:header>
              <h2>Add new category</h2>
            </template>
            <template v-slot:body>
              <form action="">
                <div class="col">
                  <label for="category-name">Category Name</label>
                  <input v-model="categoryName" type="text" name="category-name" id="category-name">
                  <label for="category-color">Color</label>
                  <input v-model="categoryColor" type="color" name="category-color" id="category-color">
                </div>
              </form>
            </template>
          </modal>
        </div>
      </div>
      <ErrorMessage class="error" name="category"></ErrorMessage>
    </div>
    <div class="row">
      <div class="col">
        <label for="date">Date</label>
        <Field name="date" type="date" id='date' v-model="formData.date"></Field>
        <ErrorMessage class="error" name="date"></ErrorMessage>
      </div>
      <div class="col" :class="$style.time">
        <label for="time">Time</label>
        <Field name="time" type="time" id="time" v-model="formData.time"></Field>
        <ErrorMessage class="error" name="date"></ErrorMessage>
      </div>
    </div>
    <div class="col">
      <label for="description">Description</label>
      <Field name="description" type="text" id="description" v-model="formData.description"></Field>
    </div>
    <div class="row" :class="$style.buttons">
      <custom-button @click="handleSubmit" :text="button" bg="green"></custom-button>
      <custom-button :class="$style.cancel" text="Cancel" bg="red" @click="handleCancel"></custom-button>
    </div>
  </Form>
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import CustomButton from "../common/CustomButton.vue";
import {ITransactionFormData} from "../../interfaces/ITransactionFormData";
import {ErrorMessage, Field, Form} from "vee-validate";
import {date, number, object, string} from 'yup';
import {formDate, formTime} from "../../helpers/DateHelpers";
import {ICurrency} from "../../interfaces/ICurrency";
import {ICategory} from "../../interfaces/ICategory";
import {fetchCurrencies} from "../../services/CurrencyService";
import {addCategory, fetchCategories} from "../../services/CategoryService";
import Modal from "../common/Modal.vue";
import {fetchUsers} from "../../services/UserService";
import {useToast} from "vue-toastification";

export default defineComponent({
  name: "TransactionFrom",
  components:
      {
        Modal,
        CustomButton,
        Field,
        Form,
        ErrorMessage
      },
  props: {
    dataSeed: {
      type: Object as PropType<ITransactionFormData>,
      required: false,
    },
    button: {
      type: String,
      required: true,
    }
  },
  data() {
    const schema = object({
      name: string().required().label('Name'),
      value: number().required().label('Value'),
      currency: string().required().label('Currency'),
      category: string().required().label('Category'),
      date: date().required().label('Date'),
      time: date().required().label('Time'),
    })

    return {
      formData: {} as ITransactionFormData,
      currencies: [] as Array<ICurrency>,
      categories: [] as Array<ICategory>,
      loading: false,
      showCategoryForm: false,
      categoryName: "",
      categoryColor: "#ff0000",
      schema,
    }
  },
  async created() {
    this.loading = true;
    let currencies = await fetchCurrencies()
    if (currencies) {
      this.currencies = currencies
    }

    await this.fetchCategories()

    if (this.dataSeed)
      this.formData = {
        name: this.dataSeed.name,
        value: this.dataSeed.value,
        category: this.dataSeed.category,
        currency: this.dataSeed.currency,
        date: this.dataSeed.date,
        time: this.dataSeed.time,
        description: "",
      }
    else {
      this.formData = {
        name: "",
        value: "0",
        category: "Food",
        currency: "PLN",
        date: formDate(),
        time: formTime(),
        description: "",
      }
    }
    this.loading = false;
  },
  methods: {
    handleChange() {
      this.$emit('changeData', this.formData);
    },
    handleSubmit() {
      this.$emit('done')
    },
    handleCancel() {
      this.$router.push('/')
    },
    async addCategoryForm() {
      try {
        let user = await fetchUsers();
        if (user)
          await addCategory({
            name: this.categoryName,
            color: this.categoryColor,
          })
      } catch (e) {
        useToast().error("Error adding Category")
        return;
      }
      useToast().success("Category added")
      await this.fetchCategories();
      this.showCategoryForm = false
    },
    cancelCategoryForm() {
      this.showCategoryForm = false
    },
    async fetchCategories() {
      let categories = await fetchCategories()
      if (categories) {
        this.categories = categories
      }
    }
  },
})
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  display: flex;
  margin: 1em 0;
  flex-direction: column;
  align-items: stretch;
  max-width: 450px;

  input {
    margin: 0.4em 0;
  }

  .buttons {
    margin-top: .8em;
  }

  .add-category, .cancel, .time {
    margin-left: .5em;
  }

  .currency-select {
    margin-left: .5em;
  }
}
</style>