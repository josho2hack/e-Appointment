<template>
    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <breeze-label for="first_name" :value="__('First Name')" />
            <breeze-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus autocomplete="first_name" />
        </div>

        <div class="mt-4">
            <breeze-label for="last_name" :value="__('Last Name')" />
            <breeze-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required autofocus autocomplete="last_name" />
        </div>

        <div class="mt-4">
            <breeze-label for="phone" :value="__('Phone')" />
            <breeze-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required autofocus autocomplete="phone" />
        </div>

        <div class="mt-4">
            <breeze-label for="email" :value="__('Email')" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
        </div>

        <div class="mt-4">
            <breeze-label for="password" :value="__('Password')" />
            <breeze-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <breeze-label for="password_confirmation" :value="__('Confirm Password')" />
            <breeze-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Already registered or Google, Facebook?') }}
            </inertia-link>

            <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('Register') }}
            </breeze-button>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeCheckbox from "@/Components/Checkbox";
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeInput from '@/Components/Input'
    import BreezeLabel from '@/Components/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeCheckbox,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
        },

        data() {
            return {
                form: this.$inertia.form({
                    first_name: '',
                    last_name: '',
                    phone: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
