<template>
  <b-form @submit.prevent="onSubmit">

    <b-form-group label="Kelurahan Name">
      <b-form-input
        v-model="kelurahan.name"
        required
        placeholder="Kelurahan name..."
      ></b-form-input>
    </b-form-group>

    <b-button class="btn btn-primary" type="submit" :disabled="loading">
      {{ loading ? 'Loading...' : 'Submit' }}
    </b-button>

  </b-form>
</template>

<script>
export default {
  name: 'KelurahanForm',

  data() {
    return {
      kelurahan: {}
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
        this.kelurahan = form;
      }
    }
  },

  methods: {
    onSubmit() {
      this.$emit('submit', this.kelurahan);
    }
  }
}
</script>