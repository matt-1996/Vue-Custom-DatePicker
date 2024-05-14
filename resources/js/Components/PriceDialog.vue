<template>
    <div class="">
        <span @click="openDialog" class="text-sm"
            :class="[props?.event?.todayEvent?.has_discount ? 'text-green-500' : 'text-red-500']">
            {{ props?.event?.todayEvent?.price || props?.defaultPrice }}
        </span>

        <v-dialog v-model="dialog" width="500">
            <v-card prepend-icon="mdi-update" title="بروزرسانی قیمت">
                <v-card-item>
                    <v-card-text class="mx-auto">
                        <template v-slot:actions>
                            <v-btn class="ms-auto" text="Ok" @click="dialog = false"></v-btn>
                        </template>
                        <v-text-field class="w-1/2 mx-auto" type="text" label="قیمت" v-model="price"></v-text-field>
                        <div class="">
                            <v-checkbox v-model="hasDiscount" color="blue" label="تخفیف دارد"
                                hide-details></v-checkbox>
                        </div>
                        <div class="text-center">
                            <button @click="updatePrice"
                                class="p-2 bg-green-500 rounded-lg w-3/4 text-white text-lg">بروزرسانی</button>
                        </div>
                    </v-card-text>
                </v-card-item>

            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
const props = defineProps({ event: Object, defaultPrice: Number, roomId: Number })
const showDialog = ref(true)

const dialog = ref(false)
const hasDiscount = ref()

hasDiscount.value = props?.event?.todayEvent?.has_discount && props?.event?.todayEvent?.has_discount == 1 ? true : false ?? false

const updatedEmit = defineEmits('updated', e)

const price = ref()

function openDialog() {
    if (!props.event.disabled && !props.event.isReserved) {
        dialog.value = true
    }
}

price.value = props?.event?.todayEvent?.price || props?.defaultPrice

function updatePrice() {

    axios.post(route('event.update.price'), {
        price: price.value,
        id: props.event.event_id || 0,
        room_id: props.roomId,
        date: props.event.isoDate,
        has_discount: hasDiscount.value
    }).then(res => {
        props.roomId = res.data.data.id
        updatedEmit('updated', res.data.data)
    })
}

</script>
