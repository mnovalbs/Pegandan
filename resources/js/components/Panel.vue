<template>
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">{{ title }}</h3>
    </div>
    <div class="panel-body">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Panel',

  props: {
    title: {
      type: String,
      required: true
    }
  }
}
</script>