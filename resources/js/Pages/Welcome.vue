<template>
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <inertia-link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 underline"
            >
                {{ __("Dashboard") }}
            </inertia-link>

            <template v-else>
                <inertia-link
                    :href="route('login')"
                    class="text-sm text-gray-700 underline"
                >
                    {{ __("Login") }}
                </inertia-link>

                <Link href="login">login</Link>

                <inertia-link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-2 text-sm text-gray-700 underline"
                >
                    {{ __("Register") }}
                </inertia-link>

                <inertia-link
                    v-if="canLoginEmployee"
                    :href="route('login.employee')"
                    class="ml-2 text-sm text-gray-700 underline"
                >
                    {{ __("Employee") }}
                </inertia-link>
            </template>

            <language-selector />
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <img class="rd-logo" src="assets/images/e-appointment.png" />
            </div>

            <div
                v-if="canLogin"
                class="block flex justify-center px-6 pt-2 sm:hidden"
            >
                <inertia-link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="text-sm text-gray-700 underline"
                >
                    {{ __("Dashboard") }}
                </inertia-link>

                <template v-else>
                    <inertia-link
                        :href="route('login')"
                        class="text-sm text-gray-700 underline"
                    >
                        {{ __("Login") }}
                    </inertia-link>

                    <inertia-link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ml-2 text-sm text-gray-700 underline"
                    >
                        {{ __("Register") }}
                    </inertia-link>

                    <inertia-link
                        v-if="canLoginEmployee"
                        :href="route('login.employee')"
                        class="ml-2 text-sm text-gray-700 underline"
                    >
                        {{ __("Employee") }}
                    </inertia-link>
                </template>

                <language-selector />
            </div>

            <div
                class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg"
            >
                <div class="grid grid-cols-1">
                    <flash-messages />
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-500"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                {{ __("Appointment") }}
                            </div>
                        </div>

                        <div class="ml-0">
                            <div
                                class="mt-2 text-gray-600 dark:text-gray-400 text-sm"
                            >
                                <div
                                    class="mb-6 flex justify-between items-center"
                                >
                                    <search-filter
                                        v-model="form.search"
                                        class="w-full max-w-md mr-4"
                                        from="หัวข้อ"
                                        @reset="reset"
                                    >
                                    </search-filter>
                                </div>
                                <div
                                    class="bg-white rounded shadow overflow-x-auto"
                                >
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr class="text-left font-bold">
                                                <th class="px-6 pt-6 pb-4">
                                                    หัวข้อ
                                                </th>
                                                <th
                                                    class="px-6 pt-6 pb-4"
                                                    colspan="4"
                                                >
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
                                                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                        :href="
                                                            route(
                                                                'guest',
                                                                appointment.uuid
                                                            )
                                                        "
                                                    >
                                                        {{ appointment.name }}
                                                    </inertia-link>
                                                </td>
                                                <td class="border-t">
                                                    <span
                                                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                    >
                                                        {{
                                                            appointment.office
                                                                .name
                                                        }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr
                                                v-if="
                                                    appointments.data.length ===
                                                    0
                                                "
                                            >
                                                <td
                                                    class="border-t px-6 py-4"
                                                    colspan="6"
                                                >
                                                    {{
                                                        __(
                                                            "ไม่พบข้อมูลการนัดหมาย"
                                                        )
                                                    }}
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
            </div>

            <div
                class="flex justify-center mt-4 sm:items-center sm:justify-between"
            >
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        <svg
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="-mt-px w-5 h-5 text-gray-400"
                        >
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            ></path>
                        </svg>

                        <a href="#" class="ml-1 underline">
                            {{ __("Document") }}
                        </a>

                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            class="ml-4 -mt-px w-5 h-5 text-gray-400"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
                            />
                        </svg>

                        <a href="#" class="ml-1 underline">
                            {{ __("Chat") }}
                        </a>
                    </div>
                </div>

                <div
                    class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0"
                >
                    e-Appointment v 1.0.0
                </div>
            </div>

            <!-- Footer Content -->
            <div class="flex justify-center mt-4 sm:items-center">
                <div class="text-center text-sm text-gray-500">
                    <div class="flex items-center">
                        <footer class="bg-light py-5">
                            <div class="container">
                                <div class="row">
                                    <!-- Owner System -->
                                    <div class="col-lg-12 text-center">
                                        <h5>สอบถามรายละเอียดเพิ่มเติม</h5>
                                        <p>
                                            <a
                                                title="คลิกเพื่อโทรหา Call Center: 1161"
                                                href="tel:1161"
                                            >
                                                RD Intelligent Center 1161</a
                                            ><br />
                                            ด้านสิทธิประโยชน์ทางภาษี : โทร.
                                            02-2728289, 02-2728400, 02-2729168,
                                            02-2729819<br />ด้านระบบงาน : โทร.
                                            02-272-8804, 02-272-8743
                                        </p>
                                    </div>
                                    <!-- Footer Address -->
                                    <hr />
                                    <div class="col-lg-12 text-center">
                                        <h5>กรมสรรพากร</h5>
                                        <p>
                                            90 ซอยพหลโยธิน 7 ถนนพหลโยธิน
                                            แขวงพญาไท เขตพญาไท กรุงเทพฯ 10400
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>

<script>
import LanguageSelector from "@/Language/LanguageSelector";
import Icon from "@/Components/Icon";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import Pagination from "@/Components/Pagination";
import SearchFilter from "@/Components/SearchFilter";
import FlashMessages from "@/Components/FlashMessages";
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        LanguageSelector,
        Icon,
        Pagination,
        SearchFilter,
        FlashMessages,
        Link
    },
    props: {
        canLogin: Boolean,
        canLoginEmployee: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        appointments: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
            },
            formPublic: this.$inertia.form({
                public: false,
            }),
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.get(
                    this.route(
                        "index",
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
};
</script>
