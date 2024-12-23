<script setup>
import { ref } from "vue";

const showMobileMenu = ref(false);
</script>
<template>
    <div class="absolute z-100 w-full">
        <nav class="bg-0 text-white py-4 w-50">
            <div class="mx-10 flex justify-between items-center">
                <div class="flex items-center">
                    <img
                        src="../../assets/image/logo genah white.png"
                        alt="Genah Logo"
                        class="h-12"
                    />
                </div>
                <div class="hidden md:flex space-x-10 items-center">
                    <a href="#" class="hover:border-b">Home</a>
                    <a href="#" class="hover:border-b">About Us</a>
                    <a href="#" class="hover:border-b text-black"
                        >Life at Genah</a
                    >
                    <a href="#" class="hover:border-b text-black">Career</a>
                    <a href="#" class="hover:border-b text-black"
                        >Our Innovation</a
                    >
                    <a href="#" class="hover:border-b text-black"
                        >Social Activity</a
                    >
                    <a href="#" class="hover:border-b text-black">Galery</a>
                    <a href="#" class="hover:border-b text-black">Blog</a>
                    <a
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
                    >
                </div>
                <div class="md:hidden flex items-center">
                    <button
                        class="text-white hover:text-yellow-500 focus:outline-none"
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
                class="md:hidden bg-green-900 py-2 px-4 space-y-2"
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
