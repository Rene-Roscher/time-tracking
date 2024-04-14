<script setup>
import {onMounted, onUnmounted, ref, toRefs} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import {usePage} from "@inertiajs/vue3";
import XClock from "@/Components/XClock.vue";
import TaskCreateModal from "@/Modals/TaskCreateModal.vue";
import TasksTable from "@/Tables/TasksTable.vue";

const page = usePage();

const createTaskModalOpened = ref(false);
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Tasks
        </h2>

        <button class="base-btn" @click="createTaskModalOpened = true">
          Create Task
        </button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="grid grid-cols-12">
          <x-clock/>
        </div>

        <div class="bg-white px-6 rounded-md border border-gray-200">
          <tasks-table :tasks="page.props.user.tasks"/>
        </div>

      </div>
    </div>

    <task-create-modal :show="createTaskModalOpened" :closeable="true" @close="createTaskModalOpened = false"/>
  </AppLayout>
</template>
