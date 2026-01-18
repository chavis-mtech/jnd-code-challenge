<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

import { removeUser, updateStatusUser, updateUser } from '@/actions/App/Http/Controllers/User/UserController';
import { Button } from '@/components/ui/button';
import { Card, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { IUser } from '@/types';

const editing = ref<Record<number, boolean>>({});

const { users } = defineProps<{ users: IUser[] }>();
const form = useForm({
  status: 0 | 1,
  name: '',
});

const onSubmitUpdateStatusUser = (id: number, status: number) => {
  const url = updateStatusUser.url;

  form.status = status;

  form.put(url({ id }) + `?put=${url('{id}')}`);
};
const onSubmitRemoveUser = (id: number) => {
  const url = removeUser.url;

  form.delete(url({ id }) + `?delete=${url('{id}')}`);
};

const onSubmitEditUser = (id: number) => {
  const url = updateUser.url;

  form.put(url({ id }) + `?put=${url('{id}')}`);
};
</script>

<template>
  <Card data-source="UserList" class="p-4">
    <CardTitle>Your Links</CardTitle>
    <Card class="w-full px-2 pt-2">
      <table class="w-full table-auto rounded-lg">
        <thead class="border-b">
          <tr>
            <th scope="col" class="w-fit p-2 text-left"></th>
            <th scope="col" class="w-fit p-2 text-left">Name</th>
            <th scope="col" class="py-2 text-left">Email</th>
            <th scope="col" class="w-fit p-2 text-left">Roles</th>
            <th scope="col" class="w-fit p-2 text-left">Created</th>
            <th scope="col" class="w-fit p-2 text-left">Status</th>
            <th scope="col" class="w-fit p-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody class="p-1">
          <tr v-for="user of users" :key="user.id" class="border-b duration-200 hover:bg-gray-100">
            <td class="border-r p-2">{{ user.id }}</td>
            <td
              class="p-2 text-nowrap"
              @dblclick="
                form.name = user.name;

                editing = {};
                editing[user.id] = true;
              "
            >
              <span v-if="!editing[user.id]">{{ user.name }}</span>
              <Input
                :name="`user-${user.id}`"
                v-else
                autofocus
                v-model="form.name"
                @blur="editing = {}"
                @keyup.enter="onSubmitEditUser(user.id)"
                @keyyp.esc="editing = {}"
                :placeholder="user.name"
              />
            </td>
            <td class="p-2">
              <span>{{ user.email }}</span>
            </td>
            <td class="p-2">
              <ul>
                <li v-for="role of user.roles" :key="role.id">
                  <Button v-if="role.name == 'admin'">{{ role.name }}</Button>
                  <Button v-else variant="outline">{{ role.name }}</Button>
                </li>
              </ul>
            </td>
            <td class="p-2">
              <span>{{ user.created_at }}</span>
            </td>
            <td class="p-2">
              <Button v-if="user.status" class="cursor-pointer" @click="onSubmitUpdateStatusUser(user.id, 0)">Active</Button>
              <Button v-else variant="outline" class="cursor-pointer" @click="onSubmitUpdateStatusUser(user.id, 1)">Inactive</Button>
            </td>
            <td class="p-2">
              <Button variant="outline" class="cursor-pointer text-red-500" @click="onSubmitRemoveUser(user.id)"><Trash2 /></Button>
            </td>
          </tr>
        </tbody>
      </table>
    </Card>
  </Card>
</template>

<style scoped></style>
