<template>
  <div>
    <report-indicator></report-indicator>

    <b-button
      class="btn btn-primary btn-create"
      @click="$bvModal.show('modal-create')"
    >Create new report</b-button>

    <report-table
      :list="list"
      :loading="loading"
      @requestUpdate="fetchData"
    >
    </report-table>

    <b-modal id="modal-create" title="Create new Report" hide-footer>
      <report-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></report-form>
    </b-modal>
  </div>
</template>

<script>
import ReportForm from "../../components/ReportForm";
import ReportTable from '../../components/ReportTable';
import ReportIndicator from '../../components/ReportIndicator';
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
      
      dataAdd: Object.assign(defaultData)
    };
  },

  components: {
    ReportIndicator,
    ReportTable,
    ReportForm
  },

  mounted() {
    this.fetchData();
  },

  methods: {
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