<script setup>
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {EllipsisVerticalIcon} from '@heroicons/vue/20/solid'
import {TaskStatusEnum} from "@/Constants/Enums.js";
import {getReadableValue} from "../Composables/EnumHelper.js";
import {intlDateTime} from "../Composables/Date.js";
import {router} from "@inertiajs/vue3";

defineProps({
  tasks: {
    type: Array,
    required: true,
  },
})

const statuses = {
  [TaskStatusEnum.COMPLETED]: 'text-green-700 bg-green-50 ring-green-600/20',
  [TaskStatusEnum.IN_PROGRESS]: 'text-gray-600 bg-gray-50 ring-gray-500/10',
  [TaskStatusEnum.CANCELLED]: 'text-red-800 bg-red-50 ring-red-600/20',
}

const deleteTask = (task) => {
  if (confirm('Are you sure you want to delete this task?')) {
    router.delete(route('task.delete', task), {
      preserveScroll: true,
    })
  }
}
</script>

<template>
  <ul role="list" class="divide-y divide-gray-100">
    <li v-for="task in tasks" :key="task.id" class="flex items-center justify-between gap-x-6 py-5">
      <div class="min-w-0">
        <div class="flex items-start gap-x-3">
          <p class="text-sm font-semibold leading-6 text-gray-900">{{ task.name }}</p>
          <p :class="[statuses[task.status], 'rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset']">{{ getReadableValue(TaskStatusEnum, task.status) }}</p>
        </div>
        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
          <p class="whitespace-nowrap" v-if="task.due_date">
            Due on {{ intlDateTime(task.due_date) }}
          </p>
          <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current" v-if="task.due_date && task.description">
            <circle cx="1" cy="1" r="1" />
          </svg>
          <p class="truncate">{{ task.description }}</p>
        </div>
      </div>
      <div class="flex flex-none items-center gap-x-4">
<!--        <a :href="task.href" class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block"-->
<!--        >View project<span class="sr-only">, {{ task.name }}</span></a-->
<!--        >-->
        <Menu as="div" class="relative flex-none">
          <MenuButton class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
            <span class="sr-only">Open options</span>
            <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
          </MenuButton>
          <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
              <MenuItem v-slot="{ active }">
                <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">
                  Edit
                </a>
              </MenuItem>
<!--              <MenuItem v-slot="{ active }">-->
<!--                <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">-->
<!--                  Move-->
<!--                </a>-->
<!--              </MenuItem>-->
              <MenuItem v-slot="{ active }">
                <a @click="deleteTask(task)" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">
                  Delete
                </a>
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </li>
  </ul>
</template>
