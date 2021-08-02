<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')">
                                    <breeze-application-logo
                                        class="block h-14 w-auto"
                                    />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                            >
                                <breeze-nav-link
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    {{ __("Dashboard") }}
                                </breeze-nav-link>

                                <breeze-nav-link
                                    :href="route('appointments.index')"
                                    :active="
                                        route().current('appointments.index')
                                    "
                                >
                                    {{ __("Appointment") }}
                                </breeze-nav-link>

                                <breeze-nav-link
                                    :href="route('bookings.index')"
                                    :active="route().current('bookings.index')"
                                >
                                    {{ __("Booking List") }}
                                </breeze-nav-link>

                                <breeze-nav-link v-if="$page.props.auth.user.level < 4"
                                    :href="route('booking.assignment')"
                                    :active="route().current('booking.assignment')"
                                >
                                    {{ __("งานที่ได้รับมอบหมาย") }}
                                </breeze-nav-link>

                                <breeze-nav-link
                                    v-if="$page.props.auth.user.role_id < 3"
                                    :href="route('report')"
                                    :active="route().current('report')"
                                >
                                    {{ __("Report") }}
                                </breeze-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <img
                                v-if="$page.props.auth.user.avatar"
                                class="w-8 h-8 mr-2 rounded-full border border-gray-400"
                                :src="$page.props.auth.user.avatar"
                                alt="{{ $page.props.auth.user.first_name }}
                                    {{ $page.props.auth.user.last_name }}"
                            />
                            <svg
                                v-else
                                class="h-8 w-8 rounded-full border fill-current text-gray-400 mr-2"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <breeze-dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{
                                                    $page.props.auth.user
                                                        .first_name
                                                }}
                                                {{
                                                    $page.props.auth.user
                                                        .last_name
                                                }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <breeze-dropdown-link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            {{ __("Logout") }}
                                        </breeze-dropdown-link>
                                    </template>
                                </breeze-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown = !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <breeze-responsive-nav-link
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            {{ __("Dashboard") }}
                        </breeze-responsive-nav-link>
                        <breeze-responsive-nav-link
                            :href="route('appointments.index')"
                            :active="route().current('appointments.index')"
                        >
                            {{ __("Appointment") }}
                        </breeze-responsive-nav-link>
                        <breeze-responsive-nav-link
                            :href="route('bookings.index')"
                            :active="route().current('bookings.index')"
                        >
                            {{ __("Booking List") }}
                        </breeze-responsive-nav-link>
                        <breeze-responsive-nav-link v-if="$page.props.auth.user.level < 4"
                            :href="route('booking.assignment')"
                            :active="route().current('booking.assignment')"
                        >
                            {{ __("งานที่ได้รับมอบหมาย") }}
                        </breeze-responsive-nav-link>
                        <breeze-responsive-nav-link
                            v-if="$page.props.auth.user.role_id < 3"
                            :href="route('report')"
                            :active="route().current('report')"
                        >
                            {{ __("Report") }}
                        </breeze-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <img
                                    v-if="$page.props.auth.user.avatar"
                                    class="w-10 h-10 rounded-full border border-gray-400"
                                    :src="$page.props.auth.user.avatar"
                                    alt="{{ $page.props.auth.user.first_name }}
                                    {{ $page.props.auth.user.last_name }}"
                                />
                                <svg
                                    v-else
                                    class="h-8 w-8 rounded-full border fill-current text-gray-400 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div
                                    class="font-medium text-base text-gray-800"
                                >
                                    {{ $page.props.auth.user.first_name }}
                                    {{ $page.props.auth.user.last_name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <breeze-responsive-nav-link
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                {{ __("Logout") }}
                            </breeze-responsive-nav-link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Footer Content -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    <div class="flex justify-between sm:items-center">
                        <div
                            class="text-center text-sm text-gray-500 sm:text-left"
                        >
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
                    <footer class="py-5">
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
                                        ด้านสิทธิประโยชน์ทางภาษี : โทร.
                                        02-2728289, 02-2728400, 02-2729168,
                                        02-2729819<br />ด้านระบบงาน : โทร.
                                        02-272-8804, 02-272-8743
                                    </p>
                                </div>
                                <!-- Footer Address -->
                                <hr />
                                <div class="col-lg-12 text-center">
                                    <h5>กรมสรรพากร</h5>
                                    <p>
                                        90 ซอยพหลโยธิน 7 ถนนพหลโยธิน แขวงพญาไท
                                        เขตพญาไท กรุงเทพฯ 10400
                                    </p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import BreezeNavLink from "@/Components/NavLink";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink";
import LanguageSelector from "@/Language/LanguageSelector";

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        LanguageSelector,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
};
</script>
