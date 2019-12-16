<template>
  <div>
    <b-button
      class="btn btn-primary btn-create"
      @click="$bvModal.show('modal-create')"
    >Create new report</b-button>

    <report-table
      :list="list"
      :loading="loading"
      @requestUpdate="$emit('requestUpdate')"
    >
    </report-table>

    <b-modal id="modal-create" title="Create new Report" hide-footer>
      <report-form :form="dataAdd" :loading="submitLoading" :lockPatient="lockPatient" @submit="doCreate"></report-form>
    </b-modal>
  </div>
</template>

<script>
import ReportForm from "../../components/ReportForm";
import ReportTable from '../../components/ReportTable';
import API from "../../interface";

const defaultData = {
  patient_id: 0,
  indicator_id: 0,
  reported_at: '',
  steps_id: []
};

export default {
  name: "ReportList",

  data() {
    return {
      submitLoading: false,
      lockPatient: false,
      
      dataAdd: Object.assign(defaultData)
    };
  },

  props: {
    patientId: {
      type: Number,
      default: null
    },

    list: {
      type: Array,
      default: () => []
    },

    loading: {
      type: Boolean,
      default: false
    }
  },

  components: {
    ReportTable,
    ReportForm
  },

  mounted() {
    if (this.patientId) {
      this.dataAdd.patient_id = this.patientId;
      this.lockPatient = true;
    }
  },

  methods: {
    async doCreate() {
      try {
        this.submitLoading = true;
        await API.report.create(this.dataAdd);
        this.dataAdd = Object.assign(defaultData);
        this.$bvModal.hide("modal-create");
        this.$emit('requestUpdate');
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>