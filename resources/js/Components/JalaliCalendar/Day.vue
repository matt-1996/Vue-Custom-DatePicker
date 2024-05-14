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

                <button :disabled="d.disabled || d.isReserved" @click="addOrRemoveSelectedDays(d.isoDate)"
                    :class="[d.isToday ? 'ring-2' : '',
                    selectedDays?.includes(d.isoDate) ? 'bg-blue-300 shadow-lg shadow-gray-500' : '',
                    d.disabled || d.isReserved ? 'bg-gray-300' : '', !d.isOpen && !d.disabled && !d.isReserved ? 'bg-red-300' : '',
                    d.isOpen && !d.disabled && selectedDays.length > 0 && dateProps.range == true ? 'hover:bg-green-400' : '']" class="w-12 mx-auto h-12 items-center justify-center text-sm font-semibold">

                    <span class="">{{ d.date }}</span>

                    <div>
                        <PriceDialog @click="selectedDays.value = []" @updated="priceUpdated" v-if="d" :roomId="dateProps.room.id" :event="d"
                            :defaultPrice="dateProps.defaultPrice" />
                    </div>
                </button>
            </template>

        </div>

        <div class="flex flex-row gap-5 py-4">
            <button @click="changeStatus(d, 'open')" class="bg-green-500 p-2 rounded-lg text-gray-50 flex-1">باز کردن
                تقویم</button>
            <button @click="changeStatus(d, 'close')" class="flex-1 ring-1 rounded-lg ring-red-500">مسدود کردن
                تقویم</button>

        </div>

        <div class="flex flex-row py-4">

            <button @click="reserve" class="bg-blue-500 p-2 rounded-lg text-gray-50 flex-grow">رزرو</button>
        </div>
        <div class="text-center">
            <v-snackbar v-model="reserveSnackbar" :timeout="timeout">
                {{ reserveSnackbarText }}

                <template v-slot:actions>
                    <v-btn color="blue" variant="text" @click="reserveSnackbar = false">
                        Close
                    </v-btn>
                </template>
            </v-snackbar>
        </div>
        <PriceDialog />
    </div>


</template>

<script setup>
import { watch, onMounted, ref } from 'vue';
import moment from "moment-jalaali";
import axios from 'axios';
import PriceDialog from '@/Components/PriceDialog.vue'

const dateProps = defineProps({
    selectedValues: Object,
    selectedDate: Number,
    room: Object,
    defaultPrice: Number,
    range: Boolean
})

const reserveSnackbar = ref(false)
const reserveSnackbarText = ref("نمیتوانید روز های بسته را رزرو نمایید")
const timeout = ref(3000)

const selectedDays = ref([])
const days = [
    'ش',
    'ی',
    'د',
    'س',
    'چ',
    'پ',
    'ج'
]

const d = new Date()
const today = new Intl.DateTimeFormat('en-US-u-ca-persian', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(d).split(/(\s+)/)
const todayArray = today[0].split('/')
var year = moment(today[0]).year();
var month = moment(today[0]).month();

const events = ref([])

events.value = dateProps.room.events

function priceUpdated(e) {
    console.log(e)
    selectedDays.value = []
    events.value = e
    generateDays(dateProps.selectedValues.month, dateProps.selectedValues.year)
}

function reserve() {
    const closedDays = dates.value.filter(e => e.isOpen == false).map(v => v.isoDate)

    if (closedDays.length > 0 && selectedDays.value.some(v => closedDays.indexOf(v) != -1)) {
        console.log(closedDays.length)
        reserveSnackbar.value = true

        return {};
    }

    if (selectedDays.value.length < 1) {
        reserveSnackbarText.value = "حداقل ۱ روز را باید انتخاب کنید"
        reserveSnackbar.value = true
    } else {
        axios.post(route('room.reserve', dateProps.room.id), {
            days: selectedDays.value
        }).then(res => {
            selectedDays.value = []
            events.value = res.data.data
            generateDays(dateProps.selectedValues.month, dateProps.selectedValues.year)
        })
    }
}

function changeStatus(dateObject, status) {

    axios.post(route('event.update'), {
        isOpen: status == 'open' ? true : false,
        days: selectedDays.value,
        roomId: dateProps.room.id
    }).then(res => {
        events.value = res.data.data
        selectedDays.value = []
        generateDays(dateProps.selectedValues.month, dateProps.selectedValues.year)
    })


}



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


var m = moment('1403/05', 'jYYYY/jMM/')
var daysInMonth = ref(moment.jDaysInMonth(year, month))
const dates = ref([])
const date = ref()
const dateEmit = defineEmits('selected', v)

watch(() => dateProps.selectedValues, (v) => {
    generateDays(v.month, v.year)
}, { deep: true })


function generateDays(month = moment(today[0]).month() + 1, year = moment(today[0]).year()) {
    if (month > 12) {
        month = 12
    }

    dates.value = []
    const daysInMonth = moment.jDaysInMonth(year, month)
    const todayArray = today[0].split('/')
    const todayFormated = `${todayArray[2]}/${todayArray[0].at(1)}/${todayArray[1]}`
    for (let i = 1; i <= daysInMonth; i++) {

        const isoDate = moment(`${year}/${month}/${i}`, 'jYYYY/jM/jD').format('jYYYY/jM/jD')

        const isoDateArray = isoDate.split('/')

        var disabled = false;

        const isSameMonth = isoDateArray[1] == todayArray[0].at(1)

        if (isSameMonth && isoDateArray[2] < parseInt(todayArray[1]) || isoDateArray[1] < parseInt(todayArray[0].at(1)) && isoDateArray[0] == todayArray[2]) {
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
            isOpen: events.value.find(e => e.date == isoDate)?.is_open ?? true,
            todayEvent: events.value.find(e => e.date == isoDate) ?? {},
            isReserved: events.value.find(e => e.date == isoDate)?.is_reserved ?? false,
            event_id: events.value.find(e => e.date == isoDate)?.id
        })
    }
}

onMounted(() => {
    generateDays()
})

</script>
