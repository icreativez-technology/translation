<script setup>
import { usePage } from '@inertiajs/vue3';

const { exportData } = usePage().props;
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Export Translations
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <div v-if="Object.keys(exportData).length">
            <div v-for="(groups, locale) in exportData" :key="locale" class="mb-8">
              <h3 class="text-lg font-bold text-blue-600 mb-2">Locale: {{ locale }}</h3>

              <div v-for="(translations, group) in groups" :key="group" class="ml-4 mb-4">
                <h4 class="text-md font-semibold text-gray-700">Group: {{ group }}</h4>

                <table class="min-w-full divide-y divide-gray-200 mt-2 text-sm text-left">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-4 py-2 text-gray-500 uppercase tracking-wider">Key</th>
                      <th scope="col" class="px-4 py-2 text-gray-500 uppercase tracking-wider">Value</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(value, key) in translations" :key="key">
                      <td class="px-4 py-2 font-mono text-gray-800">{{ key }}</td>
                      <td class="px-4 py-2 text-gray-700">{{ value }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500">No translations found.</div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
