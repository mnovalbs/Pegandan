import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,

  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: null
    }
  },

  watch: {
    chartdata: {
      immediate: true,
      deep: true,
      handler: function() {
        this.renderPie();
      }
    }
  },

  mounted () {
    this.renderPie();
  },

  methods: {
    renderPie() {
      this.renderChart(this.chartdata, this.options)
    }
  }
}