<template>
    <div class="relative py-3" :class="[ 'form-control', !!error && 'has-error' ]">
        <label class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">
            {{ label }}
        </label>
        <money3
            v-model.number="amount"
            v-bind="config"
            class="block w-full px-3 pt-3 pb-2 text-base border bg-content text-neutral rounded-xl focus:outline-none focus:ring-0 focus:border-blue"
            :class="[!!error ? 'border-red' :  'border-white-dark']"
        />
    </div>
</template>

<script>
import {Money3Component} from 'v-money3'

export default {
    components: {money3: Money3Component},
    emits: ['update:modelValue'],
    props: {
        masked: {type: Boolean, default: false},
        prefix: {type: String, default: 'R$ '},
        suffix: {type: String, default: ''},
        precision: {type: Number, default: 2},
        disabled: {type: Boolean, default: false},
        min: {type: Number, default: 0},
        max: {type: Number, default: 10000000000},
        label: String,
        value: Number
    },
    data() {
        return {
            amount: this.value ?? null,
            config: {
                masked: false,
                prefix: this.prefix,
                suffix: this.suffix,
                thousands: '.',
                decimal: ',',
                precision: this.precision,
                disableNegative: true,
                disabled: this.disabled,
                min: this.min,
                max: this.max,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
                shouldRound: true,
                focusOnRight: true,
            }
        }
    },
    created() {
        //this.amount = this.modelValue;
    },
    watch: {
        modelValue(val) {
            this.amount = val*100;
        },
        amount(val) {
            this.$emit("update:modelValue", val*100);
        },
    }
}
</script>
