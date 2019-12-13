<template>
  <b-form @submit.prevent="onSubmit">

    <b-form-group label="Name">
      <b-form-input
        v-model="indicator.name"
        required
        placeholder="Indicator name..."
      ></b-form-input>
    </b-form-group>

    <b-button class="btn btn-primary" type="submit" :disabled="loading">
      {{ loading ? 'Loading...' : 'Submit' }}
    </b-button>

  </b-form>
</template>

<script>
export default {
  name: 'IndicatorForm',

  data() {
    return {
      indicator: {}
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
        this.indicator = form;
      }
    }
  },

  methods: {
    onSubmit() {
      this.$emit('submit', this.indicator);
    }
  }
}
</script>