<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Link2 } from 'lucide-vue-next';
import { computed, PropType } from 'vue';

import { Button } from '@/components/ui/button';
import { CardHeader } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { logout, signIn, welcome } from '@/routes';

const page = usePage();
const me = computed(() => page.props.auth?.user);

defineProps({
  appName: {
    type: String,
    default: 'M-Short',
  },
  navItems: {
    type: Array as PropType<INavItem[]>,
    default: () => [{ label: 'Sign In', href: signIn().url }],
  },
});
</script>

<template>
  <section data-source="TopBar" class="absolute top-0 w-full">
    <CardHeader class="h-16 border-b border-border bg-card">
      <div class="container mx-auto flex h-16 items-center justify-between px-4">
        <a :href="welcome().url" class="flex items-center gap-2 text-xl font-semibold">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-950">
            <Link2 class="text-white" />
          </div>

          <span>{{ appName }}</span>
        </a>
        <nav class="flex items-center gap-4">
          <a :href="item.href" v-for="item in navItems" :key="item.href">
            <span class="text-muted-foreground" :class="{ 'font-bold text-primary': usePage().url == item.href }">{{ item.label }}</span>
          </a>

          <DropdownMenu v-if="me" class="relative" onclick="topbarMeDropdown.hidden = !topbarMeDropdown.hidden">
            <DropdownMenuTrigger as-child class="relative">
              <Button class="flex items-center gap-2 rounded-md px-3 py-2">
                <span class="font-medium">{{ me.name }}</span>
              </Button>

              <div id="topbarMeDropdown" hidden class="absolute top-12 left-0 flex w-32 justify-center rounded-md border bg-background py-1">
                <DropdownMenuContent align="end">
                  <DropdownMenuItem class="cursor-pointer text-center text-red-500 focus:text-red-500">
                    <Link :href="logout()"> Logout </Link>
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </div>
            </DropdownMenuTrigger>
          </DropdownMenu>
        </nav>
      </div>
    </CardHeader>
  </section>
</template>

<style scoped></style>
