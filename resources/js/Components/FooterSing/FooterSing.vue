<script>
import { defineComponent} from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import SocialMenu from "@/Components/SocialMenu/SocialMenu.vue";
import Icon from "@/Components/Icon/Icon.vue";
// import Cookies from "@/Components/Cookies/Cookies.vue"
// import Button from "@/Components/Button/Button.vue"
// const Cookies = defineAsyncComponent(() => import('@/Components/Cookies/Cookies.vue'))

export default defineComponent( {
    name: "FooterSing",
    components: {
        Icon,
        // Button,
        Link,
        SocialMenu,
        // Cookies
    },
    props: {
        backgroundColor: '',
        color: ''
    },
    data() {
        return {
            isChecked: this.initIsChecked()
        }
    },
    methods: {
        cookies(event) {
            this.isChecked = localStorage.setItem("isChecked", this.isChecked);
        },

        initIsChecked: function () {
            const stored = localStorage.getItem("isChecked");
            if (stored === null) {
                return true;
            } else {
                return stored == 'true';
            }
        }
    },
    watch: {
        isChecked: function () {
            localStorage.setItem("isChecked", this.isChecked);
        }
    }
})
</script>

<template>
    <footer class="pt-3">
        <div class="container">
            <div class="c-content grid grid-cols-1 md:grid-cols-4 gap-6">
                <aside>
                    <Link href="/" class="text-2xl uppercase text-primary font-black" aria-label="Astra Pay">
                        Rifa8
                    </Link>
                    <p class="text-sm text-neutral/70">Rifas 8 Ltd.<br>© {{ new Date().getFullYear()}} Todos os direitos reservados </p>
                </aside>
                <nav class="flex flex-col">
                    <h6 class="text-lg font-bold text-neutral mb-1">Suporte</h6>
                    <a class="text-neutral/70 flex items-center gap-1">WhatsApp <Icon name="icon-whatsapp" class="h-4 w-4 fill-neutral/70"/> </a>
                    <a class="text-neutral/70">email@email.com</a>
                </nav>
                <nav class="flex flex-col items-start">
                    <h6 class="text-lg font-bold text-neutral mb-1">Forma de Pagamento</h6>
                    <img src="/images/pix.svg" class="h-10" alt="">
<!--                        <Icon name="icon-pix2" class="h-10 fill-neutral"/>-->
                </nav>
                <nav class="flex flex-col">
                    <h6 class="text-lg font-bold text-neutral mb-1">Grupos</h6>
                    <SocialMenu/>
                </nav>
            </div>
        </div>

        <div class="container py-4 flex justify-center">
            <Link href="/" class="text-sm uppercase text-neutral font-black" aria-label="Astra Pay">
                PREMIO FACIL
            </Link>
        </div>
    </footer>

    <Cookies/>
</template>

<style src="./style.scss" lang="scss" scoped/>
