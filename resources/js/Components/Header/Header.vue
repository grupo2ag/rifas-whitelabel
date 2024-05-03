<script>
import {Inertia} from "@inertiajs/inertia";
import Icon from "@/Components/Icon/Icon.vue";
import Button from "@/Components/Button/Button.vue";
import Input from "@/Components/FormElements/Input.vue";
import DropdownBalance from '@/Components/DropdownBalance.vue';
import DropdownBalanceLink from '@/Components/DropdownBalanceLink.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {defineComponent} from 'vue'
import {useMediaQuery} from '@vueuse/core'

export default defineComponent({
    name: "Header",
    components: {
        Icon,
        Link,
        Button,
        DropdownBalance,
        DropdownBalanceLink,
        DropdownLink,
        Input
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
        goto(hash, position) {
            if (route().current('index')) {
                var element = document.getElementById(hash);
                var headerOffset = this.isLargeScreen ? position : 0;

                var elementPosition = element.offsetTop;
                var offsetPosition = elementPosition - headerOffset;
                document.documentElement.scrollTop = offsetPosition;
                document.body.scrollTop = offsetPosition; // For Safari
                //this.$emit('close', false)
            } else {
                window.localStorage.setItem('anchorMenu', hash)

                window.localStorage.setItem('positionMenu', position)

                Inertia.visit(route('index'))
            }
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
                <div class="w-auto flex items-center gap-4">
                    <button type="button" class="c-header-mb__item o-hamburguer lg:hidden" :class="[isActive ? 'active' : '']"
                            @click="toggleHumburger()">
                        <div class="trace">
                            <span></span>
                        </div>
                    </button>

                    <a :href="route('index')" class="text-4xl uppercase text-primary font-black" :aria-label="$page.props.siteconfig.site_title">
                        <img v-if="$page.props.siteconfig.logo" :src="$page.props.siteconfig.logo" :alt="$page.props.siteconfig.site_title">
                        <span v-else>{{ 'RIFA8' }}</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="c-nav">
                        <button type="button" class="c-nav__item" @click="goto('hero', 0)">
                            Home
                        </button>

                        <button type="button" class="c-nav__item" @click="goto('drawn', 70)">
                            Sorteados
                        </button>
                    </div>

                    <DropdownBalance align="right">
                        <template #trigger>
                            <button type="button" class="c-nav__item c-nav__item--draft" @click="">
                                <Icon name="icon-bag"/> Meus Bilhetes
                            </button>
                        </template>

                        <template #content>
                            <div class="px-5 py-4">
                                <p class="text-neutral mb-2 pb-2 text-center border-b border-base-100">Buscar meus números</p>
                                <form @submit.prevent="">
                                    <div class="w-full">
                                        <Input type="tel" label="Telefone" name="form.phone" placeholder="(00) 00000-0000"
                                               autocomplete="tel" error=""
                                               v-mask="['(##) #####-####', '(##) ####-####']"/>
                                    </div>

                                    <div class="flex justify-center">
                                        <Button type="submit" color="primary" class="w-full" disabled="form.processing">
                                            Buscar
                                        </Button>
                                    </div>
                                </form>
                            </div>
                        </template>
                    </DropdownBalance>
                </div>
            </div>
        </div>

        <div class="c-sidebar-mb" :class="[isActive ? 'active' : '']">
            <div class="c-nav c-nav--vertical container pt-28 pb-16 relative">
                <button type="button" class="c-nav__item" @click="goto('hero', 0)">
                    Home
                </button>

                <button type="button" class="c-nav__item" @click="goto('drawn', 70)">
                    Sorteados
                </button>
            </div>
        </div>
    </header>
</template>

<style src="./style.scss" lang="scss" scoped/>
