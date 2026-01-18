<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { MoveRight } from 'lucide-vue-next';

import TopBar from '@/components/layouts/TopBar.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { home, signIn } from '@/routes';
</script>

<template>
  <Head title="Welcome"> </Head>

  <section data-source="Welcome">
    <TopBar></TopBar>

    <main class="flex-1">
      <section class="px-4 py-20">
        <div class="container mx-auto max-w-3xl text-center">
          <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-muted px-4 py-2 text-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-zap h-4 w-4"
            >
              <path
                d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"
              ></path></svg
            >High-performance URL shortening
          </div>
          <h1 class="mb-6 text-4xl font-bold tracking-tight text-balance md:text-6xl">
            Shorten URLs.<br /><span class="text-muted-foreground">Track Everything.</span>
          </h1>
          <p class="mx-auto mb-8 max-w-xl text-lg text-pretty text-muted-foreground">
            Create short, memorable links in seconds. Track clicks, analyze performance, and manage all your URLs from one dashboard.
          </p>
          <div class="flex cursor-pointer flex-col items-center justify-center gap-4 sm:flex-row">
            <a :href="home().url">
              <Button class="cursor-pointer">
                <span>Get Started Free </span>
                <MoveRight />
              </Button>
            </a>
            <a :href="signIn().url"><Button variant="outline" class="cursor-pointer">Sign In</Button> </a>
          </div>
        </div>
      </section>
      <section class="bg-muted/50 px-4 py-16">
        <div class="container mx-auto">
          <h2 class="mb-12 text-center text-2xl font-bold">Everything you need</h2>
          <div class="mx-auto grid max-w-4xl gap-6 md:grid-cols-3">
            <Card data-slot="card" class="flex flex-col gap-6 rounded-xl border bg-card py-6 text-card-foreground shadow-sm">
              <div data-slot="card-content" class="px-6">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-link2 h-6 w-6 text-primary"
                  >
                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                    <line x1="8" x2="16" y1="12" y2="12"></line>
                  </svg>
                </div>
                <h3 class="mb-2 font-semibold">Short Links</h3>
                <p class="text-sm text-muted-foreground">
                  Create short, branded URLs with custom codes or auto-generated Base62 encoding for maximum efficiency.
                </p>
              </div>
            </Card>
            <Card data-slot="card" class="flex flex-col gap-6 rounded-xl border bg-card py-6 text-card-foreground shadow-sm">
              <div data-slot="card-content" class="px-6">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-bar-chart3 h-6 w-6 text-primary"
                  >
                    <path d="M3 3v18h18"></path>
                    <path d="M18 17V9"></path>
                    <path d="M13 17V5"></path>
                    <path d="M8 17v-3"></path>
                  </svg>
                </div>
                <h3 class="mb-2 font-semibold">Click Analytics</h3>
                <p class="text-sm text-muted-foreground">Track every click with detailed analytics. See how your links perform over time.</p>
              </div>
            </Card>
            <Card data-slot="card" class="flex flex-col gap-6 rounded-xl border bg-card py-6 text-card-foreground shadow-sm">
              <div data-slot="card-content" class="px-6">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-shield h-6 w-6 text-primary"
                  >
                    <path
                      d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"
                    ></path>
                  </svg>
                </div>
                <h3 class="mb-2 font-semibold">Admin Control</h3>
                <p class="text-sm text-muted-foreground">Full administrative control to manage users, monitor links, and maintain system health.</p>
              </div>
            </Card>
          </div>
        </div>
      </section>
    </main>
  </section>
</template>
