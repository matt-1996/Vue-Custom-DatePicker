<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold  text-xl text-gray-200 dark:text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto overflow-hidden grid grid-cols-4 gap-4 sm:px-6 lg:px-8">
                <div v-for="room in rooms" :key="room.id">
                    <v-card class="mx-auto my-8" elevation="16" max-width="344">
                        <v-card-item>
                            <v-card-title >
                               <Link :href="route('room.show' , room.id)">{{ room.title }}</Link>
                            </v-card-title>

                            <v-card-subtitle>
                                {{ room?.user?.name }}
                            </v-card-subtitle>
                        </v-card-item>

                        <v-card-text>
                            {{ room.description }}
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        </div>
        <!-- <div class="max-w-2xl mx-auto py-10">
                <JalaliCalendar class="w-full" />
            </div> -->
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import JalaliCalendar from '@/Components/JalaliCalendar/JalaliCalendar.vue';

const props = defineProps({ rooms: Object })


</script>
