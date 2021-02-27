<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div x-data="app()" style="display: none;">
                    <div class="justify-center">
                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />
                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf
                            <h3 class="block text-gray-700 font-bold mb-2 text-xl text-center">เพิ่มการนัดหมาย</h3>
                            <!-- First Name -->
                            <div class="mt-2">
                                <x-label for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus />
                            </div>
                            <div class="block">
                                <div class="sm:flex sm:space-x-2 mt-2">
                                    <div class="sm:flex-initia">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" id="pit" name="pit" autofocus
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                {{-- old('pit') ? ' checked' : '' --}} checked>
                                            <span class="ml-2">บุคคลธรรมดา</span>
                                        </label>
                                    </div>
                                    <div class="sm:flex-initia">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" id="cit" name="cit" autofocus
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                {{-- old('cit') ? ' checked' : '' --}} checked>
                                            <span class="ml-2">นิติบุลคล</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <p onclick="showEventModal()">{{ __('เพิ่มประเภทผู้นัด') }}</p>
                                    <button type="button" @click="showEventModal()" class="px-4 py-2 bg-blue-500 text-white rounded">{{ __('เพิ่มประเภทผู้นัด') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal -->
                    <div style=" background-color: rgba(0, 0, 0, 0.8)"
                        class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full"
                        x-show.transition.opacity="openEventModal">
                        <div class="p-4 max-w-xl mx-auto relative left-0 right-0 overflow-hidden mt-24">
                            <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                                x-on:click="openEventModal = !openEventModal">
                                <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                                </svg>
                            </div>

                            <div class="shadow w-full rounded-lg bg-white overflow-hidden block p-8">

                                <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Add Event Details</h2>

                                <div class="mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event
                                        title</label>
                                    <input
                                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                        type="text" x-model="event_title">
                                </div>

                                <div class="mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event
                                        date</label>
                                    <input
                                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                        type="text" x-model="event_date" readonly>
                                </div>

                                <div class="inline-block w-64 mb-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Select a
                                        theme</label>
                                    <div class="relative">
                                        <select @change="event_theme = $event.target.value;" x-model="event_theme"
                                            class="block appearance-none w-full bg-gray-200 border-2 border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-gray-700">
                                            <template x-for="(theme, index) in themes">
                                                <option :value="theme.value" x-text="theme.label"></option>
                                            </template>

                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 text-right">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2"
                                        @click="openEventModal = !openEventModal">
                                        Cancel
                                    </button>
                                    <button type="button"
                                        class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm"
                                        @click="addEvent()">
                                        Save Event
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal -->
                </div>
                <script>
                    function app() {
                        return {
                            openEventModal: false,
                            showEventModal() {
                                // open the modal
                                this.openEventModal = true;
                            }
                        }
                    }

                </script>
            </div>
        </div>
    </div>
</x-app-layout>
