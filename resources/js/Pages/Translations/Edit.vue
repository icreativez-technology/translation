<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  translation: Object,
  locales: Array,
  groups: Array,
  tags: Array,
});

const form = useForm({
  group: props.translation.group,
  key: props.translation.key,
  value: props.translation.value,
  locale: props.translation.locale,
  tags: props.translation.tags.map(t => t.tag),
});

const submit = () => {
  form.put(route('translations.update', props.translation.id));
};
</script>

<template>
  <Head :title="`Edit Translation: ${translation.key}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Edit Translation
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                      Group
                    </label>
                    <select
                      v-model="form.group"
                      class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                    >
                      <option value="">Select a group</option>
                      <option v-for="group in groups" :key="group" :value="group">
                        {{ group }}
                      </option>
                    </select>
                    <p v-if="form.errors.group" class="mt-1 text-sm text-red-600">
                      {{ form.errors.group }}
                    </p>
                  </div>

                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                      Key
                    </label>
                    <input
                      v-model="form.key"
                      type="text"
                      class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                    />
                    <p v-if="form.errors.key" class="mt-1 text-sm text-red-600">
                      {{ form.errors.key }}
                    </p>
                  </div>

                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                      Locale
                    </label>
                    <select
                      v-model="form.locale"
                      class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                    >
                      <option value="">Select a locale</option>
                      <option v-for="locale in locales" :key="locale" :value="locale">
                        {{ locale }}
                      </option>
                    </select>
                    <p v-if="form.errors.locale" class="mt-1 text-sm text-red-600">
                      {{ form.errors.locale }}
                    </p>
                  </div>
                </div>

                <div>
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                      Value
                    </label>
                    <textarea
                      v-model="form.value"
                      rows="5"
                      class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      required
                    ></textarea>
                    <p v-if="form.errors.value" class="mt-1 text-sm text-red-600">
                      {{ form.errors.value }}
                    </p>
                  </div>

                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                      Tags
                    </label>
                    <div class="flex flex-wrap gap-2 mt-2">
                      <label
                        v-for="tag in tags"
                        :key="tag"
                        class="inline-flex items-center"
                      >
                        <input
                          type="checkbox"
                          :value="tag"
                          v-model="form.tags"
                          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                        <span class="ml-2 text-sm text-gray-700">{{ tag }}</span>
                      </label>
                    </div>
                    <p v-if="form.errors.tags" class="mt-1 text-sm text-red-600">
                      {{ form.errors.tags }}
                    </p>
                  </div>
                </div>
              </div>

              <div class="flex justify-end mt-6 space-x-3">
                <Link
                  :href="route('translations.show', translation.id)"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 disabled:opacity-50"
                  :disabled="form.processing"
                >
                  <span v-if="form.processing">Saving...</span>
                  <span v-else>Save Changes</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>