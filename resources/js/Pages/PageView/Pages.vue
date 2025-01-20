<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DatatableClient from "@/Components/Datatable/DatatableClient.vue";
import { reactive, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
    pages: {
        type: Array,
        default: () => [],
    },
});
const state = reactive({
    formData: {},
    columns: [
        {
            width: "8%",
            name: "id",
            label: "ID",
        },
        {
            width: "25%",
            name: "title",
            label: "Title",
            class: "text-orange-600 hover:text-blue-600",
            custom: {
                icon: "ri-instance-line text-sm text-blue-600",
                routeName: "pages.show",
                routeParam: "id",
            },
        },
        {
            width: "25%",
            name: "route",
            label: "Route",
        },
        {
            width: "25%",
            name: "description",
            label: "Description",
        },
        {
            name: "created_at",
            label: "Created",
            isDate: true,
        },
        {
            name: "updated_at",
            label: "Updated",
            isDateTime: true,
        },
    ],
});
const isModalOpen = ref(false);

function addData() {
    isModalOpen.value = true;
    state.formData = {};
}
function submitData() {
    const form = useForm(state.formData);
    form.post("/admin/pages");
    isModalOpen.value = false;
    state.formData = {};
    Swal.fire("success", "The data has been added successfully!", "success");
}
</script>
<template>
    <AppLayout title="Pages">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pages
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <button
                        class="flex items-center px-4 py-2 bg-blue-500 text-white font-medium rounded-lg shadow-md hover:bg-blue-600 focus:ring-0"
                        @click="addData"
                    >
                        <i class="ri-add-circle-line me-1 text-xl"></i>
                        Add Data
                    </button>
                </div>
                <div
                    class="p-3 max-w-auto bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden"
                >
                    <DatatableClient
                        :dataTable="pages"
                        :column="state.columns"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
    <transition name="fade">
        <div
            v-if="isModalOpen"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
            <transition name="slide-up">
                <div
                    v-if="isModalOpen"
                    class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md transform transition-all duration-300"
                >
                    <h2 class="text-xl font-semibold mb-4">Add Data</h2>
                    <form @submit.prevent="submitData">
                        <div class="mb-4">
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700"
                                >Title</label
                            >
                            <input
                                id="title"
                                type="text"
                                v-model="state.formData.title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700"
                                >Route</label
                            >
                            <input
                                id="title"
                                type="text"
                                v-model="state.formData.route"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Description</label
                            >
                            <input
                                type="text"
                                v-model="state.formData.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button
                                type="button"
                                @click="isModalOpen = !isModalOpen"
                                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </transition>
        </div>
    </transition>
</template>
