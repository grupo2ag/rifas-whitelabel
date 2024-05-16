<script setup>
import Error from "@/Components/Error/Error.vue";

defineProps(['modelValue','id', 'label', 'name', 'options', 'error','multiple', 'text']);

defineEmits(['update:modelValue', 'validate', 'change','multiple']);
</script>

<template>
    <div class="py-3 relative">
        <label class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">{{ label }}</label>
        <select
            class="block px-3 pb-2 pt-3 text-base w-full text-neutral border rounded-xl focus:outline-none focus:ring-0 focus:border-blue appearance-none"
            :name="name"
            :id="id"
            :multiple="multiple"
            @change="$emit('validate'), $emit('change')"
            @input="$emit('update:modelValue', $event.target.value), $emit('validate')" ref="input"
            :value="modelValue"
            :class="[!!error ? 'border-red' :  'border-white-dark']">
            <option selected disabled value="" class="selected">Selecione</option>
            <slot/>
        </select>
        <Error :message="error"/>
    </div>
</template>

<style lang="scss">
select {
    background: transparent;
    background-image: url("data:image/svg+xml;utf8,<svg width='11' height='7' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M2.12016 1.28995L6.00016 5.16995L9.88016 1.28995C9.97274 1.19736 10.0827 1.12392 10.2036 1.07382C10.3246 1.02371 10.4542 0.997925 10.5852 0.997925C10.7161 0.997925 10.8457 1.02371 10.9667 1.07382C11.0877 1.12392 11.1976 1.19736 11.2902 1.28995C11.3827 1.38253 11.4562 1.49244 11.5063 1.6134C11.5564 1.73437 11.5822 1.86401 11.5822 1.99495C11.5822 2.12588 11.5564 2.25552 11.5063 2.37649C11.4562 2.49745 11.3827 2.60736 11.2902 2.69995L6.70016 7.28995C6.60764 7.38265 6.49776 7.4562 6.37678 7.50638C6.25581 7.55656 6.12613 7.58239 5.99516 7.58239C5.86419 7.58239 5.73451 7.55656 5.61353 7.50638C5.49256 7.4562 5.38267 7.38265 5.29016 7.28995L0.700159 2.69995C0.607455 2.60743 0.533907 2.49754 0.483726 2.37657C0.433545 2.2556 0.407715 2.12591 0.407715 1.99495C0.407715 1.86398 0.433545 1.73429 0.483726 1.61332C0.533907 1.49235 0.607455 1.38246 0.700159 1.28995C1.09016 0.909946 1.73016 0.899946 2.12016 1.28995V1.28995Z' fill='gray'/></svg> ");
    background-repeat: no-repeat;
    background-position-x: calc(100% - 12px);
    background-position-y: center;

    &:invalid {
        color: #808080;
    }

    [disabled] {
        color: #b8b8b8;
    }

    option{
        color:black;
    }
}



</style>
