<template>
    <div class="bg-gray-800 p-3 rounded-t-md grid place-items-center">
        <span class="flex items-center space-x-3 select-none text-gray-50">
            <v-icon @click="modifyYear(1)">mdi-plus</v-icon>
            <span>{{ year }}</span>
            <v-icon @click="modifyYear(-1)">mdi-minus</v-icon>
        </span>
    </div>
</template>

<script setup>
import dayjs from 'dayjs'
import { ref } from 'vue';
import moment from 'moment';

const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year:'numeric' , month:'2-digit' , day:'2-digit' }).format(d).split(/(\s+)/)
var m = moment(today[0]).year();
const year = ref(m)

const yearEmit = defineEmits('selected')

function modifyYear(y) {
    year.value += y;
    yearEmit('selected', year.value);
}
</script>
