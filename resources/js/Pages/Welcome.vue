<script setup>
import { usePage, Head, Link } from "@inertiajs/vue3";
import { onMounted, reactive, ref } from "vue";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    canLogin: Boolean,
    canRegister: Boolean,
});
const state = reactive({
    products: props.products,
});
const page = usePage();
// const products = ref(props.products);
const fetchData = () => {
    // router.get(route("products.index"), {
    //     preserveState: true,
    //     preserveScroll: true,
    //     only: ["products"],
    //     onError: (errors) => {
    //         console.error("Fetch error:", errors);
    //     },
    // });
};
onMounted(() => {
    fetchData();
});
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#69c4db] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <!-- <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link> -->
                        </template>
                    </nav>
                </header>
                <main class="mt-6">
                    <!-- {{ products }} -->
                    {{ page }}
                </main>
            </div>
        </div>
    </div>
</template>
