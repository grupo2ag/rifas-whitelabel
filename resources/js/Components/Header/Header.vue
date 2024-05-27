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
import * as yup from "yup";

const cpfIsValid = function (cpf) {

    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    let add = 0;
    for (var i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    let rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (var i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;

    return true;
}

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
            isLargeScreen: useMediaQuery('(min-width: 768px)'),
            form:{
                cpf: '',
                processing: false,
            },
            validate: {
                cpf: '',
            },
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
        onSubmit(){
            this.schema
                .validate(this.form, {abortEarly: false}).then(() => {
                    this.form.processing = true;

                    this.$inertia.visit(route('account', this.form.cpf))

                }).catch((err) => {
                    this.form.processing = false;

                    err.inner.forEach((error) => {
                        this.validate = {...this.validate, [error.path]: error.message};
                    });
                });
        }
    },
    mounted() {
        this.verificaUrl()

        this.schema = yup.object().shape({
            cpf: yup.string().min(13, 'CPF incompleto').required('Obrigatório').test('test-invalid-cpf', 'CPF Inválido', value => cpfIsValid(value))
                .required('CPF é obrigatório'),
        })
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

                    <a :href="route('index')" :aria-label="$page.props.siteconfig.site_title">
                        <img v-if="!$page.props.siteconfig.logo"
                             :src="$page.props.siteconfig.logo"
                             class="h-6 md:h-7"
                             :alt="$page.props.siteconfig.site_title">
                        <img v-else src="/images/logo.svg" class="h-5 md:h-6"/>
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
                            <button type="button" @click="" class="c-nav__item c-nav__item--draft">
                                <Icon name="icon-bag"/> Meus Bilhetes
                            </button>
                        </template>

                        <template #content>
                            <div class="px-5 py-4">
                                <p class="text-neutral mb-2 pb-2 text-center border-b border-base-100">Buscar meus números</p>
                                <form @submit.prevent="onSubmit">
                                    <div class="w-full">
                                        <Input type="tel" label="CPF" :name="form.cpf" v-model="form.cpf"
                                               placeholder="000.000.000-00" :error="validate.cpf"
                                               v-mask="'###.###.###-##'"/>
                                    </div>

                                    <div class="flex justify-center">
                                        <Button type="submit" size="sm" color="primary" class="w-full"
                                                :disabled="form.processing" :loading="form.processing">
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
