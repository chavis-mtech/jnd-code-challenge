<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

const page = usePage();

const success = computed(() => page.props.success as { message: string });
const errors = computed(() => page.props.errors);

const visible = ref(false);
let timer: number | null = null;

watch(
  () => [success.value, errors.value],
  ([newSuccess, newErrors]) => {
    if (newSuccess || (newErrors && Object.keys(newErrors).length)) {
      visible.value = true;

      if (timer) clearTimeout(timer);

      timer = window.setTimeout(() => (visible.value = false), 4000);
    }
  },
  { immediate: true },
);
</script>

<template>
  <Alert v-if="visible && success" class="absolute top-6 right-6 z-50 max-w-md min-w-sm p-4 text-center">
    <AlertTitle>Success 🎉</AlertTitle>
    <AlertDescription>
      <p>
        {{ success.message }}
      </p>
    </AlertDescription>
  </Alert>

  <Alert
    v-else-if="visible && errors && Object.keys(errors).length"
    variant="destructive"
    class="absolute top-6 right-6 z-50 max-w-md min-w-sm p-4 text-center"
  >
    <AlertTitle>Error</AlertTitle>
    <AlertDescription>
      <ul class="list-disc pl-4">
        <li v-for="(msg, key) in errors" :key="key">
          {{ msg }}
        </li>
      </ul>
    </AlertDescription>
  </Alert>
</template>
