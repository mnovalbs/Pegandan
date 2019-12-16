import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,

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
        this.renderBar();
      }
    }
  },

  mounted () {
    this.renderBar();
  },

  methods: {
    renderBar() {
      this.renderChart(this.chartdata, this.options)
    }
  }
}