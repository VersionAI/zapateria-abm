<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import UserTable from '@/Components/UserTable.vue';



const page = usePage()
const { provedores } = defineProps({ provedores: Array, search: String })






</script>

<template>
    <Head title="Alta Administrador" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista Clientes</h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-1 sm:p-2 lg:p-4 text-gray-900">
                        <UserTable :users="provedores.data" :links="provedores.links" :query="search" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
