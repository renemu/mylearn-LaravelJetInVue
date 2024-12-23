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
    <Head title="Home PT. Gawe Becik Nadhah Anugrah" />
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
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
html,
body {
    font-family: "Roboto", sans-serif;
}

#app {
    font-family: "Roboto", sans-serif;
}
</style>
