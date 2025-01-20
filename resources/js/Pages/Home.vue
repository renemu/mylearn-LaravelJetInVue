<script setup>
import NavBar from "@/Layouts/NavBar.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    product: {
        type: Array,
        default: () => [],
    },
    pages: {
        type: Array,
        default: () => [],
    },
});
const pagesHome = props.pages[0];
</script>

<template>
    <Head title="Home PT. Gawe Becik Nadhah Anugrah" />
    <img
        id="background"
        src="../../assets/image/background.png"
        class="absolute"
    />
    <NavBar :dataPage="pages" />
    <main>
        <div class="relative mt-15 m-5 p-5 flex flex-row">
            <div class="w-1/2 custom-top animate-fadeIn2">
                <div class="mt-20 text-2xl text-white">
                    {{ "PT Gawe Becik Nadhah Anugrah" }}
                </div>
                <div class="mt-20 text-7xl text-white font-semibold">
                    {{ "Digital Marketing" }}
                </div>
                <div class="mt-20 text-2xl text-white">
                    <div class="text-justify width-mono">
                        {{ pagesHome.description }}
                    </div>
                </div>
                <div class="mt-20 flex flex-row">
                    <div class="width-mono flex justify-between text-center">
                        <Link
                            :href="route('dashboard')"
                            class="bg-0 py-7 w-60 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300 border-2 text-white font-semibold text-xl border-yellow-400 rounded-2xl"
                        >
                            Career
                        </Link>
                        <Link
                            :href="route('dashboard')"
                            class="bg-yellow-400 py-7 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300 text-black w-60 border-2 font-semibold text-xl border-yellow-400 rounded-2xl"
                        >
                            About Us
                        </Link>
                    </div>
                </div>
            </div>
            <div class="w-1/2 animate-fadeIn2">
                <div class="inset-0 flex justify-center items-center">
                    <div class="custom-position-image">
                        <img src="../../assets/image/diskusi.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <img
            id="background"
            src="../../assets/image/circle2.png"
            class="absolute w-full"
        />
        <div class="flex flex-wrap top-mono">
            <div class="text-7xl font-semibold text-center w-full">
                About GENAH
            </div>
            <div class="flex flex-wrap w-full h-mono mt-20">
                <div class="w-1/2">
                    <img src="../../assets/image/rapatfull.png" alt="" />
                </div>
                <div class="w-1/2">
                    PT Gawe Becik Nadhah Anugrah atau biasa disebut dengan PT
                    GENAH adalah perusahaan startup berbasis digital marketing
                    dan distribusi yang didirikan pada tahun 2018. Pada tahun
                    2023 dilakukan pembaharuan sistem dengan menambah budaya
                    perusahaan meliputi spiritual, kompetitif, dan deal done.
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
main {
    font-family: "Poppins", sans-serif;
}
.custom-position-image {
    position: relative;
    width: 700px;
    top: 90px;
    right: -20px;
    transition: transform 0.5s ease-in-out;
}
.custom-position-image:hover {
    transform: translateY(-10px);
}
.custom-top {
    position: relative;
    top: 50px;
    left: 100px;
}
.width-mono {
    width: 650px;
}
.top-mono {
    position: relative;
    top: 410px;
    margin-top: 20px;
}
.h-mono {
    height: 700px;
}
</style>
