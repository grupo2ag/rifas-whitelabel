<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import { defineComponent} from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import SocialMenu from "@/Components/SocialMenu/SocialMenu.vue";
import Icon from "@/Components/Icon/Icon.vue";


export default defineComponent( {
    name: "FooterSing",
    components: {
        Icon,
        Link,
        SocialMenu,
    },
    data() {
        return {
            basic: this.$inertia.page.props.siteconfig,
        }
    }
})
</script>

<template>
    <footer class="md:pt-3">
        <div class="md:container">
            <aside class="c-content grid grid-cols-1 md:grid-cols-4 gap-6">

                <nav class="flex flex-col md:order-2">
                    <h6 class="text-lg font-bold text-neutral mb-1">Suporte</h6>

                    <a v-if="basic.phone" :href="'https://api.whatsapp.com/send?phone=' + basic.phone" target="_blank"
                       class="text-neutral/70 flex gap-1">
                        WhatsApp <Icon name="icon-whatsapp" class="h-3 w-3 mt-0.5 fill-neutral/70"/>
                    </a>

                    <a v-if="basic.email" :href="'mailto:' + basic.email" class="text-neutral/70">
                        {{ basic.email }}
                    </a>
                </nav>

                <nav class="flex flex-col items-start md:order-3">
                    <h6 class="text-lg font-bold text-neutral mb-1">Forma de Pagamento</h6>

                    <img src="/images/pix.svg" class="h-10" alt="Pagamento Pix">
                </nav>

                <nav class="flex flex-col  md:order-4" v-if="basic.whatsapp || basic.telegram || basic.instagram || basic.facebook">
                    <h6 class="text-lg font-bold text-neutral mb-1">Grupos</h6>

                    <SocialMenu />
                </nav>

                <div class="md:order-1">
                    <Link href="/" class="text-2xl uppercase text-primary font-black" :aria-label="basic.sitem_title">
                        <img v-if="basic.logo"
                             :src="basic.logo"
                             class="h-5 mt-1"
                             :alt="basic.site_title">
                        <img v-else src="/images/logo.svg" class="h-5 mt-1"/>
                    </Link>

                    <p class="text-sm text-neutral/70 mt-3">© {{ new Date().getFullYear()}} Todos os direitos reservados </p>
                </div>

            </aside>
        </div>

        <div class="container py-5 flex justify-center">
            <Link href="/" class="text-xs text-neutral/70 flex">
                desenvolvido por <img src="/images/logo.svg" class="h-4 ml-2 -mt-0.5"/>
            </Link>
        </div>
    </footer>
</template>

<style src="./style.scss" lang="scss" scoped/>
