<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('appointments.index')"
                    >{{ __("Appointment") }}
                </inertia-link>
                > {{ __("จองนัดหมาย") }}
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
                                            {{ appointment.name }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{
                                                __(
                                                    "บันทึกเพื่อจองกำหนดการนัดหมาย"
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
                                            <!-- หมายเลขผู้เสียภาษี -->
                                            <div
                                                v-if="
                                                    appointment.pit ||
                                                    appointment.cit ||
                                                    hasRequirePIN
                                                "
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
                                                                for="nid"
                                                                class="block text-md font-medium text-gray-700"
                                                                >{{
                                                                    __(
                                                                        "หมายเลขผู้เสียภาษี"
                                                                    )
                                                                }}</label
                                                            >
                                                            <input
                                                                type="text"
                                                                name="nid"
                                                                id="nid"
                                                                v-mask="'#-##-#-###-#####-#'"
                                                                v-model="
                                                                    form.nid
                                                                "
                                                                required
                                                                autofocus
                                                                @blur="getInfoNID"
                                                                autocomplete="appointment-name"
                                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ประเภทผู้นัดหมาย -->
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
                                            <!-- ชื่อผู้นัดหมาย -->
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
                                                                        "ชื่อผู้นัดหมาย"
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
                                            <!-- หัวข้อ -->
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{
                                                            __(
                                                                "เรื่องที่เกี่ยวข้อง"
                                                            )
                                                        }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            v-for="subject in subjects"
                                                            :key="subject.id"
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="{{ subject.id }}"
                                                                    v-model:checked="
                                                                        form.mon
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="{{ subject.id }}"
                                                                    class="font-medium text-gray-700"
                                                                    >{{
                                                                        subject.name
                                                                    }}</label
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <!-- รายละเอียดคำถาม -->
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
                                                                for="detail"
                                                                class="block text-md font-medium text-gray-700"
                                                                >{{
                                                                    __(
                                                                        "รายละเอียดคำถาม"
                                                                    )
                                                                }}</label
                                                            >
                                                            <input
                                                                type="text"
                                                                name="detail"
                                                                id="detail"
                                                                v-model="
                                                                    form.detail
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
                                            <!-- เบอร์โทรศัพฑ์ -->
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
                                                                for="phone"
                                                                class="block text-md font-medium text-gray-700"
                                                                >{{
                                                                    __(
                                                                        "เบอร์โทรศัพฑ์"
                                                                    )
                                                                }}</label
                                                            >
                                                            <input
                                                                type="phone"
                                                                name="phone"
                                                                id="phone"
                                                                v-model="
                                                                    form.phone
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
                                            <!-- อีเมล์ -->
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
                                                                for="email"
                                                                class="block text-md font-medium text-gray-700"
                                                                >{{
                                                                    __("อีเมล์")
                                                                }}</label
                                                            >
                                                            <input
                                                                type="email"
                                                                name="email"
                                                                id="email"
                                                                v-model="
                                                                    form.email
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
                                            <!-- เลือกวันนัด -->
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{ __("เลือกวันนัด") }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            class="grid grid-cols-6 gap-6"
                                                        >
                                                            <div
                                                                class="col-span-6 sm:col-span-3"
                                                            >
                                                                <label
                                                                    for="date"
                                                                    class="block text-sm font-medium text-gray-700"
                                                                    >{{
                                                                        __(
                                                                            "วันนัด"
                                                                        )
                                                                    }}</label
                                                                >
                                                                <input
                                                                    type="date"
                                                                    name="date"
                                                                    id="date"
                                                                    v-model="
                                                                        form.date
                                                                    "
                                                                    required
                                                                    autocomplete="current-worker"
                                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <!-- เลือกรอบนัดหมาย -->
                                            <div
                                                class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                                            >
                                                <fieldset>
                                                    <legend
                                                        class="text-base font-medium text-gray-900"
                                                    >
                                                        {{
                                                            __(
                                                                "เลือกรอบนัดหมาย"
                                                            )
                                                        }}
                                                    </legend>
                                                    <div class="mt-4 space-y-4">
                                                        <div
                                                            v-for="round in rounds"
                                                            :key="round.id"
                                                            class="flex items-start"
                                                        >
                                                            <div
                                                                class="flex items-center h-5"
                                                            >
                                                                <checkbox
                                                                    name="{{ round.id }}"
                                                                    v-model:checked="
                                                                        form.mon
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="ml-3 text-sm"
                                                            >
                                                                <label
                                                                    for="{{ round.id }}"
                                                                    class="font-medium text-gray-700"
                                                                    >
                                                                    {{ minuteFormat(round.start) }} - {{ minuteFormat(round.end) }}
                                                                    </label
                                                                >
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
import {mask} from 'vue-the-mask';

export default {
    directives: {mask},

    components: {
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        FlashMessages,
        Checkbox,
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
                nid: null,
                name: "",
                type: null,
                phone: "",
                email: "",
                facebook: "",
                line_id: "",
                meeting_online: "",
                detail: "",
                date: new Date().toLocaleDateString("en-US"),
                appointment_id: this.appointment.id,
                customer_option_id: null,
                round_id: null,
                user_id: null,
            }),

            hasRequirePIN:
                this.customerOptions.filter((c) => c.require_pin === 1)
                    .length === 0
                    ? false
                    : true,
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("bookings.store"));
        },
        minuteFormat(value) {
            let time = value.split(":");
            return time[0] + ':' + time[1];
        },
        getInfoNID(){
            let data
            data = this.$inertia.get('http://192.168.41.110:8080/tinws/getTaxpayerInfo/nid/' + this.form.nid)
            console.log(data)
        }
    },

    computed: {

    },

    mounted() {
        //console.log(this.rounds);
    },
};
</script>
