<script setup>
// import Welcome from '@/Components/Welcome.vue';
</script>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/FormElements/Input.vue';
import Button from '@/Components/Button/Button.vue';
import Select from '@/Components/FormElements/Select.vue';
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
    InformationCircleIcon
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
        PlusCircleIcon,
        ArrowLeftIcon,
        XMarkIcon,
        DocumentTextIcon,
        PhotoIcon,
        PencilSquareIcon,
        ClockIcon,
        TrashIcon,
        StarIcon,
        InformationCircleIcon
    },
    props: {
        raffle: Object
    },
    data() {
        return {
            form: {
                id: '',
                title: '',
                subtitle: '',
                image: '',
                description: '',
                url: '',
                galleries: ''
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
                        // 'mediaEmbed',
                        //'imageUpload',
                        'L8Button',
                        // 'sourceEditing',
                        'htmlEmbed',
                        'removeFormat',
                        // 'addGallery',
                        // 'removeGallery'
                    ]
                },
                /*   mediaEmbed: {
                       previewsInData: true,
                       providers: [
                           {
                               // hint: this is just for previews. Get actual HTML codes by making API calls from your CMS
                               name: 'iframely previews',

                               // Match all URLs or just the ones you need:
                               url: /.+/,

                               html: match => {
                                   const url = match[ 0 ];

                                   var iframeUrl = IFRAME_SRC + '?app=1&api_key=' + API_KEY + '&url=' + encodeURIComponent(url);
                                   // alternatively, use &key= instead of &api_key with the MD5 hash of your api_key
                                   // more about it: https://iframely.com/docs/allow-origins

                                   return (
                                       // If you need, set maxwidth and other styles for 'iframely-embed' class - it's yours to customize
                                       '<div class="iframely-embed">' +
                                       '<div class="iframely-responsive">' +
                                       `<iframe src="${ iframeUrl }" ` +
                                       'frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>' +
                                       '</iframe>' +
                                       '</div>' +
                                       '</div>'
                                   );
                               }
                           }
                       ]
                   },*/
                htmlEmbed: {
                    showPreviews: true,
                    sanitize: (inputHtml) => {

                        // Strip unsafe elements and attributes, e.g.:
                        // the `<script>` elements and `on*` attributes.
                        const outputHtml = sanitizeHtml(inputHtml);
                        // console.log(outputHtml)
                        return {
                            html: outputHtml,
                            // true or false depending on whether the sanitizer stripped anything.
                            hasChanged: true
                        };
                    }
                },
                language: 'pt-BR',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side'
                    ],
                    upload: {
                        types: ['png', 'jpg', 'jpeg', 'webp'] // TIPOS DE IMAGENS ACEITAVEIS "accept"
                    }

                },
                htmlSupport: {
                    allow: [
                        // Enables plain <div> elements.
                        {
                            name: 'div'
                        },

                        // Enables <div>s with all inline styles (but no other attributes).
                        {
                            name: 'div',
                            styles: true
                        },

                        // Enables <div>s with foo and bar classes.
                        {
                            name: 'div',
                            attributes: {
                                id: 'galery1',
                                style: ''
                            }
                        },
                    ]
                }
            },
            characterLenght: 0,
            characterLenght2: 0,
        }
    },
    methods: {
        countdown() {
            if (this.form.title || this.form.subtitle) {
                this.characterLenght = this.form.title.length;
                this.characterLenght2 = this.form.subtitle.length;
            }
        },
    },
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rifa
            </h2>
        </template>

        <div class="py-5 container w-5/12">
            <form @submit.prevent="onSubmit">
                <div class="c-content my-4">
                    <div class="flex items-center">
                        <DocumentTextIcon class="h-5 stroke-neutral mr-1"/>

                        <h3 class="text-neutral font-semibold text-base">Informações da Rifa</h3>
                    </div>

                    <div class="pt-6 mt-2 border-t border-gray-light dark:border-bgadm-light">

                        <div class="flex flex-col md:flex-row gap-4">
                            <!--                            <div class="w-full md:w-3/12 relative">-->
                            <!--                                <UploadImage :imgCurrent="form.image"-->
                            <!--                                             size="aspect-1" v-model="form.image"-->
                            <!--                                             label="Imagem de Capa"-->
                            <!--                                             formats="JPEG ou PNG"-->
                            <!--                                             filesize="2MB" name="image-notice"-->
                            <!--                                             :accept="'image/png,image/jpg,image/jpeg,image/webp'"/>-->
                            <!--                            </div>-->

                            <div class="w-full relative">
                                <div class="w-full">
                                    <Input label="Título:" v-model="form.title"
                                           type="text" name="title" :value="form.title"
                                           :maxlength="80"
                                           v-on:keyup="countdown"
                                           :error="validator.title || $page.props.errors.title"
                                           placeholder="Insira o título"/>

                                    <p class="px-2 text-xs text-neutral/70 -mt-2 mb-2">
                                        {{ characterLenght }} de 80
                                        caracteres</p>
                                </div>

                                <div class="w-full ">
                                    <Input label="Subtítulo:" v-model="form.subtitle"
                                           type="text" name="subtitle" :value="form.subtitle"
                                           :maxlength="160"
                                           v-on:keyup="countdown"
                                           :error="validator.subtitle || $page.props.errors.subtitle"
                                           placeholder="Digite o subtítulo"/>

                                    <p class="px-2 text-xs text-neutral/70 -mt-2 mb-2">
                                        {{ characterLenght2 }} de 160
                                        caracteres</p>
                                </div>

                                <div class="flex flex-col lg:flex-row md:gap-4">
                                    <div class="w-full lg:w-6/12">
                                        <Select label="Categoria:" v-model='form.category_id' name="category_id"
                                                :error="validator.category_id || $page.props.errors.category_id">
                                            <option v-for="category in categories" :value="category.id"
                                                    :key="category.id">
                                                {{ category.name }}
                                            </option>
                                        </Select>
                                    </div>

                                    <div class="w-full lg:w-6/12">
                                        <div class="relative">
                                            <Select label="Categoria:" v-model='form.category_id' name="category_id"
                                                    :error="validator.category_id || $page.props.errors.category_id">
                                                <option v-for="category in categories" :value="category.id"
                                                        :key="category.id">
                                                    {{ category.name }}
                                                </option>
                                            </Select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full relative">
                            <label
                                class="px-1.5 block font-medium text-sm text-neutral/70 bg-content rounded-md absolute -top-2.5 left-2.5 z-10">Regulamento:</label>

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
                    <div class="flex justify-between w-full">
                        <div class="flex items-center">
                            <PhotoIcon class="h-5 stroke-neutral mr-1"/>

                            <h3 class="text-neutral font-semibold text-base">Galeria de Fotos</h3>
                        </div>
                    </div>

                    <div ref="galery" class="w-full">
                        <div class="pt-6 mt-2 border-t border-gray-light dark:border-bgadm-light">
                            <div class="flex flex-col md:flex-row gap-4 pb-4">
                                <div class="w-full">
                                    <div class="flex flex-col md:flex-row md:gap-4">
                                        <div class="w-3/12 flex flex-col items-center relative">
                                            <UploadImage imgCurrent=""
                                                         label="Imagem"
                                                         size="aspect-1"
                                                         class="mt-1"
                                                         v-model="imageGallery"
                                                         formats="JPEG ou PNG" filesize="2MB" name="image-galery"/>

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
                            <div class="flex flex-col lg:flex-row gap-4">
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
                        <StarIcon class="h-5 stroke-neutral dark:stroke-white mr-1"/>

                        <h3 class="text-neutral font-semibold text-base">Informações de Destaque</h3>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 mt-2">
                        <div class="w-full md:w-6/12 relative">
                            <UploadImage :imgCurrent="form.image"
                                         size="aspect-56" v-model="form.image"
                                         label="Banner de Destaque"
                                         formats="JPEG ou PNG"
                                         filesize="2MB" name="image-notice"
                                         :accept="'image/png,image/jpg,image/jpeg,image/webp'"/>
                        </div>

                        <div class="w-full md:w-6/12 pt-3 relative">
                            <SwitchCheckbox label="Destaque" v-model="form.exclusive" side="left" id="activeExclusive"/>

                            <div class="w-full p-1.5 bg-warning flex items-center mt-6 rounded-lg">
                                <InformationCircleIcon class="h-7 stroke-black dark:stroke-white mr-1"/>

                                <p class="flex-1 text-xs text-warning-bw pr-3">Ao deixar habilitado o banner aparecerá
                                    na area de destaque na pagina principal do site</p>
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


<style>
:root {
    --ck-border-radius: 10px;
}

.ck.ck-editor {
    @apply text-neutral
}

.ck-editor__editable {
    min-height: 200px;
}
</style>
