<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';

import { removeUrl, updateStatusUrl } from '@/actions/App/Http/Controllers/User/UserController';
import { Button } from '@/components/ui/button';
import { Card, CardTitle } from '@/components/ui/card';

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
const form = useForm({
  status: 0 | 1,
});

const { urls } = defineProps<{ urls: IShortUrlItem[]; navItems?: INavItem[] }>();

const onSubmitUpdateStatus = (id: number, status: number) => {
  const url = updateStatusUrl.url;

  form.status = status;

  form.put(url({ id }) + `?put=${url('{id}')}`);
};

const onSubmitRemoveUrl = (id: number) => {
  const url = removeUrl.url;

  form.delete(url({ id }) + `?delete=${url('{id}')}`);
};
</script>

<template>
  <Card data-source="ShortUrlList" class="p-4">
    <CardTitle>Your Links</CardTitle>
    <Card class="w-full px-2 pt-2">
      <table class="w-full table-auto rounded-lg">
        <thead class="border-b">
          <tr>
            <th scope="col" class="w-fit p-2 text-left"></th>
            <th scope="col" class="w-fit p-2 text-left">Short URL</th>
            <th scope="col" class="py-2 text-left">Original URL</th>
            <th scope="col" class="w-fit p-2 text-left">Visits</th>
            <th scope="col" class="w-fit p-2 text-left">Status</th>
            <th scope="col" class="w-fit p-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody class="p-1">
          <tr v-for="meUrl of urls" :key="meUrl.id" class="border-b duration-200 hover:bg-gray-100">
            <td class="border-r p-2">{{ meUrl.id }}</td>
            <td class="p-2 text-nowrap">
              <a
                :href="`${page.props.host}r/${page.props.auth.user.id}/${meUrl.url.code}`"
                class="text-foreground transition-colors duration-200 hover:text-blue-600 hover:underline"
              >
                {{ `${page.props.host}r/${page.props.auth.user.id}/${meUrl.url.code}` }}
              </a>
            </td>
            <td class="p-2">
              <a :href="meUrl.url.origin_url" class="text-foreground transition-colors duration-200 hover:text-blue-600 hover:underline">
                {{ meUrl.url.origin_url }}
              </a>
            </td>
            <td class="p-2">
              <span>{{ meUrl.count }}</span>
            </td>
            <td class="p-2">
              <Button v-if="meUrl.status" class="cursor-pointer" @click="onSubmitUpdateStatus(meUrl.id, 0)">Active</Button>
              <Button v-else variant="outline" class="cursor-pointer" @click="onSubmitUpdateStatus(meUrl.id, 1)">Inactive</Button>
            </td>
            <td class="p-2">
              <Button variant="outline" class="cursor-pointer text-red-500" @click="onSubmitRemoveUrl(meUrl.id)"><Trash2 /></Button>
            </td>
          </tr>
        </tbody>
      </table>
    </Card>
  </Card>
</template>

<style scoped></style>
