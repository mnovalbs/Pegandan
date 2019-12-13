<template>
  <ul class='nav'>
    <li v-for="indicator in indicators" :key="indicator.id">
      <a :href="`/indicator/${indicator.id}`">{{ indicator.name }}</a>
    </li>
  </ul>
</template>

<script>
import API from '../../interface';
import { mapState } from 'vuex';

export default {
  name: "NavIndicator",

  mounted() {
    this.fetchData();
  },

  computed: {
    ...mapState({
      indicators: state => state.indicators
    })
  },

  methods: {
    async fetchData() {
      const { data } = await API.indicators.list();
      this.$store.commit('setIndicators', data.data);
    }
  }
};
</script>