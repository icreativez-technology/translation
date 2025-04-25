<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

defineProps({
  translation: Object,
});
</script>

<template>
  <Head :title="`Translation: ${translation.key}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Translation Details
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <h3 class="text-lg font-medium text-gray-900">Key Information</h3>
                <dl class="mt-4 space-y-4">
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Group</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ translation.group }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Key</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ translation.key }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Locale</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                        {{ translation.locale }}
                      </span>
                    </dd>
                  </div>
                </dl>
              </div>

              <div>
                <h3 class="text-lg font-medium text-gray-900">Content</h3>
                <div class="mt-4">
                  <div class="p-4 bg-gray-50 rounded-md">
                    <pre class="text-sm text-gray-900 whitespace-pre-wrap">{{ translation.value }}</pre>
                  </div>
                </div>

                <div class="mt-4">
                  <h4 class="text-sm font-medium text-gray-500">Tags</h4>
                  <div class="flex flex-wrap gap-2 mt-2">
                    <span
                      v-for="tag in translation.tags"
                      :key="tag"
                      class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full"
                    >
                      {{ tag.tag }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
              <Link
                :href="route('translations.index')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
              >
                Back to List
              </Link>
              <Link
                :href="route('translations.edit', translation.id)"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
              >
                Edit Translation
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>