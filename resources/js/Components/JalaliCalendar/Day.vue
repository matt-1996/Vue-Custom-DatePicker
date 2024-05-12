<template>
    <div class="w-full bg-gray-200 p-2 border-b-md">
        <div class="grid grid-cols-7 gap-x-2 gap-y-4">
            <div class="mx-auto" v-for="(d, index) in days" :key="d">
                <span class="text-gray-500 font-semibold text-center">{{ days[index] }}</span>
            </div>
            <template v-for="(d, index) in dates" :key="d">
                <template v-if="index == 0">
                    <div v-for="i in d.day" :key="i"></div>
                </template>

                <button :disabled="d.disabled || !d.isOpen" @click="addOrRemoveSelectedDays(d.isoDate)"
                    :class="[d.isToday ? 'bg-gray-400 rounded-3xl' : '',
                    selectedDays.includes(d.isoDate) ? 'bg-green-300 rounded-3xl shadow-lg shadow-gray-500' : '',
                     d.disabled || !d.isOpen ? 'bg-gray-300' : '']"
                    class="w-12 h-12 items-center justify-center text-sm font-semibold">
                    <span class="">{{ d.date }}</span>
                    <div class="" v-for="e in d.events" :key="e">
                        <span class="text-sm" :class="[e.hasDiscount ? 'text-green-500' : 'text-red-500']"
                            v-if="d.isoDate == e.date">{{
                            e.message}}</span>
                    </div>
                </button>

            </template>

        </div>
    </div>

</template>

<script setup>
import { watch, onMounted, ref } from 'vue';
import moment from "moment-jalaali";

const dateProps = defineProps({
    selectedValues: Object,
    selectedDate: Number
})

const selectedDays = ref(['1403/2/25'])
const days = [
    'ش',
    'ی',
    'د',
    'س',
    'چ',
    'پ',
    'ج'
]

const events = ref([{
    date: '1403/2/20',
    message: '120',
    hasDiscount: true
},
{
    date: '1403/2/25',
    message: '140',
    hasDiscount: false
}
])

function addOrRemoveSelectedDays(date) {
    if (!selectedDays.value.includes(date)) {
        selectedDays.value.push(date)
    } else {
        const index = selectedDays.value.indexOf(date);
        if (index > -1) {
            selectedDays.value.splice(index, 1);
        }
    }
}

const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(d).split(/(\s+)/)
var year = moment(today[0]).year();
var month = moment(today[0]).month();
var m = moment('1403/05', 'jYYYY/jMM/')
var daysInMonth = ref(moment.jDaysInMonth(year, month))
console.log(dateProps.selectedValues)
const dates = ref([])
const date = ref()
const dateEmit = defineEmits('selected', v)

watch(() => dateProps.selectedValues, (v) => {
    generateDays(v.month, v.year)
    console.log(v)
}, { deep: true })


function generateDays(month = moment(today[0]).month() + 1, year = moment(today[0]).year()) {
    if (month > 12) [
        month = 12
    ]
    console.log(month, year)
    dates.value = []
    const daysInMonth = moment.jDaysInMonth(year, month)
    const todayArray = today[0].split('/')
    const todayFormated = `${todayArray[2]}/${todayArray[0].at(1)}/${todayArray[1]}`
    for (let i = 1; i <= daysInMonth; i++) {

        const isoDate = moment(`${year}/${month}/${i}`, 'jYYYY/jM/jD').format('jYYYY/jM/jD')

        const isoDateArray = isoDate.split('/')

        var disabled = false;

        const isSameMonth = isoDateArray[1] == todayArray[0].at(1)
        console.log(parseInt(isoDateArray[1]) , parseInt(todayArray[0].at(1)))

        if (isSameMonth && isoDateArray[2] < parseInt(todayArray[1]) || isoDateArray[1] < parseInt(todayArray[0].at(1))) {
            disabled = true
        }

        dates.value.push({
            date: i,
            day: moment(`${year}/${month}/${i}`).day(),
            today: today[0],
            isoDate: isoDate,
            events: events.value,
            isToday: isoDate == todayFormated,
            disabled: disabled,
            isOpen: true
        })

        // console.log(isoDateArray[2] < todayArray[1])
    }

    // console.log(dates.value)
}

function generateDaysWhenUpdated(month, year) {
    console.log(month, year)
    dates.value = []
    const daysInMonth = moment.jDaysInMonth(year, month)
    for (let i = 1; i <= daysInMonth; i++) {
        dates.value.push({
            date: i,
            day: moment(`${year}/${month}/${i}`).day()
        })

    }
}
onMounted(() => {
    generateDays()
})

function selectedDate(d) {
    date.value = d;
    dateEmit('selected', d)
}
</script>
