<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

import AppResponseAlert from '@/components/layouts/AppResponseAlert.vue';
import TopBar from '@/components/layouts/TopBar.vue';
import { CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import ShortUrlList from '@/pages/urls/ShortUrlList.vue';
import UserList from '@/pages/user/UserList.vue';
import { IUser } from '@/types';

type IShortUrlItem = {
  id: number;
  count: number;
  status: number;
  expires_date: string | null;
  last_accessed_at: string | null;
  url: {
    code: string;
    origin_url: string;
  };
};

const activeTab = ref<string>('link');

const page = usePage();

const { urls, navItems } = defineProps<{ urls: IShortUrlItem[]; users: IUser[]; navItems?: INavItem[] }>();

const tabs = {
  active: 'link',
  list: [
    { key: 'link', name: 'All Links' },
    { key: 'user', name: 'users' },
  ],
};

const me = computed(() => page.props.auth?.user);
</script>

<template>
  <Head title="Admin"></Head>

  <section data-source="Admin">
    <TopBar :navItems></TopBar>

    <main class="flex h-screen flex-row items-start justify-center gap-6 bg-background px-6 pt-20 md:px-10">
      <AppResponseAlert />

      <div class="container w-full">
        <CardHeader>
          <CardTitle class="text-2xl">Admin</CardTitle>
          <CardDescription>Welcome back, {{ me.name }}</CardDescription>
        </CardHeader>

        <CardContent class="mt-8 px-4">
          <div class="mb-4 flex w-fit gap-2 rounded-md bg-muted p-1">
            <div v-for="tab in tabs.list" :key="tab.key">
              <div>
                <button
                  @click="activeTab = tab.key"
                  class="px-2"
                  :class="[{ 'rounded-sm bg-white': activeTab == tab.key }, { 'cursor-pointer': activeTab != tab.key }]"
                >
                  {{ tab.name }}
                </button>
              </div>
            </div>
          </div>

          <div>
            <div v-if="activeTab == 'link'">
              <ShortUrlList :urls />
            </div>
            <div v-if="activeTab == 'user'">
              <UserList :users />
            </div>
          </div>
        </CardContent>
      </div>
    </main>
  </section>
</template>
