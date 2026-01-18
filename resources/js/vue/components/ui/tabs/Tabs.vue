<script setup lang="ts">
import { TabsRoot } from 'radix-vue'
import { cn } from '@/lib/utils'

defineProps<{
  class?: string
}>()
</script>

<template>
  <TabsRoot
    data-slot="tabs"
    :class="cn('flex flex-col gap-2', $props.class)"
  >
    <slot />
  </TabsRoot>
</template>
