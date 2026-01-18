<script setup lang="ts">
import AuthSimpleLayout from '@/components/layouts/auth/AuthSimpleLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});
</script>

<template>
  <AuthSimpleLayout :breadcrumbs="breadcrumbs">
    <slot />
  </AuthSimpleLayout>
</template>
