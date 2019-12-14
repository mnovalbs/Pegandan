<template>
  <b-form @submit.prevent="onSubmit">

    <b-form-group label="Label">
      <b-form-input
        v-model="step.label"
        required
        placeholder="Step label..."
      ></b-form-input>
    </b-form-group>

    <b-button class="btn btn-primary" type="submit" :disabled="loading">
      {{ loading ? 'Loading...' : 'Submit' }}
    </b-button>

  </b-form>
</template>

<script>
export default {
  name: 'IndicatorStepForm',

  data() {
    return {
      step: {}
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
    }
  },

  watch: {
    form: {
      immediate: true,
      deep: true,
      handler: function(form) {
        this.step = form;
      }
    }
  },

  methods: {
    onSubmit() {
      this.$emit('submit', this.step);
    }
  }
}
</script>