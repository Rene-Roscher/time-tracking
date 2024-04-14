<script setup>
import DialogModal from "@/Components/DialogModal.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {TaskStatusEnum} from "@/Constants/Enums.js";
import InputError from "@/Components/InputError.vue";
import XSelect from "@/Components/XSelect.vue";
import {computed} from "vue";
import {readableOptions} from "@/Composables/EnumHelper.js";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const emit = defineEmits(['close']);

defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxWidth: {
    type: String,
    default: '2xl',
  },
  closeable: {
    type: Boolean,
    default: true,
  },
});

const form = useForm({
  name: '',
  description: '',
  status: TaskStatusEnum.PENDING,
  due_date: null,
});

const statusOptions = computed(() => readableOptions(TaskStatusEnum));

const submit = () => {
  form.post(route('task.store'), {
    preserveScroll: true,
    onSuccess: () => {
      emit('close');
      form.reset();
    },
  });
};

const close = () => emit('close');
</script>

<template>
  <dialog-modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      @close="close"
  >
    <template #title>
      <h3 class="text-lg">
        Create Task
      </h3>
    </template>

    <template #content>
      <form @submit.prevent="submit" class="grid grid-cols-1 gap-6">
        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <text-input v-model="form.name" id="name" name="name" type="text" placeholder="Task #1496" class="mt-1" />
          <input-error :message="form.errors.name" class="mt-0.5"/>
        </div>
        <!-- Status -->
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <x-select :values="statusOptions" v-model="form.status" id="status" name="status" class="mt-1" />
          <input-error :message="form.errors.status" class="mt-0.5" />
        </div>
        <!-- Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <text-input v-model="form.description" id="description" name="description" type="text" class="mt-1" />
          <input-error :message="form.errors.description" class="mt-0.5" />
        </div>
        <!-- Due Date -->
        <div>
          <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
          <text-input v-model="form.due_date" id="due_date" name="due_date" class="mt-1" type="datetime-local"/>
          <input-error :message="form.errors.due_date" class="mt-0.5" />
        </div>
      </form>
    </template>

    <template #footer>
      <secondary-button :disabled="form.processing" @click="submit">Create</secondary-button>
    </template>
  </dialog-modal>
</template>
