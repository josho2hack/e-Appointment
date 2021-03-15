<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link :href="route('bookings.index')"
          >{{ __("รายการจอง") }}
        </inertia-link>
        > {{ __("ปรับปรุงการจอง") }}
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
                      {{ __("ปรับปรุงการจอง") }}
                      {{ appointment.name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                      {{
                        __("มอบหมายงาน หรือปรับปรุงสถานะการจองเมื่อแล้วเสร็จ")
                      }}
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
                                disabled
                                type="text"
                                name="nid"
                                id="nid"
                                :value="booking.nid"
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
                              v-if="booking.type == 0"
                              class="flex items-start"
                            >
                              <div class="flex items-center h-5">
                                <input
                                  type="checkbox"
                                  name="pit"
                                  value="0"
                                  checked="checked"
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
                              v-if="booking.type == 1"
                              class="flex items-start"
                            >
                              <div class="flex items-center h-5">
                                <input
                                  type="checkbox"
                                  name="cit"
                                  value="1"
                                  checked="checked"
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
                              v-if="customerOption"
                              class="flex items-center"
                            >
                              <input
                                :name="'c' + customerOption.id"
                                type="checkbox"
                                checked="checked"
                                disabled
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                              />
                              <label
                                :for="'c' + customerOption.id"
                                class="ml-3 block text-sm font-medium text-gray-700"
                              >
                                {{ customerOption.name }}
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
                                disabled
                                type="text"
                                name="name"
                                id="name"
                                :value="booking.name"
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
                                  disabled
                                  type="checkbox"
                                  checked="checked"
                                  :name="'s' + item.id"
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
                                disabled
                                name="detail"
                                id="detail"
                                :value="booking.detail"
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
                                :value="booking.phone"
                                disabled
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
                                :value="booking.email"
                                disabled
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
                                :value="booking.facebook"
                                disabled
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
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
                                :value="booking.line_id"
                                disabled
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- วันนัด -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("วันนัดหมาย") }}
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
                                  :value="booking.date"
                                  disabled
                                  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <!-- รอบนัดหมาย -->
                      <div class="px-4 pb-4 bg-white space-y-6 sm:p-6">
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("รอบนัดหมาย") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                              <input
                                :id="'r' + round.id"
                                :name="'r' + round.id"
                                type="checkbox"
                                checked="checked"
                                disabled
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
                      <!-- มอบหมายงาน -->
                      <div
                        v-if="
                          booking.status !== 1 &&
                          (($page.props.auth.user.level <= 3 &&
                            office.code.substr(5, 3) == '000') ||
                            ($page.props.auth.user.level <= 2 &&
                              office.code.substr(5, 3) != '000'))
                        "
                        class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                      >
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("มอบหมายงาน") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <label
                              for="employee"
                              class="block text-sm font-medium text-gray-700"
                              >{{ __("มอบหมายให้") }}</label
                            >
                            <select
                              id="employee"
                              name="employee"
                              v-model="lsk"
                              @change="selectWorker"
                              autofocus
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                              <option
                                v-for="emp in employees"
                                :key="emp.ID"
                                :value="emp.ID"
                                :disabled="emp.isFull"
                              >
                                {{ emp.FNAME + " " + emp.LNAME }}
                              </option>
                            </select>
                          </div>
                        </fieldset>
                      </div>
                      <!-- ลิงค์ประชุมออนไลน์ (meeting_online) -->
                      <div
                        v-if="booking.status !== 1"
                        class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                      >
                        <div class="grid grid-cols-3 gap-6">
                          <div class="col-span-3 sm:col-span-2">
                            <label
                              for="meeting_online"
                              class="block text-sm font-medium text-gray-700"
                            >
                              ลิงค์ประชุมออนไลน์
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input
                                type="text"
                                name="meeting_online"
                                id="meeting_online"
                                v-model="form.meeting_online"
                                autofocus
                                autocomplete="meeting_online"
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- สถานะ -->
                      <div
                        v-if="employee !== null && booking.status === 0"
                        class="px-4 pb-4 bg-white space-y-6 sm:p-6"
                      >
                        <fieldset>
                          <legend class="text-base font-medium text-gray-900">
                            {{ __("สถานะ") }}
                          </legend>
                          <div class="mt-4 space-y-4">
                            <label
                              for="status"
                              class="block text-sm font-medium text-gray-700"
                              >{{ __("สถานะการนัดหมาย") }}</label
                            >
                            <select
                              id="status"
                              name="status"
                              v-model="form.status"
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                              <option value="0" selected>กำลังดำเนินการ</option>
                              <option value="1">เสร็จสิ้น</option>
                            </select>
                          </div>
                        </fieldset>
                      </div>

                      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <inertia-link
                          :href="route('bookings.index')"
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

export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeValidationErrors,
    FlashMessages,
    //Checkbox,
  },

  props: {
    appointment: Object,
    round: Object,
    subjects: Object,
    customerOption: Object,
    employee: Object,
    employees: Object,
    booking: Object,
    office: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        meeting_online: this.booking.meeting_online,
        status: this.booking.status,
        employee: {},
        lsk_old: this.employee ? this.employee.lsk : null,
        meeting_old: this.booking.meeting_online,
      }),

      lsk: this.employee ? this.employee.lsk : null,
    };
  },

  methods: {
    submit() {
      this.form.put(this.route("bookings.update", this.booking.id));
    },
    minuteFormat(value) {
      let time = value.split(":");
      return time[0] + ":" + time[1];
    },
    selectWorker() {
      for (var emp in this.employees) {
        if (emp.ID === lsk) {
          this.form.employee.lsk = emp.ID;
          this.form.employee.title = emp.TITLE;
          this.form.employee.first_name = emp.FNAME;
          this.form.employee.last_name = emp.LNAME;
          this.form.employee.pin = emp.PIN;
          this.form.employee.email = emp.EMAIL;
          this.form.employee.uid = emp.UID;
          this.form.employee.position = emp.POSITION_M;
          this.form.employee.class = emp.CLASS_NEW;
          this.form.employee.position_action = emp.POSACT;
          this.form.employee.groupname = emp.GROUPNAME;
          this.form.employee.level = emp.LEVEL;
          this.form.employee.employee_type = emp.EMPTYPE;
          this.form.employee.office_id = this.office.id;
        }
      }
      console.log(this.form);
    },
  },

  computed: {},

  mounted() {
    //console.log(this.$page.props.auth.user);
    //console.log(this.office.code);

    axios
      .get("../../booking/" + this.booking.date)
      .then((response) => {
        this.bookingAllDay = response.data;
        for (var emp in this.employees) {
          var bookingInEmployee = this.bookingAllDay.filter(
            (b) => {b.employee.lsk ? b.employee.lsk == emp.ID : null}
          );
          if (bookingInEmployee.length !== 0) {
            emp.isFull = true;
          } else {
            emp.isFull = false;
          }
        }
      })

      .catch(function (error) {
        console.log(error);
      });

    console.log(this.employees);
  },
};
</script>
