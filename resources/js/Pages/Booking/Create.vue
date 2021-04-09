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
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                      {{ __("การนัดหมาย") }}
                      {{ appointment.name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                      {{ __("บันทึกเพื่อจองกำหนดการนัดหมาย") }}
                    </p>
                  </div>
                </div>
                <div class="md:mt-0 md:col-span-2">
                  <form @submit.prevent="submit">
                    <div class="shadow overflow-hidden sm:rounded-md">
                      <!-- หมายเลขผู้เสียภาษี -->
                      <div
                        v-if="
                          appointment.pit || appointment.cit || hasRequirePIN
                        "
                        class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                      >
                        <div class="mt-4 space-y-4">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                              <label
                                for="nid"
                                class="block text-md font-medium text-gray-700"
                                >{{ __("หมายเลขผู้เสียภาษี") }}</label
                              >
                              <input
                                type="text"
                                name="nid"
                                id="nid"
                                v-model="form.nid"
                                required
                                maxlength="13"
                                autofocus
                                @focusout="getInfoNID"
                                autocomplete="appointment-name"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ประเภทผู้นัดหมาย -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("ประเภทผู้นัดหมาย") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <!-- cit -->
                            <div
                              v-if="appointment.pit"
                              class="flex items-start"
                            >
                              <div class="flex items-center h-5">
                                <input
                                  type="checkbox"
                                  name="pit"
                                  value="0"
                                  v-model="form.type"
                                  :checked="form.type == 0"
                                  disabled
                                />
                              </div>
                              <div class="ml-3 text-sm">
                                <label
                                  for="pit"
                                  class="font-medium text-gray-700"
                                  >{{ __("บุคคลธรรมดา") }}</label
                                >
                                <p class="text-gray-500">
                                  ผู้เสียภาษี ประเภทบุคคลธรรมดา
                                </p>
                              </div>
                            </div>
                            <!-- pit -->
                            <div
                              v-if="appointment.cit"
                              class="flex items-start"
                            >
                              <div class="flex items-center h-5">
                                <input
                                  type="checkbox"
                                  name="cit"
                                  value="1"
                                  v-model="form.type"
                                  :checked="form.type == 1"
                                  disabled
                                />
                              </div>
                              <div class="ml-3 text-sm">
                                <label
                                  for="cit"
                                  class="font-medium text-gray-700"
                                  >{{ __("นิติบุลคล") }}</label
                                >
                                <p class="text-gray-500">
                                  ผู้เสียภาษี ประเภทนิติบุลคล
                                </p>
                              </div>
                            </div>
                            <!-- Customer Option -->
                            <div
                              v-for="customer in customerOptions"
                              :key="customer.id"
                              class="flex items-center"
                            >
                              <input
                                :id="'c' + customer.id"
                                :name="'c' + customer.id"
                                :value="customer.id"
                                v-model="form.customer_option_id"
                                type="radio"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                              />
                              <label
                                :for="'c' + customer.id"
                                class="ml-3 block text-sm font-medium text-gray-700"
                              >
                                {{ customer.name }}
                              </label>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <!-- ชื่อผู้นัดหมาย -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="mt-4 space-y-4">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                              <label
                                for="name"
                                class="block text-md font-medium text-gray-700"
                                >{{ __("ชื่อผู้นัดหมาย") }}</label
                              >
                              <input
                                type="text"
                                name="name"
                                id="name"
                                v-model="form.name"
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
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("เรื่องที่เกี่ยวข้อง") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <div
                              v-for="(item, index) in subjects"
                              :key="index"
                              class="flex items-start"
                            >
                              <div class="flex items-center h-5">
                                <input
                                  type="checkbox"
                                  :name="'s' + item.id"
                                  :value="item.id"
                                  v-model="form.subjects"
                                />
                              </div>
                              <div class="ml-3 text-sm">
                                <label
                                  :for="item.id"
                                  class="font-medium text-gray-700"
                                  >{{ item.name }}</label
                                >
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <!-- รายละเอียดคำถาม -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="mt-4 space-y-4">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                              <label
                                for="detail"
                                class="block text-md font-medium text-gray-700"
                                >{{ __("รายละเอียดคำถาม") }}</label
                              >
                              <textarea
                                name="detail"
                                id="detail"
                                v-model="form.detail"
                                required
                                autofocus
                                autocomplete="appointment-detail"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md resize"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- เบอร์โทรศัพฑ์ -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="mt-4 space-y-4">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                              <label
                                for="phone"
                                class="block text-md font-medium text-gray-700"
                                >{{ __("เบอร์โทรศัพฑ์") }}</label
                              >
                              <input
                                type="text"
                                name="phone"
                                id="phone"
                                v-model="form.phone"
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
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="mt-4 space-y-4">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                              <label
                                for="email"
                                class="block text-md font-medium text-gray-700"
                                >{{ __("อีเมล์") }}</label
                              >
                              <input
                                type="email"
                                name="email"
                                id="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="appointment-name"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- facebook -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-3 gap-6">
                          <div class="col-span-3 sm:col-span-2">
                            <label
                              for="facebook"
                              class="block text-sm font-medium text-gray-700"
                            >
                              Facebook
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
                              >
                                https://www.facebook.com/
                              </span>
                              <input
                                type="text"
                                name="facebook"
                                id="facebook"
                                v-model="form.facebook"
                                autofocus
                                autocomplete="booking-facebook"
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                placeholder=""
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- line_id -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-3 gap-6">
                          <div class="col-span-3 sm:col-span-2">
                            <label
                              for="line_id"
                              class="block text-sm font-medium text-gray-700"
                            >
                              Line
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
                              >
                                LINE ID
                              </span>
                              <input
                                type="text"
                                name="line_id"
                                id="line_id"
                                v-model="form.line_id"
                                autofocus
                                autocomplete="booking-line_id"
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                placeholder=""
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- เลือกวันนัด -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("เลือกวันนัด") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <div class="grid grid-cols-6 gap-6">
                              <div class="col-span-6 sm:col-span-3">
                                <label
                                  for="date"
                                  class="block text-sm font-medium text-gray-700"
                                  >{{ __("วันนัด") }}</label
                                >
                                <input
                                  type="date"
                                  name="date"
                                  id="date"
                                  v-model="form.date"
                                  required
                                  @change="getDateInfo"
                                  autocomplete="current-date"
                                  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div>
                        <span class="px-4 text-red-400">{{
                          dateInfo.info
                        }}</span>
                      </div>
                      <div>
                        <span class="px-4 text-gray-400"
                          >หากไม่สามารถเลือกรอบนัดหมายได้
                          โปรดเลือกวันนัดใหม่</span
                        >
                      </div>
                      <!-- เลือกรอบนัดหมาย -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("เลือกรอบนัดหมาย") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <div
                              v-for="round in rounds"
                              :key="round.id"
                              class="flex items-center"
                            >
                              <input
                                :id="'r' + round.id"
                                :name="'r' + round.id"
                                :value="round.id"
                                v-model="form.round_id"
                                type="radio"
                                :disabled="dateInfo.isHoliday || round.isFull"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                              />
                              <label
                                :for="'r' + round.id"
                                class="ml-3 block text-sm font-medium text-gray-700"
                              >
                                {{ minuteFormat(round.start) }}
                                -
                                {{ minuteFormat(round.end) }}
                              </label>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <inertia-link
                          :href="route('appointments.index')"
                          class="underline text-sm text-gray-600 hover:text-gray-900 mr-2"
                        >
                          {{ __("ยกเลิก") }}
                        </inertia-link>
                        <button
                          type="submit"
                          :disabled="form.processing"
                          :class="{
                            'opacity-25': form.processing,
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
//import Checkbox from "@/Components/CheckboxV3";
import { mask } from "vue-the-mask";

export default {
  directives: { mask },

  components: {
    BreezeAuthenticatedLayout,
    BreezeValidationErrors,
    FlashMessages,
    //Checkbox,
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
        email: this.$page.props.auth.user.email,
        facebook: "",
        line_id: "",
        // meeting_online: "",
        detail: "",
        date: this.formatDate(new Date()),
        appointment_id: this.appointment.id,
        customer_option_id: null,
        round_id: null,
        user_id: this.$page.props.auth.user.id,
        subjects: [],
        worker: this.appointment.worker,
      }),

      hasRequirePIN:
        this.customerOptions.filter((c) => c.require_pin === 1).length === 0
          ? false
          : true,

      bookingAllDay: [],
      dateInfo: {
        isHoliday: false,
        info: "",
      },
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("bookings.store"));
    },
    minuteFormat(value) {
      let time = value.split(":");
      return time[0] + ":" + time[1];
    },
    getInfoNID() {
      if (this.form.nid == null || this.form.nid.length != 13) {
        $("#nid").focus();
      } else {
        if (this.appointment.pit || this.appointment.cit) {
          axios
            .get("../nid/" + this.form.nid)
            .then((response) => {
              //console.log(response.data);
              this.form.name =
                response.data.lastName === ""
                  ? response.data.firstName
                  : response.data.firstName + " " + response.data.lastName;
              if (
                response.data.sexType === null &&
                response.data.firstName !== ""
              ) {
                this.form.type = 1;
              } else if (
                response.data.firstName !== "" &&
                response.data.lastName !== ""
              ) {
                this.form.type = 0;
              }
            })

            .catch(function (error) {
              console.log(error);
            });
        }
      }
    },
    formatDate(date) {
      var month = date.getMonth() + 1;
      var m = month < 10 ? "0" + month : month;
      var day = date.getDate();
      var d = day < 10 ? "0" + day : day;

      return date.getFullYear() + "-" + m + "-" + d;
    },
    getDateInfo() {
      this.form.round_id = null;
      this.dateInfo.isHoliday = false;
      this.dateInfo.info = "";
      var date = new Date(this.form.date);
      if (date.getDay() === 0 || date.getDay() === 6) {
        this.dateInfo.isHoliday = true;
        this.dateInfo.info = "วันหยุดราชการ";
      } else if (date.getDay() === 1) {
        if (this.appointment.mon) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 2) {
        if (this.appointment.tue) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 3) {
        if (this.appointment.wed) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 4) {
        if (this.appointment.thu) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 5) {
        if (this.appointment.fri) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      }

      axios
        .get("../holiday/" + this.form.date)
        .then((response) => {
          //console.log(response.data);
          if (response.data.length != 0) {
            this.dateInfo.isHoliday = true;
            this.dateInfo.info = response.data[0].detail;
          }
        })

        .catch(function (error) {
          console.log(error);
        });

      if (!this.dateInfo.isHoliday) {
        axios
          .get("../booking/" + this.form.date)
          .then((response) => {
            this.bookingAllDay = response.data;
            this.rounds.forEach((r) => {
              var bookingInRound = this.bookingAllDay.filter(
                (b) => b.round_id === r.id
              );
              if (this.appointment.worker <= bookingInRound.length) {
                r.isFull = true;
              } else {
                r.isFull = false;
              }
            });
          })

          .catch(function (error) {
            console.log(error);
          });
      }
    },
  },

  computed: {},

  mounted() {
    console.log(this.appointment);
    this.getDateInfo();
  },
};
</script>
