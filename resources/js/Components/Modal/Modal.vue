<script setup>
import Icon from '@/Components/Icon/Icon.vue'

import {computed} from "vue";

const props = defineProps({
    show: Boolean,
    size: {
        type: String,
        default: '550px',
    },
})

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'md' :
            return 'w-full md:w-[768px]';
        case 'lg' :
            return 'w-full md:w-[1080px]';
        default:
            return 'w-full md:w-[550px]';
    }
});
</script>

<template>
    <Transition name="modal" >
        <div v-if="show" class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container" :class="[sizeClasses]">
                    <button type="button" class="modal-default-button" @click="$emit('close')">
                        <Icon name="icon-close" class="w-4 fill-primary-bw"/>
                    </button>

                    <div class="modal-header pt-4 px-5">
                        <slot name="header"></slot>
                    </div>

                    <div class="modal-body py-4 px-5">
                        <slot name="body"></slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style src="./style.scss" lang="scss" />
