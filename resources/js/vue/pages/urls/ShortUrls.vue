<script setup lang="ts">
import { Form, useForm, usePage } from '@inertiajs/vue3';
import { useClipboard } from '@vueuse/core';
import { Clipboard, Link2 } from 'lucide-vue-next';
import { computed } from 'vue';

import { store } from '@/actions/App/Http/Controllers/Url/ShortUrlController';
import AppResponseAlert from '@/components/layouts/AppResponseAlert.vue';
import TopBar from '@/components/layouts/TopBar.vue';
import { Button } from '@/components/ui/button';
import { Card, CardAction, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
const { copy, isSupported } = useClipboard();

interface IStoreUrl {
  data: {
    originalUrl: string;
    shortCode: string;
    shortUrl: string;
  };
}

const page = usePage();

const { navItems } = defineProps<{ navItems?: INavItem[] }>();

const form = useForm({
  url: '',
});

const success = computed(() => page.props.success as IStoreUrl);
</script>

<template>
  <section data-source="ShortUrls" class="h-max-screen m-0 p-0">
    <TopBar :navItems></TopBar>

    <main class="h-screen flex-row items-start justify-center gap-6 bg-background px-6 pt-20 md:px-10">
      <AppResponseAlert />

      <CardContent class="flex items-start justify-center">
        <Form v-bind="store.form()" class="container w-full">
          <Card class="rounded-lg border p-4 shadow-md">
            <CardHeader class="flex gap-3 px-0">
              <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-400">
                <Link2 class="text-white" />
              </div>
              <div>
                <CardTitle class="text-xl"><b>Shorten a URL</b></CardTitle>
                <p class="text-base text-muted-foreground">Enter a long URL to create a short, shareable link</p>
              </div>
            </CardHeader>

            <CardContent class="mt-6 px-0">
              <!-- INPUT -->
              <div class="flex flex-col gap-2">
                <label for="">Original URL</label>
                <Input name="url" v-model="form.url" type="text" class="mx-1 h-10 px-4" placeholder="https://example.com/very/long/url/path" />
              </div>
              <div v-if="isSupported">supported</div>

              <!-- RESULT -->
              <div class="mt-6 rounded-lg border border-primary/20 bg-primary/5 p-5" v-if="success?.data?.shortUrl">
                <p>Your shortened URL is ready!</p>
                <div class="flex items-center gap-2">
                  <code class="mt-2 flex-1 truncate rounded-lg border bg-background p-3 text-base">
                    {{ success.data.shortUrl }}
                  </code>
                  <div class="mt-2" @click="copy(success.data.shortUrl)">
                    <Button type="button" variant="outline" class="h-11 w-11 border bg-background text-primary">
                      <Clipboard />
                    </Button>
                  </div>
                </div>
              </div>
            </CardContent>

            <CardAction class="w-full">
              <Button type="submit" class="h-10 w-full cursor-pointer text-lg"> <b>Shorten URL</b> </Button>
            </CardAction>
          </Card>
        </Form>
      </CardContent>
    </main>
  </section>
</template>
