<template>
    <div class="bg-gray-700 p-3 grid place-items-center">
        <span class="flex items-center space-x-3 select-none text-gray-50">
            <v-icon v-if="month < 12" @click="addMonth(1)">mdi-plus</v-icon>
            <span class="w-20 text-center"> {{ getMonthInShamsi(month) }}</span>
            <v-icon v-if="month != 1" @click="minusMonth(1)">mdi-minus</v-icon>
        </span>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import moment from 'moment';

const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(d).split(/(\s+)/)
var m = moment(today[0]).month() + 1;
const month = ref(m)


function getMonthInShamsi(month) {
    var shamsiMonth = '';
    switch (month) {
        case 1:
            shamsiMonth = 'فروردین';
            break;
        case 2:
            shamsiMonth = 'اردیبهشت';
            break;
        case 3:
            shamsiMonth = 'خرداد';
            break;
        case 4:
            shamsiMonth = 'تیر';
            break;
        case 5:
            shamsiMonth = 'مرداد';
            break;
        case 6:
            shamsiMonth = 'شهریور';
            break;
        case 7:
            shamsiMonth = 'مهر';
            break;
        case 8:
            shamsiMonth = 'آبان';
            break;
        case 9:
            shamsiMonth = 'آذر';
            break;
        case 10:
            shamsiMonth = 'دی';
            break;
        case 11:
            shamsiMonth = 'بهمن';
            break;
        case 12:
            shamsiMonth = 'اسفند';
            break;
    }

    return shamsiMonth
}

const monthEmit = defineEmits('selected')

function addMonth(y) {
    month.value += y;
    monthEmit('selected', month.value);
}

function minusMonth(y) {
    if (y == 0) {
        month.value = 1
        monthEmit('selected', month.value)
    } else {
        month.value -= y
        monthEmit('selected', month.value)
    }

}
</script>
