<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const time = ref(new Date().toLocaleTimeString());

const updateTime = () => time.value = new Date().toLocaleTimeString();

let intervalId;
onMounted(() => intervalId = setInterval(updateTime, 1000));

onUnmounted(() => clearInterval(intervalId));
</script>

<template>
  <div class="items-center justify-center col-span-3 bg-white rounded-md p-4 tabular-nums border border-gray-200 space-y-4">
    <div class="flex items-center justify-between">
      <div class="text-4xl font-semibold text-gray-800">
        {{ time }}
      </div>
      <button class="base-btn">Track</button>
    </div>
  </div>
</template>
