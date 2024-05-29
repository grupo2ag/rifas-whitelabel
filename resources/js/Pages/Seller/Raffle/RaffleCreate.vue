<script setup>
import * as func from '@/Helpers/functions.js';
</script>

<script>
import * as func from '@/Helpers/functions.js'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import Error from "@/Components/Error/Error.vue";

import Input from '@/Components/FormElements/Input.vue';
import Button from '@/Components/Button/Button.vue';
import Select from '@/Components/FormElements/Select.vue';
import CurrencyInput from '@/Components/FormElements/CurrencyInput.vue';
import SwitchCheckbox from '@/Components/SwitchCheckbox/SwitchCheckbox.vue';
import {ClassicEditor} from '@ckeditor/ckeditor5-editor-classic';
import * as yup from "yup";
import {pt} from 'yup-locale-pt';

import {
    PlusCircleIcon,
    ArrowLeftIcon,
    XMarkIcon,
    DocumentTextIcon,
    PhotoIcon,
    PencilSquareIcon,
    ClockIcon,
    TrashIcon,
    StarIcon,
    InformationCircleIcon,
    TrophyIcon,
    TicketIcon,
    AdjustmentsHorizontalIcon,
    ReceiptPercentIcon
} from '@heroicons/vue/24/outline';
import UploadImage from "@/Components/UploadImage/UploadImage.vue";

import {Alignment} from '@ckeditor/ckeditor5-alignment';
import {Essentials} from '@ckeditor/ckeditor5-essentials';
import {Bold, Italic} from '@ckeditor/ckeditor5-basic-styles';
import {Link} from '@ckeditor/ckeditor5-link';
import {Paragraph} from '@ckeditor/ckeditor5-paragraph';
import {Font} from '@ckeditor/ckeditor5-font';
import {
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload
} from '@ckeditor/ckeditor5-image';
import {Base64UploadAdapter} from '@ckeditor/ckeditor5-upload';
import {RemoveFormat} from '@ckeditor/ckeditor5-remove-format';

import { ref } from 'vue';

const componentKey = ref(0);

const forceRender = () => {
    componentKey.value += 1;
};

export default {
    components: {
        AuthenticatedLayout,
        Input,
        Select,
        UploadImage,
        Button,
        SwitchCheckbox,
        CurrencyInput,
        PlusCircleIcon,
        ArrowLeftIcon,
        XMarkIcon,
        DocumentTextIcon,
        PhotoIcon,
        PencilSquareIcon,
        ClockIcon,
        TrashIcon,
        StarIcon,
        InformationCircleIcon,
        TrophyIcon,
        TicketIcon,
        AdjustmentsHorizontalIcon,
        ReceiptPercentIcon,
        Error,
    },
    props: {
        raffle: Object,
        quantity_numbers: Array
    },
    data() {
        return {
            form: {
                id: '',
                title: this.raffle ? this.raffle.title : '',
                link: this.raffle ? this.raffle.link : '',
                subtitle: this.raffle ? this.raffle.subtitle : '',
                total: null,
                quantity: this.raffle ? this.raffle.quantity : 100,
                price: this.raffle ? this.raffle : 0,
                type: this.raffle ? this.raffle.type : 'automatico',
                pix_expired: this.raffle ? this.raffle.pix_expired : '',
                minimum_purchase: this.raffle ? this.raffle.minimum_purchase : 1,
                maximum_purchase: this.raffle ? this.raffle.maximum_purchase : 10,
                description: this.raffle ? this.raffle.description : '',

                buyer_ranking: this.raffle ? this.raffle.buyer_ranking : 5,
                partial: this.raffle ? this.raffle.partial : 1,
                expected_date: this.raffle ? func.dateFormat(this.raffle.expected_date) : '',
                status: this.raffle ? this.raffle.status : 'Ativo',
                banner: this.raffle ? this.raffle.banner : '',
                highlight: this.raffle ? this.raffle.highlight : 0,

                gallery: this.raffle ? this.raffle.gallery : [],

                quotas: this.raffle ? this.raffle.gallery : [],

                awards: [{description: ''}],
                // awards: [],
                processing: false
            },
           /* validator: {
                id: '',
                title: '',
                image: '',
                description: '',
                galleries: ''
            },*/
            editorType: ClassicEditor,
            editorConfig: {
                plugins: [
                    Alignment,
                    Essentials,
                    Bold,
                    Italic,
                    Link,
                    Font,
                    Paragraph,
                    Image,
                    ImageCaption,
                    ImageStyle,
                    ImageToolbar,
                    ImageUpload,
                    Base64UploadAdapter,
                    RemoveFormat,
                ],
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        '|',
                        'alignment',
                        '|',
                        'fontColor',
                        'fontBackgroundColor',
                        '|',
                        'removeFormat',
                    ]
                },
                language: 'pt-BR',
            },
            characterLenght: 0,
            characterLenght2: 0,
            number_quota: null,
            imageGallery: this.raffle ? this.raffle.galery : '',
            validator: {
                title: '',
                subtitle: '',
                price: 0,
                pix_expired: '',
                description: '',
                expected_date: '',
                'awards[0].description': '',
            },
            today: new Date()
        }
    },
    methods: {
        onSubmit() {
            const form = useForm(this.form)

            Object.keys(this.validator).forEach(key => {
                this.validator[key] = ''
            })

            this.schema
                .validate(this.form, {abortEarly: false}).then(() => {
                    this.form.processing = true;

                form.post(route('raffles.raffleStore'), {
                    onSuccess: () => {
                        this.disabled = false
                        this.loading = false
                    },
                    onError: () => {
                        this.disabled = false
                        this.loading = false
                    }
                })

            }).catch((err) => {
                this.form.processing = false;

                console.log(err)
                // console.log(err.inner)
                // document.getElementById(err.inner[0].path).scrollIntoView();

                err.inner.forEach((error) => {
                    console.log(error )
                    this.validator = {...this.validator, [error.path]: error.message};
                });
            });
        },
        countdown() {
            if (this.form.title || this.form.subtitle) {
                this.characterLenght = this.form.title.length;
                this.characterLenght2 = this.form.subtitle.length;
            }
        },
        addAwards() {
            this.form.awards.push({description: null, order: null})
        },
        removeAwards(index) {
            this.form.awards.splice(index, 1);
        },
        addQuota() {
            let num = this.number_quota
            this.form.quotas.push(num)
            this.number_quota = ''
        },
        removeQuota(item){
            console.log(item)
            for (let i = this.form.quotas.length; i--;) {
                if (this.form.quotas[i] === item) {
                    this.form.quotas.splice(i, 1);
                }
            }
        },
        addImage(gallery) {
            let imageReader = '';

            const reader = new FileReader();

            const imageCurrentAdd = {
                image: reader.result
            }

            reader.onload = () => {
                imageReader = reader.result
                imageCurrentAdd.image = imageReader
                gallery.push(imageCurrentAdd)
                this.imageGallery = '';
            };
            reader.readAsDataURL(this.imageGallery)
            forceRender()
        },
        removeImage(item) {
            for (let i = this.form.gallery.length; i--;) {
                if (this.form.gallery[i].image === item) {
                    this.form.gallery.splice(i, 1);
                }
            }
        },
    },
    watch: {
        "form.title"() {
            const text = func.clieanString(this.form.title)
            this.form.link = text.toLowerCase().split(' ').filter(item => item !== ' ' && item !== '').join('-');
        },
    },
    mounted() {
        yup.setLocale(pt);
        this.schema = yup.object().shape({
            title: yup.string().min(10, 'Digite ao menos 10 caracteres').max(80, 'Digite ao máximo 80 caracteres').required('Obrigatório'),
            subtitle: yup.string().min(5, 'Digite ao menos 5 caracteres').max(160, 'Digite ao máximo 160 caracteres').required('Obrigatório'),
            price: yup.number().positive().nullable(true).required('Obrigatório'),
            pix_expired: yup.string().required('Obrigatório'),
            description: yup.string().required('Obrigatório'),
            expected_date: yup.string().required('Obrigatório'),
            awards: yup.array().of(
                yup.object().shape({
                    description: yup.string().required('Obrigatório')
                })
            ).min(1, '1 no minimo').required('Obrigatório')

        })
    }
}
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Rifa
            </h2>
        </template>

        <div class="w-full py-5 md:container lg:w-6/12">
            <form @submit.prevent="onSubmit">
                <div class="mb-4 c-content" ref="geral">
                    <div class="flex items-center justify-between w-full pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <TicketIcon class="h-5 mr-1 stroke-neutral"/>

                            <h3 class="text-base font-semibold text-neutral">Informações da Rifa</h3>
                        </div>

                        <Button :href="route('raffles.raffleIndex')" size="sm" color="outline-light">
                            <ArrowLeftIcon class="w-4 mr-2 fill-white"/> Voltar
                        </Button>
                    </div>

                    <div class="w-full pt-3">
                        <div class="w-full">
                            <Input label="Nome:" v-model="form.title"
                                   type="text" name="title"
                                   :maxlength="80"
                                   v-on:keyup="countdown"
                                   :error="validator.title || $page.props.errors.title"
                                   placeholder="Insira o nome"/>

                            <p class="px-2 mb-2 -mt-2 text-xs text-neutral/70">
                                {{ characterLenght }} de 80
                                caracteres</p>
                        </div>

                        <div class="w-full">
                            <div class="box-url">
                                <label
                                    class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">Url
                                    amigável:</label>

                                <div class="box-url__content">
                                    <span
                                        class="overflow-hidden text-neutral/70 text-ellipsis">https://{{
                                            $page.props.siteconfig.domain
                                        }}/{{ form.link }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <Input label="Subtítulo:" v-model="form.subtitle"
                                   type="text" name="subtitle"
                                   :maxlength="160"
                                   v-on:keyup="countdown"
                                   :error="validator.subtitle || $page.props.errors.subtitle"
                                   placeholder="Digite o subtítulo"/>

                            <p class="px-2 mb-2 -mt-2 text-xs text-neutral/70">
                                {{ characterLenght2 }} de 160
                                caracteres</p>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Select label="Quantidade de Números:" v-model="form.quantity" name="quantity" :error="validator.total || $page.props.errors.total">
                                    <option v-for="(item, index) in quantity_numbers" :key="index" :value="item.value"
                                    >{{ item.texto }}</option>
                                </Select>
                            </div>

                            <div class="w-full md:w-6/12">
                                <CurrencyInput label="Valor" v-model="form.price" name="price"
                                               :error="validator.price || $page.props.errors.price"/>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Select label="Tipo de Reserva:" v-model="form.type" name="type">
                                    <option value="automatico">
                                        Automático (Aleatório)
                                    </option>
                                    <option value="manual">
                                        Manual (Selecionável)
                                    </option>
                                </Select>
                            </div>

                            <div class="w-full md:w-6/12">
                                <Select label="Tempo de expiração (min):" v-model="form.pix_expired"
                                        name="pix_expired"
                                        :error="validator.pix_expired || $page.props.errors.pix_expired">
                                    <option value="5">
                                        5 minutos (recomendado)
                                    </option>
                                    <option value="10">
                                        10 minutos
                                    </option>
                                    <option value="30">
                                        30 minutos
                                    </option>
                                    <option value="60">
                                        1 hora
                                    </option>
                                    <option value="1440">
                                        1 dia
                                    </option>
                                    <option value="10080">
                                        1 semana
                                    </option>
                                    <option value="43200">
                                        1 mês
                                    </option>
                                </Select>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Input label="Qtd mínima de compra:" v-model="form.minimum_purchase"
                                       type="number" :name="form.minimum_purchase"
                                       :error="validator.minimum_purchase || $page.props.errors.minimum_purchase"
                                       placeholder="0"/>
                            </div>

                            <div class="w-full md:w-6/12">
                                <Input label="Qtd maxima de compra:" v-model="form.maximum_purchase"
                                       type="number" :name="form.maximum_purchase"
                                       :error="validator.maximum_purchase || $page.props.errors.maximum_purchase"
                                       placeholder="0"/>
                            </div>
                        </div>

                        <div class="relative w-full pt-3" id="description" :class="[!!validator.description ? 'ck-error' :  '']">
                            <label
                                class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">Regulamento:</label>

                            <ckeditor :editor="editorType" v-model="form.description"
                                      :config="editorConfig" class="text-neutral"
                                      ></ckeditor>

                            <Error :message="validator.description"/>
                        </div>
                    </div>
                </div>

                <div class="mb-4 c-content">
                    <div class="flex items-center pb-2 border-b border-base-100">
                        <AdjustmentsHorizontalIcon class="h-5 mr-1 stroke-neutral dark:stroke-white"/>

                        <h3 class="text-base font-semibold text-neutral">Ajustes do Sorteio</h3>
                    </div>

                    <div class="pt-3">
                        <div class="flex flex-col gap-4 md:flex-row">
                            <div class="w-full md:w-6/12">
                                <Input label="Data prevista do Sorteio" type="date" :min="func.dateFormatInvert(today)"
                                       name="expected_date" class="appearance-none"
                                       :error="validator.expected_date || $page.props.errors.date"
                                       placeholder="dd/mm/aaaa" v-model="form.expected_date"/>
                            </div>

                            <div class="w-full md:w-6/12">
                                <Select label="Status:" v-model="form.status" :name="form.status"
                                        :error="validator.status || $page.props.errors.status">
                                    <option value="Ativo">
                                        Ativo
                                    </option>
                                    <option value="Finalizado">
                                        Finalizado
                                    </option>
                                </Select>
                            </div>
                        </div>

                        <template v-if="form.status === 'Ativo'">
                            <div class="flex flex-col md:flex-row md:gap-4">
                                <div class="w-full md:w-6/12">
                                    <Select label="Mostrar Parcial (%):" v-model='form.partial' :name="form.partial"
                                            :error="validator.partial || $page.props.errors.partial">
                                        <option value="1">
                                            Sim
                                        </option>
                                        <option selected value="0">
                                            Não
                                        </option>
                                    </Select>
                                </div>

                                <div class="w-full md:w-6/12">
                                    <Input label="Ranking de compradores (Qtd):" v-model="form.buyer_ranking"
                                           type="number" :name="form.buyer_ranking"
                                           :error="validator.buyer_ranking || $page.props.errors.buyer_ranking"
                                           placeholder="0"/>
                                </div>
                            </div>

                            <div class="flex flex-col gap-6 md:flex-row">
                                <div class="relative w-full md:w-6/12">
                                    <UploadImage :imgCurrent="form.banner"
                                                 name="image-notice"
                                                 v-model="form.banner"
                                                 label="Banner de Destaque"
                                                 size="aspect-56"
                                                 formats="JPEG ou PNG"
                                                 recommended="768x560"
                                                 filesize="2MB"
                                                 :accept="'image/png,image/jpg,image/jpeg,image/webp'"/>
                                </div>

                                <div class="relative w-full pt-3 md:w-6/12">
                                    <SwitchCheckbox label="Destaque na página inicial" v-model="form.highlight"
                                                    side="left" id="activeExclusive"/>

                                    <div class="w-full p-1.5 bg-warning flex items-center mt-6 rounded-lg">
                                        <InformationCircleIcon class="mr-1 h-7 stroke-black dark:stroke-white"/>

                                        <p class="flex-1 pr-3 text-xs text-warning-bw">
                                            Ao deixar habilitado a Rifa aparecerá
                                            na area de destaque na pagina principal do site
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mb-4 c-content" ref="ajustes">
                    <div class="flex items-center pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <TrophyIcon class="h-5 mr-1 stroke-neutral"/>

                            <h3 class="text-base font-semibold text-neutral">
                                {{ form.status === 'Ativo' ? 'Prêmios' : 'Ganhadores' }} </h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">
                        <div v-if="form.status === 'Ativo'" class="flex flex-col items-end gap-4 md:flex-row">
                            <div class="grid w-full grid-cols-1">
                                <div v-for="(item, index) in form.awards" :key="index" class="flex items-center gap-3">
                                    <span class="w-6 text-lg text-right text-neutral">{{ index + 1 }}˚</span>

                                    <Input label="Prêmio:" v-model="item.description"
                                           type="text" :name="item.description" class="flex-1"
                                           :placeholder="'Preencha o ' + (index + 1) + '˚ prêmio'"/>

                                    <div class="w-12">
                                        <Button v-if="index !== 0" type="button" @click="removeAwards(index)"
                                                color="outline-red">
                                            <TrashIcon class="h-5"/>
                                        </Button>
                                    </div>
                                </div>

                                <Error :message="validator['awards[0].description']"/>


                                <div class="flex items-center w-full gap-3">
                                    <div class="w-6"></div>

                                    <Button type="button" color="primary" class="flex-1" @click="addAwards">
                                        Adicionar Prêmio
                                    </Button>

                                    <div class="w-12"></div>
                                </div>
                            </div>
                        </div>

                        <template v-if="form.status === 'Finalizado'">
                            <template v-for="(item, index) in form.awards" :key="index">
                                <div class="flex flex-col items-center gap-4 md:flex-row">
                                    <p class="text-right text-neutral">{{ index + 1 }}˚ Prêmio</p>

                                    <div class="flex-1">
                                        <Input label="Ganhador:" v-model="item.description"
                                               type="text" :name="item.description"
                                               :error="validator.awards || $page.props.errors.awards"
                                               placeholder="Digite o nome do ganhador"/>
                                    </div>

                                    <div class=" md:w-3/12">
                                        <Input label="Número do Ganhador:" v-model="item.number"
                                               type="text" :name="item.number"
                                               :error="validator.awards || $page.props.errors.awards"
                                               placeholder="Digite o número"/>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>

                <div class="hidden mb-4 c-content">
                    <div class="flex items-center pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <ReceiptPercentIcon class="h-5 mr-1 stroke-neutral"/>

                            <h3 class="text-base font-semibold text-neutral">Promoção</h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Input label="Qtd de números:" v-model="form.minimum_purchase"
                                       type="number" :name="form.minimum_purchase"
                                       :error="validator.minimum_purchase || $page.props.errors.minimum_purchase"
                                       placeholder="0"/>
                            </div>

                            <div class="w-full md:w-6/12">
                                <CurrencyInput label="Valor de Desconto"
                                               v-model="form.price"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden mb-4 c-content">
                    <div class="flex items-center pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <ReceiptPercentIcon class="h-5 mr-1 stroke-neutral"/>

                            <h3 class="text-base font-semibold text-neutral">Quota Premiada</h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">
                        <div class="flex flex-col items-start md:flex-row md:gap-4">
                            <div class="flex items-center w-full gap-2 md:w-6/12">
                                <Input label="Número da Cota Prêmiada:" v-model="number_quota"
                                       type="number" :name="number_quota"
                                       placeholder="0" class="w-8/12"/>

                                <Button type="button" @click="addQuota()" class="flex-1 " color="primary">
                                    Adicionar Cotas
                                </Button>
                            </div>

                            <div class="relative w-full md:w-6/12">
                                <div class="w-full">
                                    <div class="box-url">
                                        <label
                                            class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">
                                            Lista das cotas premiadas :
                                        </label>

                                        <div
                                            class="box-url__content min-h-[46px] flex flex-wrap items-center gap-2">
                                            <template v-for="(item, index) in form.quotas" :key="index">
                                                <div
                                                    class="w-20  border border-primary px-3 py-1.5 flex items-center justify-between rounded-md gap-1">
                                                    <p class="text-xs uppercase text-primary">
                                                        {{ item }}
                                                    </p>
                                                    <button type="" @click="removeQuota(item)"
                                                            aria-label="Excluir Número">
                                                        <TrashIcon class="stroke-primary h-[14px]"/>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 c-content">
                    <div class="flex items-center pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <PhotoIcon class="h-5 mr-1 stroke-neutral"/>

                            <h3 class="text-base font-semibold text-neutral">Galeria de Fotos</h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">
                        <div class="flex flex-col gap-4 md:flex-row">
                            <div class="w-full">
                                <div class="flex flex-col md:flex-row md:gap-4">
                                    <div class="relative flex flex-col items-center w-3/12">
                                        <UploadImage imgCurrent=""
                                                     label="Imagem"
                                                     size="aspect-1"
                                                     class="mt-1"
                                                     v-model="imageGallery"
                                                     recommended="500x500"
                                                     :key="componentKey"
                                                     filesize="2MB" name="image-galery"/>

                                        <Button type="button" @click="addImage(form.gallery)"
                                                class="w-full mt-2"
                                                size="sm" color="primary">Adicionar Imagem
                                        </Button>
                                    </div>
                                    <div class="flex-1">
                                        <p class="w-full text-sm font-medium rounded-md text-neutral">
                                            Galeria:</p>
                                        <div
                                            class="grid flex-wrap grid-cols-5 gap-2 pt-3 border-t border-gray-light dark:border-bgadm-light">
                                            <div v-for="(item, index) in form.gallery" :key="index"
                                                 class="relative">
                                                <div class="absolute w-full h-full transition-all opacity-0 cursor-pointer cover-remove hover:opacity-100">
                                                    <button type="button"
                                                            @click="removeImage(item.image)"
                                                            class="block p-1 m-2 ml-auto rounded-full bg-red hover:bg-red-dark">
                                                        <TrashIcon class="w-4 h-4 stroke-white"/>
                                                    </button>
                                                </div>
                                                <img class="object-cover w-full h-full" :src="item.image" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-content">
                    <div class="flex justify-end gap-4" v-if="$page.props.message">
                        <p>{{ $page.props.message }}</p>
                    </div>
                    <div class="flex justify-end gap-4" v-else>
                        <Button :href="route('raffles.raffleIndex')" size="sm" color="outline-light">
                            Cancelar
                        </Button>
                        <Button type="button" @click="onSubmit" color="success" :loading="loading" :disabled="disabled">
                            Salvar
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
:root {
    --ck-border-radius: 10px;
}

.ck.ck-editor {
    @apply text-black
}

.ck-editor__editable {
    min-height: 200px;
}

.box-url {
    @apply py-3 relative cursor-not-allowed;

    &__content {
        @apply block px-3 pb-2 pt-3 text-base bg-content w-full text-neutral border border-white-dark rounded-xl focus:outline-none focus:ring-0 focus:border-blue
    }
}

.c-content {
    //@apply hidden;

    &.active {
        @apply block
    }
}


.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.ck-error{
    --ck-color-base-border: red;
}

:root{
    --ck-color-base-background: rgb(var(--content));
    --ck-color-text: rgb(var(--neutral));
    --ck-custom-background: rgb(var(--content));
    --ck-custom-border: rgb(var(--neutral) / 0.4);
    --ck-color-base-border: rgb(var(--neutral) / 0.4);
    --ck-custom-white: rgb(var(--content));
}

:root {

    /* Helper variables to avoid duplication in the colors. */


    /* -- Overrides generic colors. ------------------------------------------------------------- */

    --ck-color-base-foreground: var(--ck-custom-background);
    --ck-color-focus-border: hsl(208, 90%, 62%);
    --ck-color-shadow-drop: hsla(0, 0%, 0%, 0.2);
    --ck-color-shadow-inner: hsla(0, 0%, 0%, 0.1);

    /* -- Overrides the default .ck-button class colors. ---------------------------------------- */

    --ck-color-button-default-background: var(--ck-custom-background);
    --ck-color-button-default-hover-background: hsl(270, 1%, 22%);
    --ck-color-button-default-active-background: hsl(270, 2%, 20%);
    --ck-color-button-default-active-shadow: hsl(270, 2%, 23%);
    --ck-color-button-default-disabled-background: var(--ck-custom-background);

    --ck-color-button-on-background: var(--ck-custom-foreground);
    --ck-color-button-on-hover-background: hsl(255, 4%, 16%);
    --ck-color-button-on-active-background: hsl(255, 4%, 14%);
    --ck-color-button-on-active-shadow: hsl(240, 3%, 19%);
    --ck-color-button-on-disabled-background: var(--ck-custom-foreground);

    --ck-color-button-action-background: hsl(168, 76%, 42%);
    --ck-color-button-action-hover-background: hsl(168, 76%, 38%);
    --ck-color-button-action-active-background: hsl(168, 76%, 36%);
    --ck-color-button-action-active-shadow: hsl(168, 75%, 34%);
    --ck-color-button-action-disabled-background: hsl(168, 76%, 42%);
    --ck-color-button-action-text: var(--ck-custom-white);

    --ck-color-button-save: hsl(120, 100%, 46%);
    --ck-color-button-cancel: hsl(15, 100%, 56%);

    /* -- Overrides the default .ck-dropdown class colors. -------------------------------------- */

    --ck-color-dropdown-panel-background: var(--ck-custom-background);
    --ck-color-dropdown-panel-border: var(--ck-custom-foreground);

    /* -- Overrides the default .ck-dialog class colors. ----------------------------------- */

    --ck-color-dialog-background: var(--ck-custom-background);
    --ck-color-dialog-form-header-border: var(--ck-custom-border);

    /* -- Overrides the default .ck-splitbutton class colors. ----------------------------------- */

    --ck-color-split-button-hover-background: var(--ck-color-button-default-hover-background);
    --ck-color-split-button-hover-border: var(--ck-custom-foreground);

    /* -- Overrides the default .ck-input class colors. ----------------------------------------- */

    --ck-color-input-background: var(--ck-custom-background);
    --ck-color-input-border: hsl(257, 3%, 43%);
    --ck-color-input-text: hsl(0, 0%, 98%);
    --ck-color-input-disabled-background: hsl(255, 4%, 21%);
    --ck-color-input-disabled-border: hsl(250, 3%, 38%);
    --ck-color-input-disabled-text: hsl(0, 0%, 78%);

    /* -- Overrides the default .ck-labeled-field-view class colors. ---------------------------- */

    --ck-color-labeled-field-label-background: var(--ck-custom-background);

    /* -- Overrides the default .ck-list class colors. ------------------------------------------ */

    --ck-color-list-background: var(--ck-custom-background);
    --ck-color-list-button-hover-background: var(--ck-color-base-foreground);
    --ck-color-list-button-on-background: var(--ck-color-base-active);
    --ck-color-list-button-on-background-focus: var(--ck-color-base-active-focus);
    --ck-color-list-button-on-text: var(--ck-color-base-background);

    /* -- Overrides the default .ck-balloon-panel class colors. --------------------------------- */

    --ck-color-panel-background: var(--ck-custom-background);
    --ck-color-panel-border: var(--ck-custom-border);

    /* -- Overrides the default .ck-toolbar class colors. --------------------------------------- */

    --ck-color-toolbar-background: var(--ck-custom-background);
    --ck-color-toolbar-border: var(--ck-custom-border);

    /* -- Overrides the default .ck-tooltip class colors. --------------------------------------- */

    --ck-color-tooltip-background: hsl(252, 7%, 14%);
    --ck-color-tooltip-text: hsl(0, 0%, 93%);

    /* -- Overrides the default colors used by the ckeditor5-image package. --------------------- */

    --ck-color-image-caption-background: hsl(0, 0%, 97%);
    --ck-color-image-caption-text: hsl(0, 0%, 20%);

    /* -- Overrides the default colors used by the ckeditor5-widget package. -------------------- */

    --ck-color-widget-blurred-border: hsl(0, 0%, 87%);
    --ck-color-widget-hover-border: hsl(43, 100%, 68%);
    --ck-color-widget-editable-focus-background: var(--ck-custom-white);

    /* -- Overrides the default colors used by the ckeditor5-link package. ---------------------- */

    --ck-color-link-default: hsl(190, 100%, 75%);
}

.ck.ck-editor__main > .ck-editor__editable{
    @apply text-neutral;
}
</style>
