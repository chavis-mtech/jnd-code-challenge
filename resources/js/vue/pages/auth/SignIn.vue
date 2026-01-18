<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';

import TopBar from '@/components/layouts/TopBar.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import InputError from '@/components/ui/input/InputError.vue';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { forgotPassword, signUp } from '@/routes';
import { store } from '@/routes/login';

defineProps<{
  status?: string;
  canResetPassword: boolean;
  canRegister: boolean;
}>();

const navItems: INavItem[] = [{ label: 'Sign Up', href: signUp().url }];
</script>

<template>
  <Head title="Sign-In"> </Head>

  <section data-source="SignIn" class="h-max-screen m-0 p-0">
    <TopBar :navItems></TopBar>

    <main class="flex h-screen flex-col items-center justify-center gap-6 bg-background px-6 md:px-10">
      <div class="w-full max-w-sm">
        <div class="flex flex-col gap-8">
          <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
          </div>

          <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }" class="flex flex-col gap-6">
            <div class="grid gap-6">
              <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                  id="email"
                  type="email"
                  name="email"
                  required
                  autofocus
                  :tabindex="1"
                  aria-autocomplete="list"
                  placeholder="email@example.com"
                />
                <InputError :message="errors.email" />
              </div>

              <div class="grid gap-2">
                <div class="flex items-center justify-between">
                  <Label for="password">Password</Label>
                  <TextLink v-if="canResetPassword" :href="forgotPassword()" class="text-sm" :tabindex="5"> Forgot password? </TextLink>
                </div>
                <Input id="password" type="password" name="password" required :tabindex="2" placeholder="Password" />
                <InputError :message="errors.password" />
              </div>

              <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                  <Checkbox id="remember" name="remember" :tabindex="3" />
                  <span>Remember me</span>
                </Label>
              </div>

              <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="processing" data-test="login-button">
                <Spinner v-if="processing" />
                Sign in
              </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground" v-if="canRegister">
              Don't have an account?
              <TextLink :href="signUp()" :tabindex="5">Sign up</TextLink>
            </div>
          </Form>
        </div>
      </div>
    </main>
  </section>
</template>

<style scoped></style>
