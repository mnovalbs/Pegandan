<template>
  <div>
    <report-indicator></report-indicator>

    <report-list :loading="loading" :list="list" @requestUpdate="fetchData"></report-list>
  </div>
</template>

<script>
import ReportIndicator from '../../components/ReportIndicator';
import ReportList from './ReportList';
import API from "../../interface";

export default {
  name: "ReportApp",

  data() {
    return {
      loading: true,
      list: [],
    };
  },

  components: {
    ReportList,
    ReportIndicator,
  },

  mounted() {
    this.fetchData();
  },

  methods: {
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