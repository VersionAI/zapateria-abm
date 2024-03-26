<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import ThePaginator from "@/Components/ThePaginator.vue";
import { ref, watch, computed } from "vue";
import { debounce } from "lodash";

const user = usePage().props.auth.user;
let props = defineProps({
  productos: Array,
  search: String,
  categorias: Array,
});
let search = ref(props.search);
const selectedCategory = ref("");

const precioDiscount = (precio) => {
  if (user.Descuento > 0) {
    let result = precio - (precio * user.Descuento) / 100;
    return result.toFixed(2);
  }

  return item.precio;
};

watch(
  search,
  debounce((value) => {
    router.get(
      route("dashboard"),
      { search: value },
      {
        preserveState: true,
        replace: true,
        preserveScroll: true,
      }
    );
  })
);

watch(
  selectedCategory,
  debounce((value) => {
    router.get(
      route("dashboard"),
      { selectedCategory: value },
      {
        preserveState: true,
        replace: true,
        preserveScroll: true,
      }
    );
  })
);
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 leading-tight flex justify-between"
      >
        Productos
        <div :v-if="user.Descuento > 0">
          Tenes un descuento del {{ user.Descuento }} % !
        </div>
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="overflow-hidden flex flex-col justify-center items-center p-2"
        >
          <div class="flex justify-center mt-4 p-4 rounded-lg gap-2">
            <input
              type="text"
              name="search"
              placeholder="Buscar producto..."
              class="w-96 rounded-lg"
              v-model="search"
            />

            <select
              id="categorySelect"
              v-model="selectedCategory"
              class="rounded-lg"
              @change="filterProducts"
            >
              <option value="">Todas las categorías</option>
              <option
                v-for="category in categorias"
                :key="category"
                :value="category"
              >
                {{ category }}
              </option>
            </select>
          </div>
          <div
            class="p-6 text-gray-900 flex flex-col md:grid md:grid-cols-2 lg:grid-cols-3 gap-4"
            v-if="productos.data.length"
          >
            <div
              v-for="producto in productos.data"
              class="max-w-sm bg-white border flex flex-col justify-center items-center border-gray-200 rounded-lg shadow"
              :key="producto._id"
            >
              <a href="#">
                <img
                  class="p-8 rounded-t-lg"
                  width="100%"
                  :src="producto.Imagen"
                  alt="product image"
                />
              </a>
              <div class="px-6 pb-5 flex flex-col gap-2 w-full">
                <a href="#">
                  <h5
                    class="text-xl font-semibold tracking-tight flex gap-2 text-gray-900 text-center"
                  >
                    Artículo: {{ producto.Articulo }}
                  </h5>
                  <h5
                    class="text-xl font-semibold tracking-tight flex gap-2 text-gray-900"
                  >
                    <span
                      class="bg-yellow-400 text-black text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-500 dark:text-yellow-900"
                      >{{ producto.Categoria }}</span
                    >
                  </h5>
                  <h6>
                    <span
                      class="bg-yellow-400 text-black text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-500 dark:text-yellow-900"
                      >Color: {{ producto.Color }}</span
                    >
                  </h6>
                  <p>Obs: {{ producto.OBS }}</p>
                </a>
                <div class="flex items-center justify-between">
                  <div class="text-3xl font-bold text-gray-900">
                    <div v-if="user.Descuento > 0">
                      <div>${{ precioDiscount(producto.Precio) }}</div>
                      <div class="line-through">${{ producto.Precio }}</div>
                    </div>
                    <div v-else>${{ producto.Precio }}</div>
                  </div>
                  <!-- <button href="#"
                                        class="text-white flex gap-2 justify-center items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                                        </svg>
                                        <div> Agregar</div>
                                    </button> -->
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
