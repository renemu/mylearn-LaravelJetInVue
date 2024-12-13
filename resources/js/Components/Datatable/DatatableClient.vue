<script>
export default {
    name: "DatatableClient",
};
</script>
<script setup>
import { ref, computed, watch, reactive } from "vue";
import { debounce } from "lodash";
import { Link } from "@inertiajs/vue3";
import moment from "moment";
import thousandSeparator from "@/utils/thousandSeparator";

const props = defineProps({
    dataTable: {
        type: Array,
        default: () => [],
    },
    column: {
        type: Array,
        default: () => [],
    },
});

// Reactive state with deep watch on props
const state = reactive({
    columns: props.column,
    data: props.dataTable,
});

// Watch props for changes and update state
watch(
    () => props.dataTable,
    (newData) => {
        state.data = newData;
        // Reset pagination when data changes
        currentPage.value = 1;
    },
    { deep: true }
);

watch(
    () => props.column,
    (newColumns) => {
        state.columns = newColumns;
    },
    { deep: true }
);

// Rest of the original code remains the same...
const searchQuery = ref("");
const debouncedSearchQuery = ref("");
const currentPage = ref(1);
const rowsPerPage = ref(5);
const rowsPerPageOptions = [5, 10, 15, 20];
const customRowsPerPage = ref(5);
const sortKey = ref("id");
const sortOrder = ref("desc");

// Debounce search to improve performance
watch(
    searchQuery,
    debounce((newValue) => {
        debouncedSearchQuery.value = newValue;
    }, 300)
);

// Reactive Data Processing
const filteredData = computed(() => {
    if (!debouncedSearchQuery.value) return state.data;

    const searchTerm = debouncedSearchQuery.value.toLowerCase();
    return state.data.filter((item) =>
        Object.values(item).some((value) =>
            String(value).toLowerCase().includes(searchTerm)
        )
    );
});

const sortedData = computed(() => {
    return [...filteredData.value].sort((a, b) => {
        const valA = a[sortKey.value];
        const valB = b[sortKey.value];

        return sortOrder.value === "asc"
            ? valA > valB
                ? 1
                : -1
            : valA < valB
            ? 1
            : -1;
    });
});

const totalPages = computed(() =>
    Math.ceil(
        sortedData.value.length /
            (rowsPerPage.value === "custom"
                ? customRowsPerPage.value
                : rowsPerPage.value)
    )
);

const paginatedData = computed(() => {
    const pageSize =
        rowsPerPage.value === "custom"
            ? customRowsPerPage.value
            : rowsPerPage.value;
    const start = (currentPage.value - 1) * pageSize;
    const end = start + pageSize;
    return sortedData.value.slice(start, end);
});

const visiblePageNumbers = computed(() => {
    const range = 2; // Number of pages to show around current page
    let start = Math.max(1, currentPage.value - range);
    let end = Math.min(totalPages.value, currentPage.value + range);

    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
});

// Methods
function updateSort(key) {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
    } else {
        sortKey.value = key;
        sortOrder.value = "asc";
    }
}

function editItem(item) {
    // Placeholder for edit functionality
    console.log("Edit item:", item.id, item.name);
}

function deleteItem(item) {
    // Placeholder for delete functionality
    state.data = state.data.filter((d) => d.id !== item.id);
}

// Reset current page when rows per page changes
watch([rowsPerPage, customRowsPerPage], () => {
    currentPage.value = 1;
});
function formatDate(date) {
    if (date) {
        return moment(date, "YYYY-MM-DD").format("DD MMM YYYY");
    }
    return "";
}
function formatDateTime(date) {
    if (date) {
        return moment(date, "YYYY-MM-DD HH:mm:ss").format(
            "DD MMM YYYY HH:mm:ss"
        );
    }
    return "";
    // return date;
}
</script>
<template>
    <div class="overflow-x-auto">
        <!-- Header and Search Section -->
        <div class="flex justify-between items-center pb-4">
            <div>
                <!-- Rows Per Page Selector -->
                Show
                <select
                    v-model="rowsPerPage"
                    class="border rounded-lg px-2 py-1 focus:ring-0"
                >
                    <option
                        v-for="option in rowsPerPageOptions"
                        :key="option"
                        :value="option"
                    >
                        <span>
                            {{ option }}
                        </span>
                    </option>
                    <option value="custom">Custom</option>
                </select>
                <!-- Custom Rows Input -->
                <input
                    v-if="rowsPerPage === 'custom'"
                    v-model.number="customRowsPerPage"
                    type="number"
                    min="1"
                    placeholder="Enter rows"
                    class="border rounded-lg px-2 py-1 focus:ring-0w-24"
                />
                Entries
            </div>
            <div class="flex items-center space-x-4">
                <!-- Search Input with Debounce -->
                <input
                    v-model="debouncedSearchQuery"
                    type="text"
                    placeholder="Search data..."
                    class="border rounded-lg px-2 py-1 focus:ring-0"
                />
            </div>
        </div>

        <!-- Data Table -->
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th
                        v-for="column in state.columns"
                        :key="column.name"
                        class="px-6 py-3 border-b cursor-pointer hover:bg-gray-200"
                        @click="updateSort(column.name)"
                    >
                        {{ column.label }}
                        <span v-if="sortKey === column.name" class="ml-2">
                            {{ sortOrder === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <tr
                    v-for="(item, index) in paginatedData"
                    :key="index"
                    class="hover:bg-gray-50 transition-colors duration-200"
                >
                    <td
                        v-for="column in state.columns"
                        :key="column.name"
                        :width="column.width"
                        class="px-6 py-4 border-b"
                    >
                        <template v-if="column.btnAction">
                            <div class="space-x-2">
                                <button
                                    @click="editItem(item)"
                                    class="text-blue-600 hover:text-blue-800 transition-colors"
                                >
                                    Edit
                                </button>
                                <button
                                    @click="deleteItem(item)"
                                    class="text-red-600 hover:text-red-800 transition-colors"
                                >
                                    Delete
                                </button>
                            </div>
                        </template>
                        <template v-else-if="column.custom">
                            <div
                                v-if="column.custom.routeName"
                                :class="column.class"
                            >
                                <Link
                                    :href="
                                        route(column.custom.routeName, {
                                            id: item[column.custom.routeParam],
                                        })
                                    "
                                >
                                    <i :class="column.custom.icon"></i>
                                    {{ item[column.name] }}
                                </Link>
                            </div>
                        </template>
                        <template v-else-if="column.isDate">
                            <div :class="column.class">
                                {{ formatDate(item[column.name]) }}
                            </div>
                        </template>
                        <template v-else-if="column.isDateTime">
                            <div :class="column.class">
                                {{ formatDateTime(item[column.name]) }}
                            </div>
                        </template>
                        <template v-else-if="column.isCurrency">
                            <div :class="column.class">
                                Rp. {{ thousandSeparator(item[column.name]) }}
                            </div>
                        </template>
                        <template v-else>
                            <div :class="column.class">
                                {{ item[column.name] }}
                            </div>
                        </template>
                    </td>
                </tr>
                <tr v-if="paginatedData.length === 0">
                    <td
                        :colspan="state.columns.length + 1"
                        class="text-center py-4 text-gray-500"
                    >
                        No data available
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <span class="text-sm text-gray-500">
                Showing {{ paginatedData.length }} of
                {{ filteredData.length }} entries
            </span>
            <div class="flex space-x-2">
                <button
                    @click="currentPage = Math.max(1, currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="px-3 py-2 border rounded disabled:opacity-50"
                >
                    {{ "<" }}
                </button>
                <button
                    v-for="page in visiblePageNumbers"
                    :key="page"
                    @click="currentPage = page"
                    :class="[
                        'px-3 py-2 border rounded',
                        page === currentPage
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200',
                    ]"
                >
                    {{ page }}
                </button>
                <button
                    @click="currentPage = Math.min(totalPages, currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-2 border rounded disabled:opacity-50"
                >
                    {{ ">" }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions and hover effects */
.transition-colors {
    transition: color 0.2s ease-in-out;
}
</style>
