<template>
    <div class="flex space-x-5" v-bind="$attrs">
        <div class="flex flex-col flex-grow">

            <Year @selected="changeYear" />
            <Month @selected="changeMonth" />
            <Day @selected="changeDate" :selectedValues="selectedValues" :selectedDate="selectedDate"  />
        </div>
        <div v-if="selectedDateValue" class="w-1/2">
            <!-- {{ selectedDateValue }} -->
        </div>
    </div>
</template>

<script setup>
import Year from './Year.vue';
import Month from './Month.vue'
import Day from './Day.vue';
import dayjs from 'dayjs'
import { ref,reactive } from 'vue';
import moment from 'moment';
const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(d).split(/(\s+)/)
var m = moment(today[0]).month() ;

const selectedDateValue = ref(dayjs().date())
const selectedValues = reactive({
    month:moment(today[0]).month() ,
    year:moment(today[0]).year()
})

function changeYear(v){
    selectedValues.month = v
}

function changeMonth(v){
    selectedValues.month = v
}

function changeDate(v){
    selectedDateValue.value = v
}

</script>
