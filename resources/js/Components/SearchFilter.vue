<template>
    <div class="flex items-center">
        <div class="h-10 flex w-full bg-white shadow rounded">
            <input
                class="relative w-full px-6 py-3 rounded-r focus:shadow-outline"
                autocomplete="off"
                type="text"
                name="search"
                :placeholder="__('ค้นหา...')"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
        <button
            class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500"
            type="button"
            @click="$emit('reset')"
        >
            {{ __("ลบ") }}
        </button>
    </div>
</template>

<script>
import Dropdown from "@/Components/DropdownFilter";

export default {
    components: {
        Dropdown,
    },
    emits: ["update:modelValue",'reset'],
    props: {
        modelValue: String,
        maxWidth: {
            type: Number,
            default: 300,
        },
    },
};
</script>
