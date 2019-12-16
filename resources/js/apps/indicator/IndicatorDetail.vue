<template>
  <div>
    <span v-if="loading">Loading...</span>

    <div v-else class="row">
      <div class="col-md-8">
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

        <panel title="Complete / Incomplete">
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
        </panel>
      </div>
      <div class="col-md-4">
        <panel title="Chart">
          <date-picker v-model="timeRange" range></date-picker>
          <pie-chart :options="chartOptions" :chartdata="chartData"></pie-chart>
        </panel>
      </div>
    </div>

    <report-table v-if="!loading" :list="indicator.report" @requestUpdate="fetchData"></report-table>
  </div>
</template>

<script>
import moment from 'moment';
import DatePicker from 'vue2-datepicker';
import API from "../../interface";
import ReportTable from "../../components/ReportTable";
import Panel from "../../components/Panel";
import PieChart from "../../components/PieChart";

export default {
  name: "IndicatorDetail",

  data() {
    return {
      id: 0,
      loading: true,
      indicator: {},
      timeRange: [
        moment().startOf('month').toDate(),
        moment().endOf('month').toDate()
      ],
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
        const reportedAt = (new Date(l.reported_at + " 00:00:00")).getTime();
        const timePrev = this.timeRange[0].getTime();
        const timeNext = this.timeRange[1].getTime();

        return reportedAt <= timeNext && reportedAt >= timePrev;
      });
    },

    kels() {
      const kelurahan = [];
      this.filteredReport.forEach(report => {
        const { id, name } = report.patient.kelurahan;
        const kel = kelurahan.find(idn => idn.id === id);

        if (!kel) {
          kelurahan.push({ id, name, count: 1 });
          return;
        }

        kel.count += 1;
      });
      return kelurahan;
    },

    chartOptions() {
      return {
        responsive: true
      };
    },

    chartData() {
      return {
        labels: this.kels.map(kel => kel.name),
        datasets: [
          {
            data: this.kels.map(kel => kel.count),
            backgroundColor: [
              '#E91E63',
              '#9C27B0',
              '#2196F3',
              '#009688',
              '#CDDC39',
            ],
            label: 'Dataset'
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
    async fetchData() {
      const { data } = await API.indicators.detail(this.id);
      this.indicator = data.data;
      this.loading = false;
    },

    toPercentage(val) {
      return (val * 100).toFixed(0) + '%';
    },
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