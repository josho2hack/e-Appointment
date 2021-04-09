<template>
  <div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
  >
    <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
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

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
        <img class="rd-logo" src="/assets/images/e-appointment.png" />
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
                  d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z"
                />
              </svg>
              <div class="ml-4 text-lg leading-7 font-semibold">
                <inertia-link :href="route('index')"
                  >{{ __("Appointment") }}
                </inertia-link>
                > {{ __("จองนัดหมาย") }}
              </div>
            </div>

            <div class="ml-0">
              <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <!-- Content-->
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
                              appointment.pit ||
                              appointment.cit ||
                              hasRequirePIN
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
                              <legend
                                class="text-base font-medium text-gray-900"
                              >
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
                              <legend
                                class="text-base font-medium text-gray-900"
                              >
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
                                  for="company_website"
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
                                  for="company_website"
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
                              <legend
                                class="text-base font-medium text-gray-900"
                              >
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
                              <legend
                                class="text-base font-medium text-gray-900"
                              >
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
                                    :disabled="
                                      dateInfo.isHoliday || round.isFull
                                    "
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
                              :href="route('index')"
                              class="underline text-sm text-gray-600 hover:text-gray-900 mr-2"
                            >
                              {{ __("ยกเลิก") }}
                            </inertia-link>
                            <button
                              @click="openModal"
                              type="button"
                              :disabled="form.processing"
                              :class="{
                                'opacity-25': form.processing,
                              }"
                              class="inline-flex justify-center py-2 px-2 mr-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                              {{ __("ตรวจสอบ") }}
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <booking-modal
                  v-if="openBookingModal"
                  :nid="form.nid"
                  :name="form.name"
                  :type="form.type"
                  :phone="form.phone"
                  :email="form.email"
                  :facebook="form.facebook"
                  :line_id="form.line_id"
                  :detail="form.detail"
                  :date="form.date"
                  :appointment="appointment.name"
                  :round="roundInfo"
                  :subject="subject"
                  :customer="customerInfo"
                  @close="openBookingModal = false"
                  @submit="submit"
                />
                <!-- End Content -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
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
                      ด้านสิทธิประโยชน์ทางภาษี : โทร. 02-2728289, 02-2728400,
                      02-2729168, 02-2729819<br />ด้านระบบงาน : โทร.
                      02-272-8804, 02-272-8743
                    </p>
                  </div>
                  <!-- Footer Address -->
                  <hr />
                  <div class="col-lg-12 text-center">
                    <h5>กรมสรรพากร</h5>
                    <p>
                      90 ซอยพหลโยธิน 7 ถนนพหลโยธิน แขวงพญาไท เขตพญาไท กรุงเทพฯ
                      10400
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
import BreezeValidationErrors from "@/Components/ValidationErrors";
import FlashMessages from "@/Components/FlashMessages";
import BookingModal from "@/Components/BookingModal";

export default {
  components: {
    LanguageSelector,
    BreezeValidationErrors,
    FlashMessages,
    BookingModal,
  },
  props: {
    canLogin: Boolean,
    canLoginEmployee: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
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
        // meeting_online: "",
        detail: "",
        date: this.formatDate(new Date()),
        appointment_id: this.appointment.id,
        customer_option_id: null,
        round_id: null,
        user_id: null,
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
      openBookingModal: false,
      roundInfo: "",
      subject: "",
      customerInfo: "",
    };
  },
  watch: {},
  methods: {
    submit() {
      this.openBookingModal = false;
      this.form.post(this.route("guest.store"));
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
                response.data.lastName === null
                  ? response.data.firstName
                  : response.data.firstName + " " + response.data.lastName;
              if (
                response.data.sexType === null &&
                response.data.firstName !== null
              ) {
                this.form.type = 1;
              } else if (
                response.data.firstName !== null &&
                response.data.lastName !== null
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
      if (date < new Date()) {
        this.dateInfo.isHoliday = true;
        this.dateInfo.info = "เลือกวันนัดหมายไม่ถูกต้อง";
      } else if (date.getDay() === 0 || date.getDay() === 6) {
        this.dateInfo.isHoliday = true;
        this.dateInfo.info = "วันหยุดราชการ";
      } else if (date.getDay() === 1) {
        if (!this.appointment.mon) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 2) {
        if (!this.appointment.tue) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 3) {
        if (!this.appointment.wed) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 4) {
        if (!this.appointment.thu) {
          this.dateInfo.isHoliday = true;
          this.dateInfo.info = "หยุดให้บริการ";
        }
      } else if (date.getDay() === 5) {
        if (!this.appointment.fri) {
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
    openModal() {
      if (this.form.customer_option_id) {
        let customer = this.customerOptions.filter(
          (c) => c.id == this.form.customer_option_id
        );
        //console.log(rseclect[0].start);
        this.customerInfo = customer.name;
      }
      if (this.form.round_id) {
        let rseclect = this.rounds.filter((r) => r.id == this.form.round_id);
        //console.log(rseclect[0].start);
        this.roundInfo =
          this.minuteFormat(rseclect[0].start) +
          " - " +
          this.minuteFormat(rseclect[0].end);
      }
      if (this.form.subjects.length != 0) {
        let sseclect = this.subjects.filter(
          (s) => s.id == this.form.subjects[0]
        );
        this.subject = sseclect[0].name;
      }
      this.openBookingModal = true;
    },
  },
  mounted() {
    //console.log(this.subjects);
    this.getDateInfo();
  },
};
</script>
