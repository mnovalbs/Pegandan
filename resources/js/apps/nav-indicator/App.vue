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
    this.$store.dispatch('fetchIndicators');
  },

  computed: {
    ...mapState({
      indicators: state => state.indicators
    })
  },
};
</script>