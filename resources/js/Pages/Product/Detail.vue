<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
const isModalOpen = ref(false);
const props = defineProps({
    products: {
        type: Object,
        default: () => {},
    },
});
const state = reactive({
    formData: {},
});
function updateData() {
    isModalOpen.value = true;
    state.formData = {
        name: props.products.name,
        description: props.products.description,
        price: props.products.price,
        stock: props.products.stock,
    };
}
function submitData() {
    const form = useForm(state.formData);
    form.put(`/admin/product/${props.products.id}`);
    isModalOpen.value = false;
    state.formData = {};
}
</script>
<template>
    <AppLayout title="Detail Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link
                    :href="route('products.index')"
                    class="px-2 py-1 bg-orange-500 text-white font-medium rounded-lg shadow-md hover:bg-blue-600 focus:ring-0"
                >
                    <i class="ri-arrow-left-line"></i>
                </Link>
                {{ products.name }}
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <button
                    class="flex items-center px-4 py-2 bg-orange-500 text-white font-medium rounded-lg shadow-md hover:bg-blue-600 focus:ring-0"
                    @click="updateData"
                >
                    <i class="ri-edit-line me-1 text-xl"></i>
                    Update Data
                </button>
            </div>
            <div
                class="p-3 max-w-auto bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden"
            >
                <div class="py-2">
                    <label for="">Name :</label>
                    {{ products.name }}
                </div>
                <div class="py-2">
                    <label for="">Description :</label>
                    {{ products.description }}
                </div>
                <div class="py-2">
                    <label for="">Price :</label>
                    {{ products.price }}
                </div>
                <div class="py-2">
                    <label for="">Stock :</label>
                    {{ products.stock }}
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
                    <h2 class="text-xl font-semibold mb-4">Update Data</h2>
                    <form @submit.prevent="submitData">
                        <div class="mb-4">
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Name</label
                            >
                            <input
                                id="name"
                                type="text"
                                v-model="state.formData.name"
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
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Price</label
                            >
                            <input
                                type="number"
                                v-model="state.formData.price"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Stock</label
                            >
                            <input
                                type="number"
                                v-model="state.formData.stock"
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
