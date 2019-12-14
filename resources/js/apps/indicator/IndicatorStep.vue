<template>
  <div>
    <b-button class="btn btn-primary btn-create" @click="$bvModal.show('modal-create')">Create new Step</b-button>

    <panel :title="`Indicator Step [${indicatorName}]`">
      <b-table striped hover :items="list" :fields="fields">
        <template v-slot:cell(action)="row">
          <div>
            <b-button size="sm" @click="edit(row)">Edit</b-button>
            <b-button size="sm" @click="requestDelete(row)" class="btn btn-danger">Delete</b-button>
          </div>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Indicator Step" hide-footer>
      <indicator-step-form :form="dataEdit" :loading="submitLoading" @submit="doEdit"></indicator-step-form>
    </b-modal>

    <b-modal id="modal-create" title="Create new Step" hide-footer>
      <indicator-step-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></indicator-step-form>
    </b-modal>
  </div>
</template>

<script>
import API from '../../interface';
import Panel from "../../components/Panel";
import IndicatorStepForm from './IndicatorStepForm';

const defaultData = {
  label: '',
}

export default {
  name: "IndicatorStep",

  data() {
    return {
      submitLoading: false,
      loading: true,

      list: [],
      indicatorId: 0,
      indicatorName: '',

      dataEdit: {},
      dataAdd: Object.assign(defaultData)
    }
  },

  components: {
    Panel,
    IndicatorStepForm
  },

  computed: {
    fields() {
      return ["id", "label", "action"];
    }
  },

  mounted() {
    this.indicatorId = parseInt(this.$route.params.id);
    this.fetchData();
  },

  methods: {
    async requestDelete(row) {
      const { label, id } = row.item;
      const conf = confirm(`Delete step ${label}?`);
      if (!conf) return;
      try {
        await API.indicators.step.delete(id);
        this.fetchData();
      } catch (e) {
        alert(`Tidak berhasil menghapus step ${label}`);
      }
    },

    edit(row) {
      const { id } = row.item;
      const data = this.list.find(l => l.id === id);

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show('modal-edit');
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.indicators.step.update(this.dataEdit.id, this.dataEdit);
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
        await API.indicators.step.create({
          ...this.dataAdd,
          indicator_id: this.indicatorId
        });
        this.dataAdd = Object.assign(defaultData);
        this.$bvModal.hide('modal-create');
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    async fetchData() {
      const { data } = await API.indicators.step.list(this.indicatorId);
      this.list = data.data.steps;
      this.indicatorName = data.data.name;
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>