<template>
  <div>
    <b-button
      class="btn btn-primary btn-create"
      @click="$bvModal.show('modal-create')"
    >Create new report</b-button>

    <panel title="Report">
      <span v-if="loading">Loading...</span>
      <b-table v-else striped hover :items="list" :fields="fields">
        <template v-slot:cell(patient)="row">
          {{ row.item.patient.name }}
        </template>

        <template v-slot:cell(indicator)="row">
          {{ row.item.indicator.name }}
        </template>

        <template v-slot:cell(date)="row">
          {{ row.item.reported_at }}
        </template>

        <template v-slot:cell(status)="row">
          <div>
            <b-badge v-if="row.item.status" variant="success" class="bg-success">Complete</b-badge>
            <b-badge v-else variant="warning" class="bg-warning">Incomplete</b-badge>
          </div>
        </template>

        <template v-slot:cell(steps)="row">
          {{ row.item.steps.filter(step => step.status).length }} / {{ row.item.steps.length }}
        </template>

        <template v-slot:cell(action)="row">
          <div>
            <b-button @click="edit(row)">Edit</b-button>
            <b-button size="sm" @click="requestDelete(row)" class="btn btn-danger">Delete</b-button>
          </div>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Report" hide-footer>
      <report-form :form="dataEdit" isEdit :loading="submitLoading" @submit="doEdit"></report-form>
    </b-modal>

    <b-modal id="modal-create" title="Create new Report" hide-footer>
      <report-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></report-form>
    </b-modal>
  </div>
</template>

<script>
import ReportForm from "./ReportForm";
import Panel from "../../components/Panel";
import API from "../../interface";

const defaultData = {
  patient_id: 0,
  indicator_id: 0,
  reported_at: '',
  steps_id: []
};

export default {
  name: "ReportApp",

  data() {
    return {
      submitLoading: false,
      loading: true,
      list: [],

      dataEdit: {},
      dataAdd: Object.assign(defaultData)
    };
  },

  computed: {
    fields() {
      return ["id", "patient", "indicator", "date", "status", "steps", "action"];
    }
  },

  components: {
    ReportForm,
    Panel
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    edit(row) {
      const { item } = row;
      const data = {
        id: item.id,
        patient_id: item.patient_id,
        indicator_id: item.indicator_id,
        reported_at: item.reported_at,
        steps_id: item.steps.filter(step => step.status).map(step => step.indicator_step_id)
      }

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show("modal-edit");
    },

    async requestDelete(row) {
      const { id } = row.item;
      const conf = confirm(`Delete report?`);
      if (!conf) return;
      try {
        await API.report.delete(id);
        this.fetchData();
      } catch (e) {
        alert(`Tidak berhasil menghapus indicator`);
      }
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.report.update(this.dataEdit.id, this.dataEdit);
        this.$bvModal.hide("modal-edit");
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
        await API.report.create(this.dataAdd);
        this.dataAdd = Object.assign(defaultData);
        this.$bvModal.hide("modal-create");
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    async fetchData() {
      try {
        this.loading = true;
        const { data } = await API.report.list();
        this.list = data.data;
      } catch (e) {
        alert("Error while fetching report data");
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>