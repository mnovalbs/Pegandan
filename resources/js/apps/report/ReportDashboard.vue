<template>
  <div>
    <date-picker v-model="timeRange" class="date-picker" range @change="fetchData"></date-picker>
    <panel title="Indicator">
      <bar-chart :width="800" :chartdata="barChartDataset" :options="barChartOptions"></bar-chart>
    </panel>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import moment from "moment";
import Panel from '../../components/Panel';
import ReportList from './ReportList';
import BarChart from '../../components/BarChart';
import API from "../../interface";

export default {
  name: 'ReportDashboard',

  data() {
    return {
      list: [],
      timeRange: [
        moment().startOf('month').toDate(),
        moment().endOf('month').toDate()
      ]
    };
  },

  components: {
    Panel,
    ReportList,
    BarChart,
    DatePicker
  },

  computed: {
    indicatorNames() {
      return this.list.map(l => l.name);
    },

    barChartDataset() {
      return {
        labels: this.indicatorNames,
        datasets: [
          {
            label: 'Complete',
            backgroundColor: '#009688',
            data: this.list.map(l => l.complete)
          },
          {
            label: 'Incomplete',
            backgroundColor: '#e91e63',
            data: this.list.map(l => l.incomplete)
          }
        ]
      }
    },

    barChartOptions() {
      return {
        responsive: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    }
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      const [ dateStart, dateEnd ] = this.timeRange;
      const { data } = await API.report.indicator(moment(dateStart).format("YYYY-MM-DD"), moment(dateEnd).format("YYYY-MM-DD"));
      this.list = data.data.map(d => ({
        name: d.name,
        complete: d.report.complete,
        incomplete: d.report.incomplete,
        percentage: d.report.percentage
      }));
    }
  }
}
</script>