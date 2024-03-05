<script setup>
import ThePaginator from '@/Components/ThePaginator.vue';
import { router, usePage, Link, useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';


let props = defineProps({
    users: Array,
    links: Array,
})


</script>

<template>
    <div class=" flex items-center justify-center flex-col">
        <ul role="list" class="divide-y divide-gray-100 p-6 w-4/5 mx-32 gap-6">

            <div class="flex justify-between items-center py-5 px-3 bg-slate-300">
                <div class="text-xl font-bold leading-6 text-gray-900">Nombre Provedor</div>
                <div class="text-xl font-bold leading-6 text-gray-900">Descuento Aplicado</div>
            </div>
            <li v-for="user in users" :key="user._id"
                class="flex justify-between items-center   gap-x-6 py-5 px-3 bg-slate-100 rounded-lg m-2">

                <div class="flex justify-between items-center w-full ">
                    <div class="text-xl font-bold leading-6 text-gray-900">{{ user.name }}</div>
                    <div class="text-xl font-bold leading-6 text-gray-900">{{ user.Descuento }}</div>
                </div>

            </li>

        </ul>
        <ThePaginator :links="links" />
    </div>
</template>
