<template>
    <div :class="defaultClass" v-bind="$attrs">
      <slot></slot>
    </div>
  </template>
  
  <script>
  export default {
    name: "Container",
    props: {
      class: {
        type: String,
        default: "mx-auto max-w-7xl px-6"
      }
    },
    computed: {
      defaultClass() {
        return this.class;
      }
    }
  };
</script>
  