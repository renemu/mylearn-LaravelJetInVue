<script setup>
import { ref, computed, watch } from "vue";
import { debounce } from "lodash";

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
// Table Configuration
const columns = props.column;

// Mock Data (would typically come from an API or parent component)
const data = ref(props.dataTable);

// State Management
const searchQuery = ref("");
const debouncedSearchQuery = ref("");
const currentPage = ref(1);
const rowsPerPage = ref(5);
const rowsPerPageOptions = [5, 10, 15, 20];
const customRowsPerPage = ref(5);
const sortKey = ref("id");
const sortOrder = ref("asc");

// Debounce search to improve performance
watch(
    searchQuery,
    debounce((newValue) => {
        debouncedSearchQuery.value = newValue;
    }, 300)
);

// Reactive Data Processing
const filteredData = computed(() => {
    if (!debouncedSearchQuery.value) return data.value;

    const searchTerm = debouncedSearchQuery.value.toLowerCase();
    return data.value.filter((item) =>
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
    console.log("Edit item:", item);
}

function deleteItem(item) {
    // Placeholder for delete functionality
    data.value = data.value.filter((d) => d.id !== item.id);
}

// Reset current page when rows per page changes
watch([rowsPerPage, customRowsPerPage], () => {
    currentPage.value = 1;
});
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
                    class="border rounded-lg px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                >
                    <option
                        v-for="option in rowsPerPageOptions"
                        :key="option"
                        :value="option"
                    >
                        {{ option }}
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
                    class="border rounded-lg px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none w-24"
                />
                Entries
            </div>
            <div class="flex items-center space-x-4">
                <!-- Search Input with Debounce -->
                <input
                    v-model="debouncedSearchQuery"
                    type="text"
                    placeholder="Search data..."
                    class="border rounded-lg px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                />
            </div>
        </div>

        <!-- Data Table -->
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.name"
                        class="px-6 py-3 border-b cursor-pointer hover:bg-gray-200"
                        @click="updateSort(column.name)"
                    >
                        {{ column.label }}
                        <span v-if="sortKey === column.name" class="ml-2">
                            {{ sortOrder === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                    <th class="px-6 py-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <tr
                    v-for="(item, index) in paginatedData"
                    :key="item.id"
                    class="hover:bg-gray-50 transition-colors duration-200"
                >
                    <td
                        v-for="column in columns"
                        :key="column.name"
                        class="px-6 py-4 border-b"
                    >
                        {{ item[column.name] }}
                    </td>
                    <td class="px-6 py-4 border-b space-x-2">
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
                    </td>
                </tr>
                <tr v-if="paginatedData.length === 0">
                    <td
                        :colspan="columns.length + 1"
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
