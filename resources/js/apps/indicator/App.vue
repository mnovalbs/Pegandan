<template>
  <div>
    <b-button class="btn btn-primary btn-create" @click="$bvModal.show('modal-create')">Create new Indicator</b-button>

    <panel title="Indicator">
      <b-table striped hover :items="list" :fields="fields">
        <template v-slot:cell(action)="row">
          <b-button size="sm" @click="edit(row)">Edit</b-button>
        </template>

        <template v-slot:cell(step)="row">
          <a :href="`/indicator/${row.item.id}/steps`">{{ row.item.steps.length }} step</a>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Indicator" hide-footer>
      <indicator-form :form="dataEdit" :loading="submitLoading" @submit="doEdit"></indicator-form>
    </b-modal>

    <b-modal id="modal-create" title="Create new Indicator" hide-footer>
      <indicator-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></indicator-form>
    </b-modal>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import IndicatorForm from './IndicatorForm';
import Panel from "../../components/Panel";
import API from "../../interface";

const defaultData = {
  name: '',
}

export default {
  name: "IndicatorApp",

  data() {
    return {
      submitLoading: false,
      loading: true,

      dataEdit: {},
      dataAdd: Object.assign(defaultData)
    };
  },

  computed: {
    ...mapState({
      list: state => state.indicators
    }),

    fields() {
      return ["id", "name", "step", "action"];
    }
  },

  components: {
    IndicatorForm,
    Panel
  },

  methods: {
    edit(row) {
      const { id } = row.item;
      const data = this.list.find(patient => patient.id === id);

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show('modal-edit');
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.indicators.update(this.dataEdit.id, this.dataEdit);
        this.$bvModal.hide('modal-edit');
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    async doCreate() {
      try {
        this.submitLoading = true;
        await API.indicators.create(this.dataAdd);
        this.dataAdd = Object.assign(defaultData);
        this.$bvModal.hide('modal-create');
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    fetchData() {
      this.$store.dispatch('fetchIndicators');
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>