
<script>
import Icon from "@/Components/Icon/Icon.vue";

// import SocialMenu from "@/Components/SocialMenu/SocialMenu.vue";
import {Link} from '@inertiajs/inertia-vue3';
import {defineComponent} from 'vue'
// import Icon from "@/Components/Icon/Icon.vue";
import {useMediaQuery} from '@vueuse/core'

export default defineComponent({
    name: "Header",
    components: {
        Icon,
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
            <div class="container flex items-center justify-between">
                <div class="w-auto">
                    <Link href="/" class="text-4xl uppercase text-primary font-black" aria-label="Astra Pay">
                        Rifa8
                    </Link>
                </div>

                <button type="button" class="text-neutral flex gap-1" @click="">
                    <Icon name="icon-bag" class="h-5 stroke-neutral"/>Meus Bilhetes
                </button>
            </div>
        </div>
    </header>
</template>

<style src="./style.scss" lang="scss" scoped/>
