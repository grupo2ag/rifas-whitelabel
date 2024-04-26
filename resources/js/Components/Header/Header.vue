
<script>
import NavigationMenu from "@/Components/NavigationMenu/NavigationMenu.vue";
// import SocialMenu from "@/Components/SocialMenu/SocialMenu.vue";
import {Link} from '@inertiajs/inertia-vue3';
import {defineComponent} from 'vue'
// import Icon from "@/Components/Icon/Icon.vue";
import {useMediaQuery} from '@vueuse/core'

export default defineComponent({
    name: "Header",
    components: {
        NavigationMenu,
        // SocialMenu,
        // Icon,
        Link
    },
    data() {
        return {
            isActive: false,
            isLargeScreen: useMediaQuery('(min-width: 768px)')
        }
    },
    methods: {
        toggleHumburger() {
            this.isActive = !this.isActive;
            document.body.classList.toggle('active');
        },
        removeHumburger() {
            this.isActive = false;
            document.body.classList.remove('active');
        },
        verificaUrl() {
            if (window.localStorage.getItem("anchorMenu")) {

                let anchor = localStorage.getItem("anchorMenu");
                let position = localStorage.getItem("positionMenu");

                setTimeout(() => {
                    var element = document.getElementById(anchor);
                    var headerOffset = this.isLargeScreen ? position : 0;

                    var elementPosition = element.offsetTop;
                    var offsetPosition = elementPosition - headerOffset;
                    document.documentElement.scrollTop = offsetPosition;
                    document.body.scrollTop = offsetPosition; // For Safari
                    this.$emit('close', false)
                }, 500)

                window.localStorage.setItem('anchorMenu', '');
                window.localStorage.setItem('positionMenu', '');
            }
        },
    },
    mounted() {
        this.verificaUrl()
    }
})
</script>

<template>
    <header>
        <div class="c-header">
            <div class="container flex justify-between">
                <div class="w-auto">
                    <Link href="/" class="text-4xl uppercase text-primary font-black" aria-label="Astra Pay">
                        Rifa8
                    </Link>
                </div>

                <template class="hidden lg:flex">
                    <NavigationMenu/>
                </template>

                <button type="button" class="c-header-mb__item o-hamburguer lg:hidden" :class="[isActive ? 'active' : '']"
                        @click="toggleHumburger()">
                    <div class="trace">
                        <span></span>
                    </div>
                </button>
            </div>
        </div>

        <NavigationMenu :sidebar="true" @close="removeHumburger()" @toggle="toggleHumburger" :active="isActive"/>

        <div class="c-sidebar-mb" :class="[isActive ? 'active' : '']">
            <div class="w-full container pt-28 pb-16 relative">
                <NavigationMenu orientation="vertical" @close="removeHumburger()" @toggle="toggleHumburger" :active="isActive" class="w-full"/>
            </div>
        </div>
    </header>
</template>

<style src="./style.scss" lang="scss" scoped/>
