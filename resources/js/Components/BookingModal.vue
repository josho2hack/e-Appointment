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
            <!-- Content -->
            <div
                class="shadow rounded-lg bg-white overflow-hidden w-full block p-8"
            >
                <h5 class="font-bold text-md mb-6 text-gray-800 border-b pb-2">
                    {{ __("ข้อมูลจองนัดหมาย") }}
                </h5>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("หัวข้อ") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ appointment }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("หมายเลขผู้เสียภาษี") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ nid }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("ประเภทผู้นัดหมาย") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span v-if="type === 0"
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >บุคคลธรรมดา</span
                        >
                        <span v-if="type === 1"
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >นิติบุลคล</span
                        >
                        <span  v-if="customerInfo !== ''"
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ customer }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("ชื่อผู้นัดหมาย") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ name }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("เรื่องที่เกี่ยวข้อง") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ subject.substring(0, 20) }}...</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("รายละเอียดคำถาม") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ detail.substring(0, 10) }}...</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("เบอร์โทรศัพฑ์") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ phone }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("อีเมล์") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ email }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("Facebook") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ facebook }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("Line") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ line_id }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("วันนัด") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ date }}</span
                        >
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6 mb-2">
                    <div class="col-span-3 sm:col-span-2">
                        <label
                            class="text-gray-800 block mb-1 font-bold text-sm tracking-wide"
                            >{{ __("รอบนัดหมาย") }}</label
                        >
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <span
                            class="text-blue-700 block mb-1 font-bold text-sm tracking-wide"
                            >{{ round }}</span
                        >
                    </div>
                </div>
                <div class="relative bg-gray-50 col-span-6 sm:col-span-2 text-right">
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
                                class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-2 px-3 border border-blue-700 rounded-lg shadow-sm"
                                @click="$emit('submit')"
                            >
                                {{ __("บันทึก") }}
                            </button>
                        </div>
                    </div>
            </div>
            <!-- End Content -->
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
    emits: ["submit", "close"],
    props: {
        nid: String,
        name: String,
        type: Number,
        phone: String,
        email: String,
        facebook: String,
        line_id: String,
        detail: String,
        date: String,
        appointment: String,
        round: String,
        customer: String,
        subject: String,
    },
};
</script>
