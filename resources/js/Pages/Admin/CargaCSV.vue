<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

import Swal from 'sweetalert2'

const form = useForm({
    csv: null,
})

function submit() {
    form.post(route('GuardarCSV'), {
        onFinish: () => {           
                Swal.fire({
                    title: "CSV Cargado!",
                    text: "Los datos se cargadon correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#28eb5c",
                    showDenyButton: false,
                    showCancelButton: false,
                })
        },
    });
}



</script>

<template>

    <Head title="Alta Administrador" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cargar Productos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 flex-col justify-around items-center bg-slate-200 rounded-lg">

                    <form @submit.prevent="submit" class="p-6 flex flex-col gap-4 bg-slate-200 rounded-lg">

                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-100"
                                :class="{
                        'bg-gray-50': form.csv === null,
                        'bg-gray-200': form.csv !== null,
                    }">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Clickea para
                                            subir el CSV
                                        </span> </p>
                                    <p class="text-xs text-gray-500 ">Solo formato CSV
                                    </p>
                                </div>
                                <input id="dropzone-file" type="file"
                                    @input="form.csv = $event.target.files[0], console.log(form.csv)" class="hidden" />
                            </label>
                        </div>
                        <div v-if="form.csv !== null" class="text-2xl">Archivo: {{ form.csv.name }} cargado</div>
                        <InputError class="mt-2" :message="form.errors.name" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                        <PrimaryButton :disabled="form.csv === null" type="submit"
                            class="flex justify-center disabled:bg-gray-300 disabled:text-gray-400 disabled:no-hover">
                            Enviar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
