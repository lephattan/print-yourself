<template>
  <span v-html="setting.currency_symbol||''"></span>
  
</template>

<script>
export default {
  inject: ['setting'],
}
</script>

<style>

</style>
