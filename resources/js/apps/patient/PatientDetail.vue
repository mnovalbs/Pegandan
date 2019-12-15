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

    <panel v-if="!loading" title="History">
      <b-table striped hover :items="patient.history" :fields="fields">

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
      </b-table>
    </panel>

  </div>
</template>

<script>
import Panel from "../../components/Panel";
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

  computed: {
    fields() {
      return ["id", "indicator", "date", "status", "steps"];
    }
  },

  components: {
    Panel
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