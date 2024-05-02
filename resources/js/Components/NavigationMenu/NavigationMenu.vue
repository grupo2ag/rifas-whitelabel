<script>
import {Inertia} from "@inertiajs/inertia";
import Icon from "@/Components/Icon/Icon.vue";
import {useMediaQuery} from '@vueuse/core'

export default {
    name: "NavigationMenu",
    props: {
        orientation: String,
        sidebar: Boolean,
        active: Boolean,
    },
    components: {
        Icon,
    },
    data() {
        return {
            // menu: this.$inertia.page.props.siteConfig.menus,
            isLargeScreen: useMediaQuery('(max-width: 768px)')
        }
    },
    emits: ['close'],
    methods: {
        goto(hash, position) {

                var element = document.getElementById(hash);
                var headerOffset = this.isLargeScreen ? position : 0;

                var elementPosition = element.offsetTop;
                var offsetPosition = elementPosition - headerOffset;
                document.documentElement.scrollTop = offsetPosition;
                document.body.scrollTop = offsetPosition; // For Safari
                this.$emit('close', false)
        },

    },
}
</script>

<template>
    <nav v-if="!sidebar" class="c-nav" :class="orientation ? 'c-nav--' + orientation : ''">
        <button type="button" class="c-nav__item" @click="goto('contact', 70)">
            <Icon name="icon-bag" class="h-5 stroke-neutral"/>Meus Bilhetes
        </button>
    </nav>
</template>

<style src="./style.scss" lang="scss" scoped/>

