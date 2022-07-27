<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('appointments.index')"
                    >{{ __("Appointment") }}
                </inertia-link>
                > {{ __("ปรับปรุงการนัดหมาย") }}
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
                                                                }}
                                                                {{
                                                                    form.name
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
                                                                <input
                                                                    id="pit"
                                                                    name="pit"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.pit
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="cit"
                                                                    name="cit"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.cit
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                            "นิติบุคคล"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    ผู้เสียภาษี
                                                                    ประเภทนิติบุคคล
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
                                                                <input
                                                                    id="official"
                                                                    name="official"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.official
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="employee"
                                                                    name="employee"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.employee
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="mon"
                                                                    name="mon"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.mon
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="tue"
                                                                    name="tue"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.tue
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="wed"
                                                                    name="wed"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.wed
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="thu"
                                                                    name="thu"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.thu
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                                <input
                                                                    id="fri"
                                                                    name="fri"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.fri
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
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
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{
                                                            __(
                                                                "กำหนดรอบการนัดหมายและอื่นๆ"
                                                            )
                                                        }}
                                                    </legend>

                                                    <button
                                                        @click="
                                                            openRoundModal = true
                                                        "
                                                        type="button"
                                                        :disabled="
                                                            form.processing
                                                        "
                                                        :class="{
                                                            'opacity-25':
                                                                form.processing,
                                                        }"
                                                        class="inline-flex justify-center py-2 px-2 mr-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                    >
                                                        {{ __("กำหนดรอบ") }}
                                                    </button>

                                                    <button
                                                        @click="
                                                            openSubjectModal = true
                                                        "
                                                        type="button"
                                                        :disabled="
                                                            form.processing
                                                        "
                                                        :class="{
                                                            'opacity-25':
                                                                form.processing,
                                                        }"
                                                        class="inline-flex justify-center py-2 px-2 mr-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                    >
                                                        {{ __("กำหนดหัวข้อ") }}
                                                    </button>

                                                    <button
                                                        @click="
                                                            openCustomerOptionModal = true
                                                        "
                                                        type="button"
                                                        :disabled="
                                                            form.processing
                                                        "
                                                        :class="{
                                                            'opacity-25':
                                                                form.processing,
                                                        }"
                                                        class="inline-flex justify-center py-2 px-2 mr-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                    >
                                                        {{
                                                            __(
                                                                "เพิ่มประเภทผู้นัด"
                                                            )
                                                        }}
                                                    </button>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{ __("เปิดใช้งาน") }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <input
                                                                    id="public"
                                                                    name="public"
                                                                    type="checkbox"
                                                                    v-model="
                                                                        form.public
                                                                    "
                                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="public"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "เปิด"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <p
                                                                    class="text-gray-500"
                                                                >
                                                                    เปิดใช้งานการนัดหมายเพื่อให้ผู้ต้องการนัดหมายใช้งาน
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

                        <round-modal
                            v-if="openRoundModal"
                            v-model:start="formRound.start"
                            v-model:end="formRound.end"
                            :rounds="rounds"
                            @close="close"
                            @submit="submitRound"
                            @destroy="destroyRound"
                        />
                        <subject-modal
                            v-if="openSubjectModal"
                            v-model:name="formSubject.name"
                            :subjects="subjects"
                            @closeSubject="openSubjectModal = false"
                            @submit="submitSubject"
                            @destroy="destroySubject"
                        />
                        <customer-modal
                            v-if="openCustomerOptionModal"
                            v-model:name="formCustomerOption.name"
                            v-model:require_pin="formCustomerOption.require_pin"
                            :customers="customerOptions"
                            @closeCustomerOption="
                                openCustomerOptionModal = false
                            "
                            @submit="submitCustomerOption"
                            @destroy="destroyCustomerOption"
                        />
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
import CustomerModal from "@/Components/CustomerModal";
import RoundModal from "@/Components/RoundModal";
import SubjectModal from "@/Components/SubjectModal";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        FlashMessages,
        CustomerModal,
        RoundModal,
        SubjectModal,
    },

    props: {
        appointment: Object,
        rounds: Object,
        subjects: Object,
        customerOptions: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.appointment.name,
                pit: this.appointment.pit ? true : false,
                cit: this.appointment.cit ? true : false,
                worker: this.appointment.worker,
                official: this.appointment.official ? true : false,
                employee: this.appointment.employee ? true : false,
                mon: this.appointment.mon ? true : false,
                tue: this.appointment.tue ? true : false,
                wed: this.appointment.wed ? true : false,
                thu: this.appointment.thu ? true : false,
                fri: this.appointment.fri ? true : false,
                public: this.appointment.public ? true : false,
            }),

            formCustomerOption: this.$inertia.form({
                name: "",
                require_pin: false,
                appointment_id: this.appointment.id,
            }),
            formRound: this.$inertia.form({
                start: "",
                end: "",
                appointment_id: this.appointment.id,
            }),
            formSubject: this.$inertia.form({
                name: "",
                appointment_id: this.appointment.id,
            }),

            openCustomerOptionModal: false,
            openRoundModal: false,
            openSubjectModal: false,
        };
    },

    methods: {
        submit() {
            this.form.put(
                this.route("appointments.update", this.appointment.id)
            );
        },
        close() {
            this.openRoundModal = false;
            //console.log(this.formRound)
        },
        submitRound() {
            this.formRound.post(this.route("rounds.store"), {
                onFinish: () => this.formRound.reset("start", "end"),
            });
        },
        destroyRound(id) {
            this.formRound.delete(this.route("rounds.destroy", id));
        },
        submitSubject() {
            this.formSubject.post(this.route("subjects.store"), {
                onFinish: () => this.formSubject.reset("name"),
            });
        },
        destroySubject(id) {
            this.formSubject.delete(this.route("subjects.destroy", id));
        },
        submitCustomerOption() {
            this.formCustomerOption.post(this.route("customerOptions.store"), {
                onFinish: () =>
                    this.formCustomerOption.reset("name", "require_pin"),
            });
        },
        destroyCustomerOption(id) {
            this.formCustomerOption.delete(
                this.route("customerOptions.destroy", id)
            );
        },
    },
    mounted() {
        //console.log(this.appointment);
    },
};
</script>
