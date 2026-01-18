<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';

import TopBar from '@/components/layouts/TopBar.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import InputError from '@/components/ui/input/InputError.vue';
import { Spinner } from '@/components/ui/spinner';
import { signIn } from '@/routes';
import { store } from '@/routes/register';

const navItems = [{ label: 'Sign In', href: signIn().url }];
</script>

<template>
  <Head title="Sign-Up"> </Head>

  <section data-source="SignUp">
    <TopBar :navItems></TopBar>

    <main class="flex h-screen flex-col items-center justify-center gap-6 bg-background px-6 md:px-10">
      <div class="w-full max-w-sm">
        <div class="flex flex-col gap-8">
          <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
          >
            <div class="grid gap-6">
              <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" type="text" required autofocus :tabindex="1" name="name" placeholder="Full name" />
                <InputError :message="errors.name" />
              </div>

              <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input id="email" type="email" required :tabindex="2" name="email" placeholder="email@example.com" />
                <InputError :message="errors.email" />
              </div>

              <div class="grid gap-2">
                <Label for="password">Password</Label>
                <Input id="password" type="password" required :tabindex="3" name="password" placeholder="Password" />
                <InputError :message="errors.password" />
              </div>

              <div class="grid gap-2">
                <Label for="password_confirmation">Confirm password</Label>
                <Input
                  id="password_confirmation"
                  type="password"
                  required
                  :tabindex="4"
                  name="password_confirmation"
                  placeholder="Confirm password"
                />
                <InputError :message="errors.password_confirmation" />
              </div>

              <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="processing" data-test="register-user-button">
                <Spinner v-if="processing" />
                Create account
              </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
              Already have an account?
              <TextLink :href="signIn()" class="underline underline-offset-4" :tabindex="6">Sign in</TextLink>
            </div>
          </Form>
        </div>
      </div>
    </main>
  </section>
</template>

<style scoped></style>
