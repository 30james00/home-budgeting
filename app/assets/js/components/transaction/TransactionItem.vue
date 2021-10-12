<template>
  <div :class="$style.component">
    <div :class="$style['name-row']">
      <div :class="$style.name">{{ transaction.name }}</div>
      <tag :title="transaction.category.name" :bg="transaction.category.color"></tag>
    </div>
    <div v-if="transaction.description" :class="$style.description">{{ transaction.description }}</div>
    <div :class="$style.value" :style="{'color': transaction.value > 0 ? 'green': 'red'}">
      {{ normalizeFloat(transaction.value) + " " + transaction.currency.acronym }}
    </div>
    <div class="row" :class="$style.info">
      <div :class="$style.user">{{ transaction.madeBy.firstname + " " + transaction.madeBy.lastname }}</div>
      <div> {{
          new Date(transaction.createDate).toLocaleString('pl-PL')
        }}
      </div>
    </div>
    <div v-if="transaction.madeBy['@id'] === store.state.user['@id']" class="row" :class="$style.buttons">
      <custom-button :class="$style['edit-button']" text="Edit" @click="handleEdit"></custom-button>
      <custom-button text="Delete" bg="red" @click="handleDelete"></custom-button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import {ITransaction} from "../../interfaces/ITransaction";
import Tag from "../common/Tag.vue";
import CustomButton from "../common/CustomButton.vue";
import {deleteTransaction} from "../../services/TransactionService";
import {useToast} from "vue-toastification";
import {normalizeFloat} from "../../helpers/NumberHelpers";
import {useStore} from "../../store";

export default defineComponent({
  name: "TransactionItem",
  components: {CustomButton, Tag},
  props: {
    transaction: {type: Object as PropType<ITransaction>, required: true}
  },
  data() {
    return {
      store: useStore(),
    }
  },
  methods: {
    handleEdit() {
      this.$router.push(`/transaction/edit/${this.transaction.id}`)
    },
    normalizeFloat(val: number) {
      return normalizeFloat(val)
    },
    async handleDelete() {
      if (this.transaction["@id"])
        try {
          await deleteTransaction(this.transaction["@id"]);
        } catch (e) {
          useToast().error("Error deleting Transaction")
          return
        }
      this.$emit('refresh')
    }
  }
})
</script>

<style lang="scss" module>
@import "~styles/variables.scss";

.component {
  align-items: flex-start;
  background-color: white;
  border-radius: 1em;
  display: flex;
  flex-direction: column;
  margin: .5em 0;
  padding: 1em 1.5em;

  .name-row {
    @include row;
    @include multi-margin;

    align-items: center;

    .name {
      font-size: large;
      font-weight: bold;
    }
  }

  .description {
    color: darkslategray;
    margin: .3em 0;
  }

  .value {
    margin: .4em 0;
    font-weight: bold;
    font-size: large;
  }

  .info {
    margin: .3em 0;
    color: darkslategray;

    .user {
      margin-right: 1em;
    }
  }

  .buttons {
    margin-top: .6em;

    .edit-button {
      margin-right: .5em;
    }
  }

}


</style>