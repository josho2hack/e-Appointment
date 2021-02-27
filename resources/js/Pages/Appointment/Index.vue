<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Appointment") }}
            </h2>
        </template>

        <!-- <flash-messages /> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6 flex justify-between items-center">
                            <search-filter
                                v-model="form.search"
                                class="w-full max-w-md mr-4"
                                @reset="reset"
                            >
                            </search-filter>
                            <inertia-link
                                v-if="$page.props.auth.user.role_id < 3"
                                class="btn btn-primary"
                                :href="route('appointments.create')"
                            >
                                <span>{{ __("เพิ่ม") }}</span>
                                <span class="hidden md:inline">{{
                                    __("Appointment")
                                }}</span>
                            </inertia-link>
                        </div>
                        <div class="bg-white rounded shadow overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="text-left font-bold">
                                        <th class="px-6 pt-6 pb-4">หัวข้อ</th>
                                        <th class="px-6 pt-6 pb-4" colspan="5">
                                            หน่วยงาน
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="appointment in appointments.data"
                                        :key="appointment.id"
                                        class="hover:bg-gray-100 focus-within:bg-gray-100"
                                    >
                                        <td class="border-t">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id >= 3
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'guest',
                                                        appointment.id
                                                    )
                                                "
                                            >
                                                {{ appointment.name }}
                                            </inertia-link>
                                            <span
                                                v-else
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                {{ appointment.name }}
                                            </span>
                                        </td>
                                        <td class="border-t">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id >= 3
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'guest',
                                                        appointment.id
                                                    )
                                                "
                                                tabindex="-1"
                                            >
                                                {{ appointment.office.name }}
                                            </inertia-link>
                                            <span
                                                v-else
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                            >
                                                {{ appointment.office.name }}
                                            </span>
                                        </td>
                                        <td class="border-t w-px">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3 &&
                                                    $page.props.auth.user
                                                        .level < 4 &&
                                                    !appointment.public
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'public',
                                                        appointment.id
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
                                                    class="-mt-px w-6 h-6 text-green-400"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4.16 4.16l1.42 1.42A6.99 6.99 0 0 0 10 18a7 7 0 0 0 4.42-12.42l1.42-1.42a9 9 0 1 1-11.69 0zM9 0h2v8H9V0z"
                                                    />
                                                </svg>
                                            </inertia-link>
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3 &&
                                                    $page.props.auth.user
                                                        .level < 4 &&
                                                    appointment.public
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'public',
                                                        appointment.id
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
                                                    class="-mt-px w-6 h-6 text-red-400"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1"
                                                        d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 Z M7,6 L9,6 L9,14 L7,14 L7,6 Z M11,6 L13,6 L13,14 L11,14 L11,6 Z"
                                                    />
                                                </svg>
                                            </inertia-link>
                                        </td>
                                        <td class="border-t w-px">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'appointments.show',
                                                        appointment.id
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
                                                class="-mt-px w-6 h-6 text-green-300"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1"
                                                    d="M19.8005808,10 C17.9798698,6.43832409 14.2746855,4 10,4 C5.72531453,4 2.02013017,6.43832409 0.199419187,10 C2.02013017,13.5616759 5.72531453,16 10,16 C14.2746855,16 17.9798698,13.5616759 19.8005808,10 Z M10,14 C12.209139,14 14,12.209139 14,10 C14,7.790861 12.209139,6 10,6 C7.790861,6 6,7.790861 6,10 C6,12.209139 7.790861,14 10,14 Z M10,12 C11.1045695,12 12,11.1045695 12,10 C12,8.8954305 11.1045695,8 10,8 C8.8954305,8 8,8.8954305 8,10 C8,11.1045695 8.8954305,12 10,12 Z"
                                                />
                                            </svg>
                                            </inertia-link>
                                        </td>
                                        <td class="border-t w-px">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'appointments.edit',
                                                        appointment.id
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
                                        <td class="border-t w-px">
                                            <inertia-link
                                                v-if="
                                                    $page.props.auth.user
                                                        .role_id < 3
                                                "
                                                class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                :href="
                                                    route(
                                                        'appointments.destroy',
                                                        appointment.id
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
                                                class="-mt-px w-5 h-5 text-red-400"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1"
                                                    d="M2,2 L18,2 L18,4 L2,4 L2,2 Z M8,0 L12,0 L14,2 L6,2 L8,0 Z M3,6 L17,6 L16,20 L4,20 L3,6 Z M8,8 L9,8 L9,18 L8,18 L8,8 Z M11,8 L12,8 L12,18 L11,18 L11,8 Z"
                                                />
                                            </svg>
                                            </inertia-link>
                                        </td>
                                    </tr>
                                    <tr v-if="appointments.data.length === 0">
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
                        <pagination :links="appointments.links" />
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
//import FlashMessages from "@/Components/FlashMessages";
import Pagination from "@/Components/Pagination";
import SearchFilter from "@/Components/SearchFilter";

export default {
    metaInfo: { title: "Appointments" },
    components: {
        BreezeAuthenticatedLayout,
        Icon,
        Pagination,
        SearchFilter,
        //FlashMessages,
    },
    props: {
        appointments: Object,
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
                        "appointments.index",
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
    },
    mounted() {
        //console.log(this.$page.props);
        //console.log(this.$inertia);
    },
};
</script>
