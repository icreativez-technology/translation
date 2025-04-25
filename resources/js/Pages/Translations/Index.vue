<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  translations: Object,
  filters: {
    type: Object,
    default: () => ({})
  },
  locales: Array,
  groups: Array,
  tags: Array,
});


const filters = ref({
  search: props.filters?.search || '',
  locale: props.filters?.locale || '',
  group:  props.filters?.group || '',
  tag:    props.filters?.tag || '',
});

const search = () => {
  router.get(route('translations.index'), filters.value, {
    preserveState: true,
    replace: true,
  });
};

const changePage = (page) => {
  filters.value.page = page; // Set the current page in filters
  search(); // Trigger the search with updated page
};


watch(filters, () => {
  search();
}, { deep: true, immediate: false });

const resetFilters = () => {
  filters.value = {
    search: '',
    locale: '',
    group: '',
    tag: '',
  };
};
</script>

<template>
  <Head title="Translations" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Translations
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Search and Filters -->
            <div class="mb-6 space-y-4">
              <div class="flex items-center space-x-4">
                <input
                  v-model="filters.search"
                  type="text"
                  placeholder="Search by key or value..."
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                  @click="resetFilters"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                >
                  Reset
                </button>
                <Link :href="route('translations.create')" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 disabled:opacity-50">Create</Link>
                <Link :href="route('translations.export')" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 disabled:opacity-50">Export</Link>
              </div>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <select
                  v-model="filters.locale"
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">All Languages</option>
                  <option v-for="locale in locales" :key="locale" :value="locale">
                    {{ locale }}
                  </option>
                </select>

                <select
                  v-model="filters.group"
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">All Groups</option>
                  <option v-for="group in groups" :key="group" :value="group">
                    {{ group }}
                  </option>
                </select>

                <select
                  v-model="filters.tag"
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">All Tags</option>
                  <option v-for="tag in tags" :key="tag" :value="tag">
                    {{ tag }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Translations Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Key
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Group
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Locale
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Value
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Tags
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="translation in translations.data" :key="translation.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">
                        {{ translation.key }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">
                        {{ translation.group }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                        {{ translation.locale }}
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-900 truncate max-w-xs">
                        {{ translation.value }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex flex-wrap gap-1">
                        <span
                          v-for="tag in translation.tags"
                          :key="tag"
                          class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full"
                        >
                          {{ tag.tag }}
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="space-x-2">
                        <Link
                        :href="route('translations.show', translation.id)"
                        class="text-blue-600 hover:text-blue-900"
                      >
                        View
                      </Link>
                      <Link
                        :href="route('translations.edit', translation.id)"
                        class="text-indigo-600 hover:text-indigo-900"
                      >
                        Edit
                      </Link>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center">
              <button
                @click="changePage(translations.current_page - 1)"
                :disabled="translations.current_page === 1"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
              >
                Previous
              </button>
              <button
                @click="changePage(translations.current_page + 1)"
                :disabled="translations.current_page === translations.last_page"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>