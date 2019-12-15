<template>
  <div>
    <span v-if="loading">Loading...</span>

    <panel v-if="!loading" title="Indicator Detail">
      <table class='table-user'>
        <tbody> 
          <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ indicator.name }}</td>
          </tr>
        </tbody>
      </table>
    </panel>

    <report-table
      v-if="!loading"
      :list="indicator.report"
      @requestUpdate="fetchData"
    >
    </report-table>

  </div>
</template>

<script>
import API from '../../interface';
import ReportTable from '../../components/ReportTable';
import Panel from '../../components/Panel';

export default {
  name: 'IndicatorDetail',

  data() {
    return {
      id: 0,
      loading: true,
      indicator: {}
    }
  },

  components: {
    Panel,
    ReportTable
  },

  mounted() {
    this.id = this.$route.params.id;
    this.fetchData();
  },

  methods: {
    async fetchData() {
      const { data } = await API.indicators.detail(this.id);
      this.indicator = data.data;
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