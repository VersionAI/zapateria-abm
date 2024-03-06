<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ThePaginator from '@/Components/ThePaginator.vue';

let props = defineProps({ productos: Array });
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bienvenido!</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class=" overflow-hidden flex flex-col justify-center items-center p-2">
                    <div class="p-6 text-gray-900 flex flex-col  md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 " v-if="productos.data.length">
                        <div  v-for="producto in productos.data"
                            class=" max-w-sm bg-white border flex flex-col justify-center items-center border-gray-200 rounded-lg shadow">
                            <a href="#">
                                <img class="p-8 rounded-t-lg" width="100%" :src="producto.Imagen" alt="product image" />
                            </a>
                            <div class="px-6 pb-5 flex flex-col gap-2 w-full">
                                <a href="#">
                                    <h5
                                        class="text-xl font-semibold tracking-tight flex gap-2 text-gray-900">
                                        {{ producto.Categoria }}
                                        {{ producto.OBS }}
                                        {{ producto.Color }}

                                    </h5>
                                </a>
                                <div class="flex items-center justify-between">
                                    <div class="text-3xl font-bold text-gray-900">
                                        <div> $ {{ producto.Precio }}</div>
                                        
                                    </div>
                                    <button href="#"
                                        class="text-white flex gap-2 justify-center items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                                        </svg>
                                        <div> Agregar</div>


                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <ThePaginator :links="productos.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
