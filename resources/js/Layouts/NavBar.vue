<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    dataPage: {
        type: Array,
        default: () => [],
    },
});
const showMobileMenu = ref(false);
</script>
<template>
    <div class="relative z-100 w-full">
        <nav class="text-white pt-10 w-50 animate-fadeIn">
            <div class="mx-10 flex justify-between items-center">
                <div class="flex items-center">
                    <img
                        src="../../assets/image/logo genah white.png"
                        alt="Genah Logo"
                        class="h-12 w-12"
                    />
                </div>
                <div class="hidden md:flex mr-20 items-center">
                    <div v-for="page in props.dataPage" :key="page">
                        <div v-if="page.title === 'Contact Us'">
                            <Link
                                :href="route(`/${page.route}`)"
                                class="bg-yellow-400 hover:bg-yellow-600 text-black px-10 py-4 rounded-lg"
                            >
                                Contact Us
                            </Link>
                        </div>
                        <div v-else>
                            <!-- :href="route(`dashboard`)" -->
                            <Link
                                :href="page.route"
                                class="hover:border-b px-5 text-black"
                            >
                                {{ page.title }}
                            </Link>
                        </div>
                    </div>

                    <!-- <a
                        href="#"
                        class="bg-yellow-400 hover:bg-yellow-600 text-black px-4 py-2 rounded"
                    >
                        Contact Us
                    </a>
                    <a
                        href="#"
                        class="block hover:border-b text-black uppercase"
                    >
                        <i class="ri-global-line"></i>
                        In</a
                    >  -->
                </div>
                <div class="md:hidden flex items-center">
                    <button
                        class="text-green-900 hover:text-yellow-500 focus:outline-none"
                        @click="showMobileMenu = !showMobileMenu"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                </div>
            </div>
            <div
                v-if="showMobileMenu"
                class="md:hidden bg-green-800 text-center py-2 px-4 space-y-2 absolute w-full z-100"
            >
                <a href="#" class="block hover:text-yellow-500">Home</a>
                <a href="#" class="block hover:text-yellow-500">About Us</a>
                <a href="#" class="block hover:text-yellow-500"
                    >Life at Genah</a
                >
                <a href="#" class="block hover:text-yellow-500">Career</a>
                <a href="#" class="block hover:text-yellow-500"
                    >Our Innovation</a
                >
                <a href="#" class="block hover:text-yellow-500"
                    >Social Activity</a
                >
                <a href="#" class="block hover:text-yellow-500">Galery</a>
                <a href="#" class="block hover:text-yellow-500">Blog</a>
                <a
                    href="#"
                    class="block bg-yellow-500 hover:bg-yellow-600 text-green-900 px-4 py-2 rounded"
                >
                    Contact Us
                </a>
                <a href="#" class="block hover:text-yellow-500">
                    <i class="ri-global-line"></i>
                    In</a
                >
            </div>
        </nav>
    </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
* {
    font-family: "Poppins", sans-serif;
    font-size: 14px;
    font-weight: 400;
}
</style>
