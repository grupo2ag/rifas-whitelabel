<script>
import { createPopper } from '@popperjs/core';
import Button from "@/Components/Button/Button.vue";

export default {
    components:{
        Button
    },
    props: {
        width: String,
        align: String
    },
    data() {
        return {
            isOpen: false,
            popperInstance: null,
        }
    },
    methods: {
        close(event) {
            if (!this.$el.contains(event.target)) {
                this.isOpen = false;
                var mainElement = document.querySelector('main');
                mainElement.classList.remove('active');
            }
        },
        toggle(i) {
            this.isOpen = !i;
            this.popperInstance.update();
            var mainElement = document.querySelector('main');
            // mainElement.classList.toggle('active');
            if (this.isOpen) {
                mainElement.classList.add('active');
            } else {
                mainElement.classList.remove('active');
            }
        },
    },
    mounted() {
        document.addEventListener('click', this.close);

        this.popperInstance = createPopper(this.$refs["button"], this.$refs["content"], {
            placement: 'top',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [-58, 0],
                    },
                },
            ],
        });
    },
    beforeDestroy() {
        document.removeEventListener('click', this.close);

        if (this.popperInstance) {
            this.popperInstance.destroy();
            this.popperInstance = null;
        }
    },
    /*computed() {
        switch (this.size) {
            case 'sm' :
                return 'text-xs px-2 py-2 rounded-md';
            case 'lg' :
                return 'text-base px-5 py-3 rounded-lg';
            default:
                return 'w-[350px] md:w-82';
        }
    }*/
}
</script>

<script setup>

import { computed } from "vue";

const sizeClasses = computed(() => {

});
</script>

<template>
    <div>
        <div id="buttondrop" ref="button" @click="toggle(isOpen)" :class="[isOpen ? 'hoverActive' : '']" class="dropdown-button ">
            <slot name="trigger"></slot>
        </div>
        <div class="z-10 md:px-16" ref="content">
            <transition enter-active-class="transition duration-100 ease-out" enter-class="transform opacity-0"
                enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in"
                leave-class="transform scale-100 opacity-100 " leave-to-class="transform  opacity-0">
                <div v-show="isOpen"
                    class="w-[270px] mt-4 md:mt-5 rounded-b-xl overflow-hidden ring-opacity-5 bg-content border border-base-100"
                    :class="[isOpen ? 'active' : '']">
                    <span class="square"></span>
                    <div class="" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <slot name="content"></slot>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style lang="scss" scoped >
main {

    .active{

        &:before{
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: calc(100vh - 85px);
            z-index: 11;
            pointer-events: none;
            transition: .3s ease-in-out;
            background-color: rgb(0, 0, 0, 0.4);
            opacity: 1;
        }
    }
}

.dropdown-button {
    position: relative;
    overflow: hidden;
    background-image: linear-gradient(rgb(26 26 26), rgb(26 26 26));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: calc(100% ) 100%;
   // transition: background-size .4s cubic-bezier(.4, 0, .2, 1);
    z-index: 11;

   /* &.hoverActive {
        background-position: calc(0% + 1px) 100%;
        background-size: calc(100% ) 2px;
    }*/
}
</style>
