<script setup>
// import Welcome from '@/Components/Welcome.vue';
</script>

<script>
import * as func from '@/Helpers/functions.js'

import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/FormElements/Input.vue';
import Button from '@/Components/Button/Button.vue';
import Select from '@/Components/FormElements/Select.vue';
import CurrencyInput from '@/Components/FormElements/CurrencyInput.vue';
import SwitchCheckbox from '@/Components/SwitchCheckbox/SwitchCheckbox.vue';
import {ClassicEditor} from '@ckeditor/ckeditor5-editor-classic';
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

export default {
    components: {
        AppLayout,
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
        AdjustmentsHorizontalIcon
    },
    props: {
        raffle: Object
    },
    data() {
        return {
            form: {
                id: '',
                title: '',
                link: '',
                subtitle: '',
                total: null,
                price: 0,
                type: 'aleatorio',
                pix_expired: 5,
                minimum_purchase: 1,
                maximum_purchase: 10,
                description: '',

                buyer_ranking: 5,
                partial: 1,
                finish_at: '',
                status: 'Ativo',
                banner: '',
                highlight: 0,



            },
            currentGallery: {
                id: 'gallery-1',
                images: [],
                active: false,
            },
            validator: {
                id: '',
                title: '',
                subtitle: '',
                image: '',
                description: '',
                url: '',
                galleries: ''
            },
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
            awards: [{
                description: null, order: null
            }]
        }
    },
    methods: {
        countdown() {
            if (this.form.title || this.form.subtitle) {
                this.characterLenght = this.form.title.length;
                this.characterLenght2 = this.form.subtitle.length;
            }
        },
        addAwards() {
            this.awards.push({ value: null, comission: null, date: null})
        },
        removeAwards(index) {
            console.log(index)

            this.awards.splice(index, 1);
           // this.awards.push({ value: null, comission: null, date: null})
        },
    },
    watch: {
        "form.title" () {
            const text =  func.clieanString(this.form.title)
            this.form.link = text.toLowerCase().split(' ').filter(item => item !== ' ' && item !== '' ).join('-');
        },
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rifa
            </h2>
        </template>

        <div class="py-5 md:container w-full lg:w-6/12">
            <form @submit.prevent="onSubmit">
                <div class="c-content my-4">
                    <div class="pb-2 flex items-center border-b border-base-100">
                        <TicketIcon class="h-5 stroke-neutral mr-1"/>

                        <h3 class="text-neutral font-semibold text-base">Informações da Rifa</h3>
                    </div>

                    <div class="w-full pt-3">
                        <div class="w-full">
                            <Input label="Nome:" v-model="form.title"
                                   type="text" :name="form.title"
                                   :maxlength="80"
                                   v-on:keyup="countdown"
                                   :error="validator.title || $page.props.errors.title"
                                   placeholder="Insira o nome"/>

                            <p class="px-2 text-xs text-neutral/70 -mt-2 mb-2">
                                {{ characterLenght }} de 80
                                caracteres</p>
                        </div>

                        <div class="w-full">
                            <div class="box-url">
                                <label class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">Url amigável:</label>

                                <div class="box-url__content">
                                    <span class="overflow-hidden text-neutral/70 text-ellipsis">https://{{$page.props.siteconfig.domain}}/{{form.link}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <Input label="Subtítulo:" v-model="form.subtitle"
                                   type="text" :name="form.subtitle"
                                   :maxlength="160"
                                   v-on:keyup="countdown"
                                   :error="validator.subtitle || $page.props.errors.subtitle"
                                   placeholder="Digite o subtítulo"/>

                            <p class="px-2 text-xs text-neutral/70 -mt-2 mb-2">
                                {{ characterLenght2 }} de 160
                                caracteres</p>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Select label="Quantidade de Números:" v-model="form.total" :name="form.total"
                                        :error="validator.total || $page.props.errors.total">
                                    <option value="10">
                                        10 Bilhetes - (0 à 9)
                                    </option>
                                </Select>
                            </div>

                            <div class="w-full md:w-6/12">
                                <CurrencyInput label="Valor" v-model="form.price" />
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <div class="w-full md:w-6/12">
                                <Select label="Tipo de Reserva:" v-model="form.type" :name="form.type"
                                        :error="validator.type || $page.props.errors.type">
                                    <option value="aleatorio">
                                        Aleatório
                                    </option>
                                    <option value="manual">
                                        Manual
                                    </option>
                                </Select>
                            </div>

                            <div class="w-full md:w-6/12">
                                <Select label="Tempo de expiração (min):" v-model="form.pix_expired" :name="form.pix_expired"
                                        :error="validator.pix_expired || $page.props.errors.pix_expired">
                                    <option value="5">
                                        5 minutos
                                    </option>
                                    <option value="10">
                                        10 minutos
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

                        <div class="w-full pt-3 relative">
                            <label
                                class="px-2 block text-neutral/70 text-[13px] font-medium absolute top-[3px] left-1 z-10 bg-content">Descrição:</label>

                            <ckeditor :editor="editorType" v-model="form.description" :config="editorConfig"></ckeditor>

                            <div v-if="validator.description || $page.props.errors.description" class="inline-block">
                                <p class="text-xs bg-red text-white py-1 px-2 rounded">
                                    {{ validator.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-content my-4">
                    <div class="pb-2 flex items-center border-b border-base-100">
                        <AdjustmentsHorizontalIcon class="h-5 stroke-neutral dark:stroke-white mr-1"/>

                        <h3 class="text-neutral font-semibold text-base">Ajustes do Sorteio</h3>
                    </div>

                    <div class="pt-3">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-6/12">
                                <Input label="Data do Sorteio" type="date"
                                       :name="form.finish_at" class="appearance-none"
                                       :error="validator.finish_at || $page.props.errors.date"
                                       placeholder="dd/mm/aaaa" v-model="form.finish_at"/>
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

                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-full md:w-6/12 relative">
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

                                <div class="w-full md:w-6/12 pt-3 relative">
                                    <SwitchCheckbox label="Destaque na página inicial" v-model="form.highlight" side="left" id="activeExclusive"/>

                                    <div class="w-full p-1.5 bg-warning flex items-center mt-6 rounded-lg">
                                        <InformationCircleIcon class="h-7 stroke-black dark:stroke-white mr-1"/>

                                        <p class="flex-1 text-xs text-warning-bw pr-3">
                                            Ao deixar habilitado a Rifa aparecerá
                                            na area de destaque na pagina principal do site
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template v-if="form.status === 'Finalizado'">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-6/12">
                                    <Input label="Ganhador:" v-model="form.title"
                                           type="text" :name="form.title"
                                           :error="validator.title || $page.props.errors.title"
                                           placeholder="Digite o nome do ganhador"/>
                                </div>

                                <div class="w-full md:w-6/12">
                                    <Input label="Número do Ganhador:" v-model="form.title"
                                           type="text" :name="form.title"
                                           :error="validator.title || $page.props.errors.title"
                                           placeholder="Digite o número do ganhador"/>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="c-content my-4">
                    <div class="pb-2 flex items-center border-b border-base-100">
                        <div class="flex items-center">
                            <TrophyIcon class="h-5 stroke-neutral mr-1"/>

                            <h3 class="text-neutral font-semibold text-base">Prêmios</h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">
                        <div class="flex flex-col items-end md:flex-row gap-4">
                            <div class="w-full grid grid-cols-1 ">
                                <div v-for="(item, index) in awards" :key="index" class="flex items-center gap-3">
                                    <span class="w-6 text-neutral text-right text-lg">{{ index + 1 }}˚</span>
                                    <Input label="Prêmio:" v-model="item.description"
                                           type="text" :name="item.description" class="flex-1"
                                           :placeholder="'Digite o ' + (index + 1) + '˚ prêmio'"/>

                                    <div class="w-12">
                                        <Button v-if="index !== 0" type="button" @click="removeAwards(index)" color="outline-red">
                                            <TrashIcon class="h-5"/>
                                        </Button>
                                    </div>
                                </div>

                                <div class="w-full flex items-center gap-3">
                                    <div class="w-6"></div>

                                    <Button type="button" color="primary" class="flex-1" @click="addAwards">
                                        Adicionar Prêmio
                                    </Button>

                                    <div class="w-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






                <div class="c-content my-4 hidden">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center">
                            <ClockIcon class="h-5 stroke-black dark:stroke-white mr-1"/>

                            <h3 class="text-black dark:text-white font-semibold text-base">Agenda Publicação</h3>
                        </div>
                    </div>

                    <div ref="publish" class="w-full">
                        <div class="pt-6 mt-2 border-t border-gray-light dark:border-bgadm-light">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-6/12">
                                    <Input label="Data de publicação" type="date"
                                           name="date" class="appearance-none"
                                           error="errors.date || $page.props.errors.date"
                                           placeholder="dd/mm/aaaa" v-model="form.date"/>
                                </div>
                                <div class="w-full md:w-6/12">
                                    <Input label="Horário de publicação" type="time"
                                           name="time" class="appearance-none"
                                           error="errors.time || $page.props.errors.time"
                                           v-model="form.time"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-content my-4">
                    <div class="pb-2 flex items-center border-b border-base-100">
                        <div class="flex items-center">
                            <PhotoIcon class="h-5 stroke-neutral mr-1"/>

                            <h3 class="text-neutral font-semibold text-base">Galeria de Fotos</h3>
                        </div>
                    </div>

                    <div class="w-full pt-3">
                        <div class="flex flex-col md:flex-row gap-4 pb-4">
                            <div class="w-full">
                                <div class="flex flex-col md:flex-row md:gap-4">
                                    <div class="w-3/12 flex flex-col items-center relative">
                                        <UploadImage imgCurrent=""
                                                     label="Imagem"
                                                     size="aspect-1"
                                                     class="mt-1"
                                                     v-model="imageGallery"
                                                     recommended="500x500"
                                                     filesize="2MB" name="image-galery"/>

                                        <Button type="button" @click="addImageOn(currentGallery)" class="w-full mt-2"
                                                size="sm" color="primary">Adicionar Imagem
                                        </Button>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-sm w-full text-neutral rounded-md">
                                            Galeria:</p>

                                        <div
                                            class="pt-3 grid grid-cols-5 gap-2 flex-wrap border-t border-gray-light dark:border-bgadm-light">

                                            <button type="button"
                                                    class="px-3 border w-full aspect-[4/4] border border-neutral/60 text-neutral text-xs uppercase rounded-lg">
                                                Nova Imagem
                                            </button>

                                            <div v-for="(image, index) in currentGallery.images" :key="index"
                                                 class="relative">
                                                <div @click="setEditImage(image)"
                                                     class="cover-remove absolute w-full h-full opacity-0 hover:opacity-100 transition-all cursor-pointer">
                                                    <button type="button"
                                                            @click="removeImgOnGallery(currentGallery.images, index)"
                                                            class="p-1 m-2 bg-red rounded-full block ml-auto hover:bg-red-dark">
                                                        <TrashIcon class="stroke-white w-4 h-4"/>
                                                    </button>
                                                </div>
                                                <img class="object-cover w-full h-full" :src="image.image" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-content">
                    <div class="flex justify-end gap-4">
                        <Button :href="route('raffles')" size="sm" color="outline-light">
                            Cancelar
                        </Button>
                        <Button type="button" @click="onSubmit" color="success" :loading="loading" :disabled="disabled">
                            Salvar
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
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
.box-url{
    @apply py-3 relative cursor-not-allowed;

    &__content{
        @apply block px-3 pb-2 pt-3 text-base bg-content w-full text-neutral border border-white-dark rounded-xl focus:outline-none focus:ring-0 focus:border-blue
     }
}
</style>
