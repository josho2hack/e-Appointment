<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("รายการจอง") }}
            </h2>
        </template>

        <flash-messages />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6 flex justify-between items-center">
                            <search-filter
                                v-model="form.search"
                                class="w-full max-w-md mr-4"
                                from="วันที่นัด"
                                @reset="reset"
                            >
                            </search-filter>
                        </div>
                        <div class="bg-white rounded shadow overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="text-left font-bold">
                                        <th class="px-6 pt-6 pb-4">
                                            การนัดหมาย
                                        </th>
                                        <th class="px-6 pt-6 pb-4">
                                            วันที่นัด
                                        </th>
                                        <th class="px-6 pt-6 pb-4">
                                            รอบนัดหมาย
                                        </th>
                                        <th class="px-6 pt-6 pb-4" colspan="2">
                                            สถานะ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="booking in bookings.data"
                                        :key="booking.id"
                                        class="hover:bg-gray-100 focus-within:bg-gray-100"
                                    >
                                        <td class="border-t">
                                            <inertia-link
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'bookings.show',
                                                        booking.id
                                                    )
                                                "
                                            >
                                                {{ booking.appointment.name }}
                                            </inertia-link>
                                        </td>
                                        <td class="border-t">
                                            <span
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                {{ booking.date }}
                                            </span>
                                        </td>
                                        <td class="border-t">
                                            <span
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                {{
                                                    minuteFormat(
                                                        booking.round.start
                                                    )
                                                }}
                                                -
                                                {{
                                                    minuteFormat(
                                                        booking.round.end
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td class="border-t">
                                            <span v-if="booking.status == null"
                                                class="text-red-400 px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                ใหม่
                                            </span>
                                            <span v-if="booking.status == 0"
                                                class="text-yellow-400 px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                กำลังดำเนินการ
                                            </span>
                                            <span v-if="booking.status == 1"
                                                class="text-green-400 px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                แล้วเสร็จ
                                            </span>
                                        </td>
                                        <td class="border-t w-px">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3
                                                "
                                                class="px-2 py-2 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'bookings.edit',
                                                        booking.id
                                                    )
                                                "
                                            >
                                                <svg
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                    class="-mt-px w-5 h-5 text-yellow-400"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1"
                                                        d="M2,4 L2,18 L16,18 L16,12 L18,10 L18,20 L17,20 L0,20 L0,19 L0,3 L0,2 L10,2 L8,4 L2,4 Z M12.2928932,3.70710678 L4,12 L4,16 L8,16 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z"
                                                    />
                                                </svg>
                                            </inertia-link>
                                        </td>
                                    </tr>
                                    <tr v-if="bookings.data.length === 0">
                                        <td
                                            class="border-t px-6 py-4"
                                            colspan="6"
                                        >
                                            {{ __("ไม่พบข้อมูลการนัดหมาย") }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination :links="bookings.links" />
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Icon from "@/Components/Icon";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import FlashMessages from "@/Components/FlashMessages";
import Pagination from "@/Components/Pagination";
import SearchFilter from "@/Components/SearchFilter";

export default {
    metaInfo: { title: "Bookings" },
    components: {
        BreezeAuthenticatedLayout,
        Icon,
        Pagination,
        SearchFilter,
        FlashMessages,
    },
    props: {
        bookings: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
            },
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.get(
                    this.route(
                        "bookings.index",
                        Object.keys(query).length
                            ? query
                            : { remember: "forget" }
                    )
                );
            }, 150),
            deep: true,
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        },
        minuteFormat(value) {
            let time = value.split(":");
            return time[0] + ":" + time[1];
        },
    },
    mounted() {
        //console.log(this.$page.props);
        //console.log(this.bookings);
    },
};
</script>
