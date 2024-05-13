<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold  text-xl text-gray-200 dark:text-gray-800 leading-tight">
                Room
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                 <JalaliCalendar :room="props.room" :default-price="props.defaultPrice"  class="w-full" />
        </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JalaliCalendar from '@/Components/JalaliCalendar/JalaliCalendar.vue';

const props = defineProps({ room: Object , defaultPrice: Number})


</script>
