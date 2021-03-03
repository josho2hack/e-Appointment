<template>
    <!-- Modal -->
    <div
        style="
            background-color: rgba(0, 0, 0, 0.8);
            transition: opacity 0.3s ease;
        "
        class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
    >
        <div
            class="p-4 max-w-4xl mx-auto relative left-0 right-0 overflow-hidden"
        >
            <div
                class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                @click="$emit('close')"
            >
                <svg
                    class="fill-current w-6 h-6"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z"
                    />
                </svg>
            </div>

            <div
                class="shadow rounded-lg bg-white overflow-hidden w-full block p-8"
            >
                <h5 class="font-bold text-md mb-6 text-gray-800 border-b pb-2">
                    {{ __("กำหนดรอบ") }}
                </h5>
                <div class="grid grid-cols-6 gap-6 mb-4">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("เวลาเริ่ม") }}</label
                        >
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="time"
                            :value="start"
                            @input="$emit('update:start', $event.target.value)"
                            required
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("เวลาหยุด") }}</label
                        >
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="time"
                            :value="end"
                            @input="$emit('update:end', $event.target.value)"
                            required
                        />
                    </div>
                    <div class="relative col-span-6 sm:col-span-2 text-right">
                        <div class="sm:absolute sm:bottom-0 sm:right-0">
                            <button
                                type="button"
                                class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-3 border border-gray-300 rounded-lg shadow-sm mr-2"
                                @click="$emit('close')"
                            >
                                {{ __("ยกเลิก") }}
                            </button>
                            <button
                                type="button"
                                :disabled="rounds.length === 7"
                                class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-3 border border-gray-700 rounded-lg shadow-sm"
                                @click="$emit('submit')"
                            >
                                {{ __("บันทึก") }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-2 pb-2">เวลาเริ่ม</th>
                                <th class="px-6 pt-2 pb-2" colspan="2">
                                    เวลาหยุด
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="round in rounds"
                                :key="round.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <span
                                        class="px-6 py-2 flex items-center focus:text-indigo-500"
                                    >
                                        {{ round.start }}
                                    </span>
                                </td>
                                <td class="border-t">
                                    <span
                                        class="px-6 py-2 flex items-center focus:text-indigo-500"
                                    >
                                        {{ round.end }}
                                    </span>
                                </td>
                                <td class="border-t w-px">
                                    <button
                                        class="px-2 py-2 flex items-center focus:text-indigo-500"
                                        @click="$emit('destroy', round.id)"
                                    >
                                        <svg
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                            class="-mt-px w-5 h-5 text-red-400"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1"
                                                d="M2,2 L18,2 L18,4 L2,4 L2,2 Z M8,0 L12,0 L14,2 L6,2 L8,0 Z M3,6 L17,6 L16,20 L4,20 L3,6 Z M8,8 L9,8 L9,18 L8,18 L8,8 Z M11,8 L12,8 L12,18 L11,18 L11,8 Z"
                                            />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="rounds.length === 0">
                                <td class="border-t px-6 py-4" colspan="6">
                                    {{ __("ไม่พบข้อมูล") }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <pagination :links="rounds.links" /> -->
            </div>
        </div>
    </div>
    <!-- /Modal -->
</template>

<script>
//import Pagination from "@/Components/PaginationModal";

export default {
    components: {
        //Pagination,
    },
    emits: ["submit", "close", "destroy", "update:start", "update:end"],
    props: {
        start: String,
        end: String,
        rounds: Array,
    },
};
</script>
