<script setup>
import {onMounted, ref} from 'vue';
import Error from "@/Components/Error/Error.vue";

defineProps(['modelValue', 'type', 'error', 'name', 'label', 'rows', 'placeholder', 'maxlength', 'required']);

defineEmits(['update:modelValue', 'validate']);

// const input = ref(null);

/*onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});*/
</script>

<template>
    <div class="relative pb-3" :class="['form-control', !!error && 'has-error']">
        <label :for="name" class="block text-white text-xs uppercase font-semibold z-10 font-secondary">
            {{ label }}
        </label>

        <textarea :id="name" :name="name" :rows="rows"
                  class="block px-3 py-3 text-base leading-none w-full text-white border border-gray rounded-lg focus:outline-none focus:ring-0 focus:border-blue bg-transparent font-secondary"
                  @blur="$emit('validate')"
                  @focus="$emit('focus')"
                  @keypress="$emit('validate')"
                  :value="modelValue"
                  :required="required"
                  :placeholder="placeholder"
                  @input="$emit('update:modelValue', $event.target.value)"
                  ref="input" :maxlength="maxlength" :class="[!!error ? 'border-red' :  'border-white-dark']"/>

        <Error :message="error"/>
    </div>
</template>
