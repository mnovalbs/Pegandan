<template>
  <b-form @submit.prevent="onSubmit">
    <b-form-group label="Date">
      <b-form-input
        v-model="report.reported_at"
        :disabled="isEdit"
        type="date"
        required
        placeholder="Reported date..."
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Patient">
      <b-form-select v-model="report.patient_id" :disabled="isEdit" :options="patientOptions"></b-form-select>
    </b-form-group>

    <b-form-group label="Indicator">
      <b-form-select v-model="report.indicator_id" :disabled="isEdit" :options="indicatorOptions"></b-form-select>
    </b-form-group>

    <div v-if="indicatorSteps">
      <b-form-group label="Indicator Step">
        <b-form-checkbox
          class="form-checkbox"
          v-for="step in indicatorSteps"
          :key="step.value"
          :checked="stepChecked(step.value)"
          @change="value => stepChange(value, step.value)"
        >{{ step.text }}</b-form-checkbox>
      </b-form-group>
    </div>

    <b-button
      class="btn btn-primary"
      type="submit"
      :disabled="loading"
    >{{ loading ? 'Loading...' : 'Submit' }}</b-button>
  </b-form>
</template>

<script>
import API from "../../interface";

export default {
  name: "ReportForm",

  data() {
    return {
      apiLoading: true,
      report: {},

      patientList: [],
      indicatorList: []
    };
  },

  computed: {
    patientOptions() {
      return this.patientList.map(patient => ({
        value: patient.id,
        text: patient.name
      }));
    },

    indicatorOptions() {
      return this.indicatorList.map(indicator => ({
        value: indicator.id,
        text: indicator.name
      }));
    },

    indicatorSteps() {
      const indicator = this.indicatorList.find(
        indi => indi.id === this.report.indicator_id
      );
      if (!indicator) return [];
      return indicator.steps.map(step => ({
        value: step.id,
        text: step.label
      }));
    }
  },

  props: {
    form: {
      type: Object,
      default: () => ({})
    },

    loading: {
      type: Boolean,
      default: false
    },

    isEdit: {
      type: Boolean,
      default: false
    }
  },

  watch: {
    form: {
      immediate: true,
      deep: true,
      handler: function(form) {
        this.report = form;
      }
    }
  },

  async mounted() {
    this.fetchPatient();
    this.fetchIndicator();
  },

  methods: {
    onSubmit() {
      this.$emit("submit", this.report);
    },

    stepChecked(step_id) {
      return this.report.steps_id.includes(step_id);
    },

    stepChange(val, step_id) {
      if (val) {
        this.report.steps_id.push(step_id);
        return;
      }

      this.report.steps_id = this.report.steps_id.filter(id => id !== step_id);
    },

    async fetchPatient() {
      const { data } = await API.patient.list();
      this.patientList = data.data;
    },

    async fetchIndicator() {
      const { data } = await API.indicators.list();
      this.indicatorList = data.data;
    }
  }
};
</script>