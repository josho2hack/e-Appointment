<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link :href="route('bookings.index')"
          >{{ __("รายการจอง") }}
        </inertia-link>
        > {{ __("รายละเอียด") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Start Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
              <div class="px-4 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                  {{ appointment.name }}
                </h3>
              </div>
              <div class="border-t border-gray-200">
                <dl>
                  <!-- หมายเลขผู้เสียภาษี -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      หมายเลขผู้เสียภาษี
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.nid }}
                    </dd>
                  </div>
                  <!-- ประเภทผู้นัดหมาย -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      ประเภทผู้นัดหมาย
                    </dt>
                    <dd
                      v-if="type == 0"
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      บุคคลธรรมดา
                    </dd>
                    <dd
                      v-if="type == 1"
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      นิติบุลคล
                    </dd>
                    <dd
                      v-else
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ customer }}
                    </dd>
                  </div>
                  <!-- ชื่อผู้นัดหมาย -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      ชื่อผู้นัดหมาย
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.name }}
                    </dd>
                  </div>
                  <!-- เรื่องที่เกี่ยวข้อง -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      เรื่องที่เกี่ยวข้อง
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      <ul>
                          <li v-for="subject in subjects" :key="subject.id">{{ subject.name }}</li>
                      </ul>
                    </dd>
                  </div>
                  <!-- รายละเอียดคำถาม -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      รายละเอียดคำถาม
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.detail }}
                    </dd>
                  </div>
                  <!-- เบอร์โทรศัพฑ์ -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      เบอร์โทรศัพฑ์
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.phone }}
                    </dd>
                  </div>
                  <!-- อีเมล์ -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">อีเมล์</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.email }}
                    </dd>
                  </div>
                  <!-- facebook -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">FACEBOOK</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.facebook }}
                    </dd>
                  </div>
                  <!-- line_id -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">LINE ID</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.line_id }}
                    </dd>
                  </div>
                  <!-- วันนัด -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">วันนัด</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ booking.date }}
                    </dd>
                  </div>
                  <!-- รอบนัดหมาย -->
                  <div
                    class="px-4 py-2 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">รอบ</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ minuteFormat(round.start) }}
                      -
                      {{ minuteFormat(round.end) }}
                    </dd>
                  </div>
                  <!-- เจ้าหน้าที่ -->
                  <div
                    class="px-4 py-2 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                  >
                    <dt class="text-sm font-medium text-gray-500">
                      เจ้าหน้าที่
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ worker }}
                    </dd>
                  </div>
                </dl>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <inertia-link
                  :href="route('bookings.index')"
                  class="underline text-sm text-gray-600 hover:text-gray-900 mr-2"
                >
                  {{ __("กลับรายการจอง") }}
                </inertia-link>
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

export default {
  components: {
    BreezeAuthenticatedLayout,
  },

  props: {
    appointment: Object,
    round: Object,
    subjects: Object,
    customerOption: Object,
    employee: Object,
    booking: Object,
  },

  data() {
    return {
      customer: this.customerOption == null ? "" : this.customerOption.name,
      worker:
        this.employee == null
          ? ""
          : this.employee.first_name + " " + this.employee.last_name,
    };
  },

  methods: {
    minuteFormat(value) {
      let time = value.split(":");
      return time[0] + ":" + time[1];
    },
  },

  computed: {},

  mounted() {
    //console.log(this.subjects);
  },
};
</script>
