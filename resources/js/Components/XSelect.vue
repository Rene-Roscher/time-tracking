<template>
    <Listbox
        v-slot="{ open }"
        v-model="selectedValue"
    >
        <div class="relative">
            <ListboxButton
                :class="[
                    open ? 'border-primary' : 'border-zinc-300',
                    'text-zinc-800 py-2 h-10',
                    'relative pl-3 pr-8 text-sm text-left border focus:ring-transparent focus:outline-none rounded-md shadow-sm transition ease-in-out duration-150'
                ]"
            >
                <span class="truncate flex items-center">
                    <!-- Icon -->
                    <component
                        :is="iconPrefix"
                        v-if="iconPrefix"
                        class="absolute inset-y h-4 w-4 left-3"
                    />
                    <span
                        :class="{'pl-6': !!iconPrefix}"
                    >
                        <slot
                            v-if="selectedValue"
                            name="selected"
                            :option="selectedValue"
                        >{{ translatable ? __(selectedValue.label) : selectedValue.label }}</slot>
                        <slot
                            v-if="!selectedValue"
                            name="selectedNone"
                        >{{ __('Nothing selected') }}</slot>
                    </span>
                </span>
                <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                    <svg
                        :class="[
                            open ? 'text-zinc-500 transform rotate-180' : 'text-zinc-400',
                            'h-5 w-5 transition ease-in-out duration-300'
                        ]"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                    ><path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd"
                    /></svg>
                </span>
            </ListboxButton>
            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="mt-1 absolute w-full shadow-sm focus:outline-none rounded-lg overflow-hidden z-10"
                    :class="[
                        'border border-gray-300 bg-white ',
                    ]"
                >
                    <!-- Search -->
                    <div
                        v-if="searchable"
                        class="relative"
                    >
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <component
                                :is="searchLensIcon"
                                class="h-6 w-6 text-gray-400"
                                aria-hidden="true"
                            />
                        </div>
                        <input
                            v-model="query"
                            class="w-full pl-10 py-2 px-4 text-sm leading-5 text-gray-500 font-medium focus:ring-0 focus:outline-none transition ease-in-out duration-150 border-b border-gray-200"
                            :placeholder="__('Search...')"
                        >
                    </div>

                    <!-- Options -->
                    <div class="overflow-y-auto max-h-96">
                        <!-- No results -->
                        <div
                            v-if="filteredOptions.length === 0 && query !== ''"
                            class="relative cursor-default text-sm leading-5 select-none py-2 px-4 text-gray-700 text-center"
                        >
                            {{ __('Nothing found.') }}
                        </div>

                        <!-- Options -->
                        <ListboxOption
                            v-for="option in filteredOptions"
                            v-slot="{ active }"
                            :key="option.value"
                            :value="option"
                            as="template"
                            @click="change"
                        >
                            <li
                                :class="[
                                    selectedValue?.value === option.value ? 'font-semibold bg-primary-50 text-primary-600' : 'font-normal text-gray-900',
                                    active ? 'bg-primary-50' : 'bg-white',
                                    'relative py-2 pl-3 pr-8 text-xs md:text-sm cursor-pointer select-none transition ease-in-out duration-150'
                                ]"
                            >
                                <span :class="['truncate leading-5']">
                                    <slot
                                        name="option"
                                        :option="option"
                                    >{{ translatable ? __(option.label) : option.label }}</slot>
                                </span>
                                <span
                                    v-if="selectedValue?.value === option.value"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-primary-600"
                                >
                                    <component
                                        :is="checkIcon"
                                        class="h-4.5 md:h-5 w-4.5 md:w-5 transition ease-in-out duration-150"
                                    />
                                </span>
                            </li>
                        </ListboxOption>
                    </div>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
import { ref, watch, watchEffect, computed, toRefs } from 'vue'
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue'
import { checkIcon, searchLensIcon } from '@/Constants/Icons.js'

const props = defineProps({
    values: {
        type: [Array, Object],
        required: true
    },
    iconPrefix: {
        type: Object,
        default: null
    },
    keyField: {
        type: String,
        default: 'id'
    },
    valueField: {
        type: String,
        default: 'name'
    },
    translatable: {
        type: Boolean,
        default: false
    },
    nullable: {
        type: Boolean,
        default: false
    },
    modelValue: {
        type: [String, Number, Array],
        default: null
    },
    searchable: {
        type: Boolean,
        default: false
    },
    returnObject: {
        type: Boolean,
        default: false
    },
})

const { returnObject } = toRefs(props)

const query = ref('')
const options = ref([])
const selectedValue = ref(null)

watchEffect(() => {
    if (Array.isArray(props.values)) {
        options.value = props.values.map(value => {
            if (typeof value === 'string') {
                return { label: value, value, data: value }
            }
            return {
                label: value[props.valueField],
                value: value[props.keyField],
                data: value
            }
        })
    } else if (typeof props.values === 'object') {
        options.value = Object.entries(props.values).map(([key, value]) => ({
            label: value,
            value: key,
            data: value
        }))
    }

    if (props.modelValue && options.value.length) {
        const matchingOption = options.value.find(option => option.value == props.modelValue)
        if (matchingOption) {
            selectedValue.value = matchingOption
        }
    } else if (options.value.length) {
        if (!props.nullable) {
            selectedValue.value = options.value[0]
            emit('update:modelValue', options.value[0].value)
        }
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const change = () => {
    if (returnObject.value) {
        emit('change', selectedValue.value.data)
        return
    }
    emit('change', selectedValue.value.value)
}

watch(selectedValue, (newValue, oldValue) => {
    if (returnObject.value) {
        emit('update:modelValue', newValue.data)
        return
    }

    emit('update:modelValue', newValue.value)

    if (props.searchable) { query.value = '' }
})

const filteredOptions = computed(() => {
    if (!query.value) {
        return options.value
    }
    return options.value.filter(option =>
        option.label.toLowerCase().includes(query.value.toLowerCase())
    )
})
</script>
