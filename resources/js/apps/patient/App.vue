<template>
  <panel title="Pasien">
    <span v-if="loading">Loading...</span>
    <b-table v-else striped hover :items="list" :fields="fields"></b-table>
  </panel>
</template>

<script>
import Panel from '../../components/Panel';
import API from '../../interface';

export default {
  name: 'PatientApp',

  data() {
    return {
      loading: true,
      list: []
    }
  },

  computed: {
    fields() {
      return ['id', 'name', 'birth_date', 'sex', 'age'];
    }
  },

  components: {
    Panel
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      try {
        const { data } = await API.patient.list();
        this.list = data.data;
      } catch (e) {
        alert('Error while fetching patient data');
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>