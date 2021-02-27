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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h5>{{ __("การนัดหมาย") }}</h5>
                        <breeze-validation-errors class="mb-4" />
                        <div
                            v-if="status"
                            class="mb-4 font-medium text-sm text-green-600"
                        >
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit">
                            <div>
                                <breeze-label for="name" :value="__('ชื่อ')" />
                                <breeze-input
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="appointment-name"
                                />
                            </div>

                            <fieldset class="block mt-4">
                                <legend
                                    class="text-base font-medium text-gray-900"
                                >
                                    {{ __("ผู้ใช้งาน") }}
                                </legend>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="pit"
                                            v-model:checked="form.pit"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("บุคคลธรรมดา") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="cit"
                                            v-model:checked="form.cit"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("นิติบุลคล") }}</span
                                        >
                                    </label>
                                </div>
                            </fieldset>

                            <fieldset class="block mt-4">
                                <legend
                                    class="text-base font-medium text-gray-900"
                                >
                                    {{ __("เจ้าหน้าที่") }}
                                </legend>

                                <div>
                                    <breeze-label
                                        for="worker"
                                        :value="__('จำนวนเจ้าหน้าที่')"
                                    />
                                    <breeze-input
                                        id="worker"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.worker"
                                        required
                                        autocomplete="current-worker"
                                    />
                                </div>

                                <div class="mt-2">
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="official"
                                            v-model:checked="form.official"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("ข้าราชการ") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="employee"
                                            v-model:checked="form.employee"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{
                                                __("ลูกจ้าง,พนักงานราชการ")
                                            }}</span
                                        >
                                    </label>
                                </div>
                            </fieldset>

                            <fieldset class="block mt-4">
                                <legend
                                    class="text-base font-medium text-gray-900"
                                >
                                    {{ __("เปิดทำการ") }}
                                </legend>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="mon"
                                            v-model:checked="form.mon"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("จันทร์") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="tue"
                                            v-model:checked="form.tue"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("อังคาร") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="wed"
                                            v-model:checked="form.wed"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("พุธ") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="thu"
                                            v-model:checked="form.thu"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("พฤหัสบดี") }}</span
                                        >
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <breeze-checkbox
                                            name="fri"
                                            v-model:checked="form.fri"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-600"
                                            >{{ __("ศุกร์") }}</span
                                        >
                                    </label>
                                </div>
                            </fieldset>

                            <div class="flex items-center justify-end mt-4">
                                <inertia-link
                                    :href="route('appointments.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                >
                                    {{ __("ยกเลิก") }}
                                </inertia-link>

                                <breeze-button
                                    class="ml-4"
                                    :class="{
                                        'opacity-25': form.processing,
                                    }"
                                    :disabled="form.processing"
                                >
                                    {{ __("บันทึก") }}
                                </breeze-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeButton from "@/Components/Button";
import BreezeCheckbox from "@/Components/Checkbox";
import BreezeInput from "@/Components/Input";
import BreezeLabel from "@/Components/Label";
import BreezeValidationErrors from "@/Components/ValidationErrors";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
    },

    props: {
        status: String,
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
