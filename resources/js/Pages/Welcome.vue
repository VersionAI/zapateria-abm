<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayoutVue from '@/Layouts/GuestLayout.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Bienvenido" />
    <GuestLayoutVue>
        
            <div v-if="canLogin" class="text-3xl p-4 ">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="font-semibold text-gray-900 hover:text-slate-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Bienvenido de vuelta {{ $page.props.auth.user.name }} </Link>

                <template v-else>
                    <Link :href="route('login')"
                        class="font-semibold text-gray-900 hover:text-slate-400 0 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Iniciar Sesión</Link>

                    <Link v-if="canRegister" :href="route('register')"
                        class="ms-4 font-semibold text-gray-900 hover:text-slate-400  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Registrarse</Link>
                </template>
            </div>

            
    </GuestLayoutVue>
</template>

