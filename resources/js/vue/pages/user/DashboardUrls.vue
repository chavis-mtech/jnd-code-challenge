<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Link2, LucideMousePointerClick, TrendingUpIcon } from 'lucide-vue-next';
import { computed } from 'vue';

import AppResponseAlert from '@/components/layouts/AppResponseAlert.vue';
import TopBar from '@/components/layouts/TopBar.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import ShortUrlList from '@/pages/urls/ShortUrlList.vue';

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

const page = usePage();

const { urls, navItems } = defineProps<{ urls: IShortUrlItem[]; navItems?: INavItem[] }>();

const me = computed(() => page.props.auth?.user);
const totals = computed(() => {
  let totalLinks: number = 0;
  let totalVisits: number = 0;
  let totalActiveLink: number = 0;

  urls.forEach((url) => {
    totalLinks++;
    totalVisits += url.count;
    totalActiveLink += url.status;
  });

  return { totalLinks, totalVisits, totalActiveLink };
});
</script>

<template>
  <Head title="Dashboard-Urls"></Head>

  <section data-source="DashboardUrls">
    <TopBar :navItems></TopBar>

    <main class="flex h-screen flex-row items-start justify-center gap-6 bg-background px-6 pt-20 md:px-10">
      <AppResponseAlert />

      <div class="container w-full">
        <CardHeader>
          <CardTitle class="text-2xl">Dashboard</CardTitle>
          <CardDescription>Welcome back, {{ me.name }}</CardDescription>
        </CardHeader>

        <CardHeader class="mt-4 flex w-full flex-row gap-4 rounded-lg p-4">
          <Card class="w-full px-4 py-4">
            <div>
              <div class="flex justify-between text-muted-foreground">
                <span>Total Links</span>
                <Link2 />
              </div>
              <div class="mt-4">
                <span class="text-2xl font-bold">{{ totals.totalLinks }}</span>
              </div>
            </div>
          </Card>
          <Card class="w-full p-4">
            <div>
              <div class="flex justify-between text-muted-foreground">
                <span>Total Visits</span>
                <LucideMousePointerClick />
              </div>
              <div class="mt-4">
                <span class="text-2xl font-bold">{{ totals.totalVisits }}</span>
              </div>
            </div>
          </Card>
          <Card class="w-full p-4">
            <div>
              <div class="flex justify-between text-muted-foreground">
                <span>Active Links</span>
                <TrendingUpIcon />
              </div>
              <div class="mt-4">
                <span class="text-2xl font-bold">{{ totals.totalActiveLink }}</span>
              </div>
            </div>
          </Card>
        </CardHeader>

        <CardContent class="px-4">
          <ShortUrlList :urls></ShortUrlList>
        </CardContent>
      </div>
    </main>
  </section>
</template>
