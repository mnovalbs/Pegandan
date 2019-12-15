<template>
  <div>
    <b-button class="btn btn-primary btn-create" @click="$bvModal.show('modal-create')">Create new patient</b-button>

    <patient-table
      :list="list"
      :loading="loading"
      @requestUpdate="fetchData"
    ></patient-table>

    <b-modal id="modal-create" title="Create new Patient" hide-footer>
      <patient-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></patient-form>
    </b-modal>
  </div>
</template>

<script>
import PatientForm from '../../components/PatientForm';
import PatientTable from '../../components/PatientTable';
import Panel from "../../components/Panel";
import API from "../../interface";

const defaultData = {
  name: '',
  birth_date: '',
  sex: 'MALE',
  kelurahan_id: null
}

export default {
  name: "PatientList",

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
      return ["id", "name", "birth_date", "sex", "age", "kelurahan", "action"];
    }
  },

  components: {
    PatientTable,
    PatientForm,
    Panel
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async doCreate() {
      try {
        this.submitLoading = true;
        await API.patient.create(this.dataAdd);
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
      try {
        this.loading = true;
        const { data } = await API.patient.list();
        this.list = data.data;
      } catch (e) {
        alert("Error while fetching patient data");
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