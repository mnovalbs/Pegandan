<template>
  <div>
    <span v-if="loading">Loading...</span>

    <div v-else>
      <div class="row">
        <div class="col-md-12">
          <panel title="Indicator Detail">
            <table class="table-user">
              <tbody>
                <tr>
                  <td>Name</td>
                  <td>:</td>
                  <td>{{ indicator.name }}</td>
                </tr>
              </tbody>
            </table>
          </panel>

          <!-- <panel title="Complete / Incomplete">
            <table class="table-user">
              <tbody>
                <tr>
                  <td>Complete</td>
                  <td>:</td>
                  <td>{{ completeLength }} ({{ toPercentage(completeLength ? (completeLength / (completeLength + incompleteLength)) : 0) }})</td>
                </tr>
                <tr>
                  <td>Incomplete</td>
                  <td>:</td>
                  <td>{{ incompleteLength }} ({{ toPercentage(incompleteLength ? (incompleteLength / (completeLength + incompleteLength)) : 0) }})</td>
                </tr>
              </tbody>
            </table>
          </panel>-->
        </div>
      </div>
    </div>

    <date-picker v-model="timeRange" range></date-picker>

    <div class="row">
      <div class="col-md-4">
        <panel title="Complete / Kelurahan">
          <pie-chart :options="chartOptions" :chartdata="completeData"></pie-chart>
        </panel>
      </div>
      <div class="col-md-4">
        <panel title="Incomplete / Kelurahan">
          <pie-chart :options="chartOptions" :chartdata="incompleteData"></pie-chart>
        </panel>
      </div>
      <div class="col-md-4">
        <panel title="Chart by Kelurahan">
          <pie-chart :options="chartOptions" :chartdata="chartData"></pie-chart>
        </panel>
      </div>
    </div>

    <report-table v-if="!loading" :list="indicator.report" @requestUpdate="fetchData"></report-table>
  </div>
</template>

<script>
import moment from "moment";
import DatePicker from "vue2-datepicker";
import API from "../../interface";
import ReportTable from "../../components/ReportTable";
import Panel from "../../components/Panel";
import PieChart from "../../components/PieChart";

const backgroundColor = ["#E91E63", "#9C27B0", "#2196F3", "#009688", "#CDDC39"];

export default {
  name: "IndicatorDetail",

  data() {
    return {
      id: 0,
      loading: true,
      indicator: {},
      timeRange: [
        moment()
          .startOf("month")
          .toDate(),
        moment()
          .endOf("month")
          .toDate()
      ]
    };
  },

  components: {
    Panel,
    ReportTable,
    PieChart,
    DatePicker
  },

  computed: {
    completeLength() {
      return this.indicator.report.filter(l => l.status).length;
    },

    incompleteLength() {
      return this.indicator.report.filter(l => !l.status).length;
    },

    filteredReport() {
      const indicator = this.indicator;
      return indicator.report.filter(l => {
        const reportedAt = new Date(l.reported_at + " 00:00:00").getTime();
        const timePrev = this.timeRange[0].getTime();
        const timeNext = this.timeRange[1].getTime();

        return reportedAt <= timeNext && reportedAt >= timePrev;
      });
    },

    kels() {
      const kelurahan = [];
      this.filteredReport.forEach(report => {
        const { status } = report;
        const { id, name } = report.patient.kelurahan;
        const kel = kelurahan.find(idn => idn.id === id);

        if (!kel) {
          kelurahan.push({
            id,
            name,
            count: 1,
            complete: status ? 1 : 0,
            incomplete: !status ? 1 : 0
          });
          return;
        }

        if (status) kel.complete += 1;
        if (!status) kel.incomplete += 1;
        kel.count += 1;
      });
      return kelurahan;
    },

    chartOptions() {
      return {
        responsive: true
      };
    },

    completeData() {
      return {
        labels: this.kels.map(kel => `${kel.name} (${this.completePercentage(kel)})`),
        datasets: [
          {
            backgroundColor,
            data: this.kels.map(kel => kel.complete),
            label: "Complete"
          }
        ]
      };
    },

    incompleteData() {
      return {
        labels: this.kels.map(kel => `${kel.name} (${this.incompletePercentage(kel)})`),
        datasets: [
          {
            backgroundColor,
            data: this.kels.map(kel => kel.incomplete),
            label: "Complete"
          }
        ]
      };
    },

    chartData() {
      return {
        labels: this.kels.map(kel => `${kel.name} (${this.allPercentage(kel)})`),
        datasets: [
          {
            backgroundColor,
            data: this.kels.map(kel => kel.count),
            label: "Dataset"
          }
        ]
      };
    }
  },

  mounted() {
    this.id = this.$route.params.id;
    this.fetchData();
  },

  methods: {
    allPercentage(kel) {
      const { count } = kel;
      const allCount = this.kels.reduce((sum, a) => a.count + sum, 0);

      return this.toPercentage(count ? count / allCount : 0);
    },

    completePercentage(kel) {
      const { complete } = kel;
      const allComplete = this.kels.reduce((sum, a) => a.complete + sum, 0);

      return this.toPercentage(complete ? complete / allComplete : 0);
    },

    incompletePercentage(kel) {
      const { incomplete } = kel;
      const allincomplete = this.kels.reduce((sum, a) => a.incomplete + sum, 0);

      return this.toPercentage(incomplete ? incomplete / allincomplete : 0);
    },

    async fetchData() {
      const { data } = await API.indicators.detail(this.id);
      this.indicator = data.data;
      this.loading = false;
    },

    toPercentage(val) {
      return (val * 100).toFixed(0) + "%";
    }
  }
};
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