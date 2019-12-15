<template>
  <b-form @submit.prevent="onSubmit">

    <b-form-group label="Name">
      <b-form-input
        v-model="patient.name"
        required
        placeholder="Patient name..."
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Kelurahan">
      <b-form-select
        v-model="patient.kelurahan_id"
        :options="kelurahanOptions">
      </b-form-select>
    </b-form-group>

    <b-form-group label="Birth Date">
      <b-form-input
        v-model="patient.birth_date"
        type="date"
        required
        placeholder="Birth date..."
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Sex">
      <b-form-select
        v-model="patient.sex"
        :options="sexOptions">
      </b-form-select>
    </b-form-group>

    <b-button class="btn btn-primary" type="submit" :disabled="loading">
      {{ loading ? 'Loading...' : 'Submit' }}
    </b-button>

  </b-form>
</template>

<script>
import API from '../interface';

export default {
  name: 'PatientForm',

  data() {
    return {
      patient: {},
      kelurahan: []
    }
  },

  computed: {
    sexOptions() {
      return [
        { value: 'MALE', text: 'Laki-laki' },
        { value: 'FEMALE', text: 'Perempuan' }
      ]
    },

    kelurahanOptions() {
      return this.kelurahan.map(kelurahan => ({
        value: kelurahan.id,
        text: kelurahan.name
      }))
    }
  },

  mounted() {
    this.fetchKelurahan();
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
        this.patient = form;
      }
    }
  },

  methods: {
    onSubmit() {
      this.$emit('submit', this.patient);
    },

    async fetchKelurahan() {
      const { data } = await API.kelurahan.list();
      this.kelurahan = data.data;
    }
  }
}
</script>