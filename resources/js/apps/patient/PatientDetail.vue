<template>
  <div>
    <span v-if="loading">Loading...</span>

    <panel v-if="!loading" title="Patient Detail">
      <table class='table-user'>
        <tbody> 
          <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ patient.name }}</td>
          </tr>
          <tr>
            <td>Birth Date</td>
            <td>:</td>
            <td>{{ patient.birth_date }}</td>
          </tr>
          <tr>
            <td>Sex</td>
            <td>:</td>
            <td>{{ patient.sex }}</td>
          </tr>
        </tbody>
      </table>
    </panel>

    <report-list
      v-if="!loading"
      :list="patient.history"
      :patientId="patient.id"
      @requestUpdate="fetchData"
    >
    </report-list>

  </div>
</template>

<script>
import Panel from "../../components/Panel";
import ReportList from '../report/ReportList';
import API from "../../interface";

export default {
  name: 'PatientDetail',

  data() {
    return {
      loading: true,
      id: 0,
      patient: {},
    }
  },

  components: {
    Panel,
    ReportList
  },

  mounted() {
    this.id = this.$route.params.id;
    this.fetchData();
  },

  methods: {
    async fetchData() {
      const { data } = await API.patient.detail(this.id);
      this.patient = data.data;
      this.loading = false;
    }
  }
}
</script>

<style lang="scss" scoped>
.table-user {
  width: 100%;

  td:first-child {
    width: 100px;
  }
  td:nth-child(2) {
    width: 10px;
  }
}
</style>