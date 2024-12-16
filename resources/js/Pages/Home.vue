<script setup>
import NavBar from "@/Layouts/NavBar.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    product: {
        type: Array,
        default: () => [],
    },
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome" />
    <NavBar />
    <img
        id="background"
        src="../../assets/image/background.png"
        class="absolute-left-20 top-0 max-w-auto z-99"
    />
    <div class="absolute-left-20 top-0 max-w-auto z-99">
        {{ product[0].name }}
    </div>
    <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#69c4db] selection:text-white"
    >
        <div class="m-5 p-5">
            <main class="mt-6">
                <h1 class="text-9xl">
                    {{ product[0].name }}
                </h1>
            </main>
        </div>
    </div>
</template>
