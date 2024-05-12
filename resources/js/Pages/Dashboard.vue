<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <JalaliCalendar class="w-full" />
            </div>
        </div>
            <!-- <div class="max-w-2xl mx-auto py-10">
                <JalaliCalendar class="w-full" />
            </div> -->
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue'
import JalaliCalendar from '@/Components/JalaliCalendar/JalaliCalendar.vue';
const msg = ref('Hello World!')
import moment from 'moment';
const newDays = ref()
const ftow = ref(3)

const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(d).split(/(\s+)/)
var m = moment(today[0]).year();

console.log(m)

const selectedDates = ref([])

</script>
