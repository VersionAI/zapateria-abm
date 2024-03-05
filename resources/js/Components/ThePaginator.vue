<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links : Array
})


</script>

<template>
    <div>
      <Component        
        v-for="link in links"
        v-bind:is="link.url  ? Link : 'span'"
        :href="link.url"
        v-html="link.label"
        class="px-1"
        :class="{ 'text-gray-500': ! link.url, 'font-bold' : link.active }"
      />
    </div>
  </template>
