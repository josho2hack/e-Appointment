<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('appointments.index')"
                    >{{ __("Appointment") }}
                </inertia-link>
                > {{ __("เพิ่มการนัดหมาย") }}
            </h2>
        </template>

        <flash-messages />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Start Content -->
                        <breeze-validation-errors class="mb-4" />

                        <div class="mt-10 sm:mt-0">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                        <h3
                                            class="text-lg font-medium leading-6 text-gray-900"
                                        >
                                            {{ __("การนัดหมาย") }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{
                                                __(
                                                    "กำหนดชื่อการนัดหมาย ประเภทผู้นัดหมาย จำนวนพนักงาน วันเปิดให้นัดหมาย"
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>
                                <div class="md:mt-0 md:col-span-2">
                                    <form @submit.prevent="submit">
                                        <div
                                            class="shadow overflow-hidden sm:rounded-md"
                                        >
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <div class="mt-4 space-y-4">
                                                    <div
                                                        class="grid grid-cols-6 gap-6"
                                                    >
                                                        <div
                                                            class="col-span-12 sm:col-span-6"
                                                        >
                                                            <label
                                                                for="name"
                                                                class="block text-md font-medium text-gray-700"
                                                                >{{
                                                                    __(
                                                                        "ชื่อการนัดหมาย"
                                                                    )
                                                                }}</label
                                                            >
                                                            <input
                                                                type="text"
                                                                name="name"
                                                                id="name"
                                                                v-model="
                                                                    form.name
                                                                "
                                                                required
                                                                autofocus
                                                                autocomplete="appointment-name"
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{
                                                            __(
                                                                "ประเภทผู้นัดหมาย"
                                                            )
                                                        }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="pit"
                                                                    v-model:checked="
                                                                        form.pit
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="pit"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "บุคคลธรรมดา"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    ผู้เสียภาษี
                                                                    ประเภทบุคคลธรรมดา
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="cit"
                                                                    v-model:checked="
                                                                        form.cit
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="cit"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "นิติบุลคล"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    ผู้เสียภาษี
                                                                    ประเภทนิติบุลคล
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{ __("เจ้าหน้าที่") }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            class="grid grid-cols-6 gap-6"
                                                        >
                                                            <div
                                                                class="col-span-3 sm:col-span-1"
                                                            >
                                                                <label
                                                                    for="worker"
                                                                    class="block text-sm font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "จำนวน"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <input
                                                                    type="number"
                                                                    name="worker"
                                                                    id="worker"
                                                                    v-model="
                                                                        form.worker
                                                                    "
                                                                    required
                                                                    autocomplete="current-worker"
                                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="official"
                                                                    v-model:checked="
                                                                        form.official
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="official"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "ข้าราชการ"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    มอบหมายให้ข้าราชการดำเนินการ
                                                                    การนัดหมาย
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="employee"
                                                                    v-model:checked="
                                                                        form.employee
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="employee"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "ลูกจ้าง,พนักงานราชการ"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    มอบหมายให้ลูกจ้างหรือพนักงานราชการดำเนินการ
                                                                    การนัดหมาย
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{
                                                            __(
                                                                "วันเปิดให้นัดหมาย"
                                                            )
                                                        }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="mon"
                                                                    v-model:checked="
                                                                        form.mon
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="mon"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "จันทร์"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดให้นัดหมายได้ทุกวันจันทร์
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="tue"
                                                                    v-model:checked="
                                                                        form.tue
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="tue"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "อังคาร"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดให้นัดหมายได้ทุกวันอังคาร
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="wed"
                                                                    v-model:checked="
                                                                        form.wed
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="wed"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "พุธ"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดให้นัดหมายได้ทุกวันพุธ
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="thu"
                                                                    v-model:checked="
                                                                        form.thu
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="thu"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "พฤหัสบดี"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดให้นัดหมายได้ทุกวันพฤหัสบดี
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="fri"
                                                                    v-model:checked="
                                                                        form.fri
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="fri"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "ศุกร์"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดให้นัดหมายได้ทุกวันศุกร์
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                            >
                                                <inertia-link
                                                    :href="
                                                        route(
                                                            'appointments.index'
                                                        )
                                                    "
                                                    class="underline text-sm text-gray-600 hover:text-gray-900 mr-2"
                                                >
                                                    {{ __("ยกเลิก") }}
                                                </inertia-link>
                                                <button
                                                    type="submit"
                                                    :disabled="form.processing"
                                                    :class="{
                                                        'opacity-25':
                                                            form.processing,
                                                    }"
                                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    {{ __("บันทึก") }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Content -->
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeValidationErrors from "@/Components/ValidationErrors";
import FlashMessages from "@/Components/FlashMessages";
import Checkbox from "@/Components/Checkbox";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        FlashMessages,
        Checkbox,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                pit: true,
                cit: true,
                worker: 1,
                official: true,
                employee: false,
                mon: true,
                tue: true,
                wed: true,
                thu: true,
                fri: true,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("appointments.store"));
        },
    },
};
</script>
