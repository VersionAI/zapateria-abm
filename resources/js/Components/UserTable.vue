<script setup>
import ThePaginator from "@/Components/ThePaginator.vue";
import { router, usePage, Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { debounce } from "lodash";
import { ref, watch, computed } from "vue";

const form = useForm({
  descuento: "",
});

function setDiscount(user) {
  Swal.fire({
    title: `Ingresa el descuento asignable a ${user.name}`,
    input: "text",
    inputAttributes: {
      autocapitalize: "off",
    },
    showCancelButton: true,
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
    showLoaderOnConfirm: true,
    preConfirm: async (discount) => {
      try {
        form.descuento = discount;
        user.descuento = discount;
        form.put(route("ModificarDescuento", { id: user._id }));
      } catch (error) {
        Swal.showValidationMessage(`
        Request failed: ${error}
      `);
      }
    },
    allowOutsideClick: () => !Swal.isLoading(),
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Listo!",
        text: "Los datos se cargadon correctamente",
        icon: "success",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#28eb5c",
        showDenyButton: false,
        showCancelButton: false,
      });
    }
  });
}

let props = defineProps({
  users: Array,
  links: Array,
  query: String,
});

let search = ref(props.query);
watch(
  search,
  debounce((value) => {
    router.get(
      route("ListarProvedores"),
      { search: value },
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
  <div class="flex items-center justify-center flex-col">
    <div class="flex justify-center mt-4 p-4 w-full gap-2">
      <input
        type="text"
        name="search"
        placeholder="Buscar..."
        class="w-80"
        v-model="search"
      />
    </div>
    <ul
      role="list"
      class="divide-y divide-gray-100 px-2 py-4 md:px-4 md:py-4 lg:px-6 lg:py-6 w-4/5 mx-32 gap-6"
    >
      <div
        class="flex justify-between items-center text-lg sm:text-xl md:text-2xl px-2 py-4 md:px-4 md:py-4 lg:px-6 lg:py-6 bg-slate-300"
      >
        <div class="font-bold leading-6 text-gray-900">Nombre Cliente</div>
        <div class="font-bold leading-6 text-gray-900">Descuento</div>
        <div class="font-bold leading-6 text-gray-900">Acción</div>
      </div>
      <li
        v-for="user in users"
        :key="user._id"
        class="flex justify-between items-center gap-x-6 px-2 py-4 md:px-4 md:py-4 lg:px-6 lg:py-6 bg-slate-100 rounded-lg m-2"
      >
        <div class="flex justify-between items-center w-full">
          <div class="text-xl font-bold leading-6 text-gray-900">
            {{ user.name }}
          </div>
          <div class="text-xl font-bold leading-6 text-gray-900">
            {{ user.Descuento }} %
          </div>
          <div>
            <button
              @click="setDiscount(user)"
              class="bg-yellow-400 text-white font-bold py-2 px-4 rounded hover:bg-yellow-500 focus:outline-none focus:shadow-outline transform active:scale-95 transition duration-150 ease-in-out"
            >
              Setear Descuento
            </button>
          </div>
        </div>
      </li>
    </ul>
    <ThePaginator :links="links" />
  </div>
</template>
