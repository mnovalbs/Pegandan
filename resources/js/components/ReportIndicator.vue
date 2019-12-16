<template>
  <panel title="Indicator Reports">
    <div class="row">
      <div class="col-md-6">
        <date-picker v-model="timeRange" class="date-picker" range @change="datePickerChange"></date-picker>
      </div>
      <div class="col-md-6 text-right">
        <a href="#!" ref="link_download">
          <b-button class="btn btn-primary">Download</b-button>
        </a>
      </div>
    </div>

    <b-table-simple class="report-table" striped hover>
      <b-thead>
        <b-tr>
          <b-th rowspan="2">Indikator</b-th>
          <b-th colspan="2">Status</b-th>
          <b-th rowspan="2">Percentage</b-th>
        </b-tr>
        <b-tr>
          <b-th>Complete</b-th>
          <b-th>Incomplete</b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(d, i) in list" :key="i">
          <b-th>{{ d.name }}</b-th>
          <b-th>{{ d.complete }}</b-th>
          <b-th>{{ d.incomplete }}</b-th>
          <b-th>{{ toPercentage(d.percentage) }}</b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>
  </panel>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import moment from "moment";
import Panel from "./Panel";
import API from "../interface";

export default {
  name: "ReportIndicator",

  data() {
    return {
      list: [],
      timeRange: [
        moment().subtract(1, 'month').toDate(),
        moment().toDate()
      ]
    };
  },

  components: {
    Panel,
    DatePicker
  },

  computed: {
    fields() {
      return ["complete", "incomplete"];
    },

    csvList() {
      return this.list.map(l => [
        l.name,
        l.complete,
        l.incomplete,
        this.toPercentage(l.percentage)
      ])
    }
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    datePickerChange() {
      this.fetchData();
    },

    toPercentage(val) {
      return (val * 100).toFixed(0) + '%';
    },

    prepareCsvDownload() {
      const head = [[ 'Indikator', 'Complete', 'Incomplete', 'Percentage' ]];
      const rows = head.concat(this.csvList);

      const csvContent = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n");
      const encodedURI = encodeURI(csvContent);
      const link = this.$refs.link_download;

      link.setAttribute("href", encodedURI);
      link.setAttribute("download", `indicator_report-${moment().toDate().getTime()}.csv`);
    },

    async fetchData() {
      const [ dateStart, dateEnd ] = this.timeRange;
      const { data } = await API.report.indicator(moment(dateStart).format("YYYY-MM-DD"), moment(dateEnd).format("YYYY-MM-DD"));
      this.list = data.data.map(d => ({
        name: d.name,
        complete: d.report.complete,
        incomplete: d.report.incomplete,
        percentage: d.report.percentage
      }));
      this.prepareCsvDownload();
    }
  }
};
</script>

<style lang="scss" scoped>
.date-picker {
  margin-bottom: 8px;
}
</style>