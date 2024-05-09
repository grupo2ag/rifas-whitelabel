<script setup>
// import Welcome from '@/Components/Welcome.vue';
</script>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Input from '@/Components/FormElements/Input.vue';
import Select from '@/Components/FormElements/Select.vue';
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';

export default {
    components:{
        AppLayout,
        Input,
        Select
    },
    props: {
        raffle: Object
    },
    data() {
        return {
            form: {
                id: '',
                title:'',
                subtitle: '',
                image: '',
                description: '',
                url: '',
                galleries: ''
            },
            currentGallery: {
                id:'gallery-1',
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
                    // MediaEmbed,
                    HtmlEmbed,
                    SourceEditing,
                    Image,
                    ImageCaption,
                    ImageStyle,
                    ImageToolbar,
                    ImageUpload,
                    Base64UploadAdapter,
                    GeneralHtmlSupport,
                    AddGallery,
                    RemoveGallery,
                    RemoveFormat,
                    L8Button
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
                    sanitize: ( inputHtml ) => {

                        // Strip unsafe elements and attributes, e.g.:
                        // the `<script>` elements and `on*` attributes.
                        const outputHtml = sanitizeHtml( inputHtml );
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
        }
    }
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-5 container">
            <form @submit.prevent="onSubmit">
                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl mb-4">
                    <div class="flex items-center">
                        <PhotoIcon class="h-5 stroke-black dark:stroke-white mr-1"/>

                        <h3 class="text-black dark:text-white font-semibold text-base">Imagem da Notícia</h3>
                    </div>

                    <div
                        class="pt-6 mt-2 flex flex-col lg:flex-row items-center gap-4 border-t border-gray-light dark:border-bgadm-light">
                        <div class="w-4/12 relative">
                            <label
                                class="px-1.5 block font-medium text-sm text-black dark:text-white bg-white dark:bg-[#111827] rounded-md absolute -top-2 left-2.5">Imagem:</label>
                            <ImageUpload :imgCurrent="form.image" size="aspect-56" v-model="form.image"
                                         error="validator.image || $page.props.errors.image"
                                         formats="JPEG ou PNG" filesize="2MB" name="image-notice"/>
                        </div>
                    </div>

                    <p class="text-black/50 dark:text-white/50 text-xs my-3">Obs: A dimensão ideal é
                        <strong>768x580</strong>, JPEG ou PNG de no máximo de <strong>2 MB.</strong></p>
                </div>

                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl mb-4">
                    <div class="flex items-center">
                        <DocumentTextIcon class="h-5 stroke-black dark:stroke-white mr-1"/>

                        <h3 class="text-black dark:text-white font-semibold text-base">Informações da Notícia</h3>
                    </div>

                    <div class="pt-6 mt-2 border-t border-gray-light dark:border-bgadm-light">
                        <div class="w-full mb-5">
                            <Input label="Título da Notícia:" v-model="form.title"
                                            type="text" name="title" :value="form.title"
                                            :maxlength="200"
                                            v-on:keyup="countdown"
                                            error="validator.title || $page.props.errors.title"
                                            placeholder="Insira o título"/>

                            <p class="text-xs text-gray dark:text-white-light -mt-2 mb-2">{{ characterLenght }} de 200
                                caracteres</p>
                        </div>

                        <div class="w-full mb-5">
                            <Input label="Subtítulo:" v-model="form.subtitle"
                                            type="text" name="subtitle" :value="form.subtitle"
                                            :maxlength="160"
                                            v-on:keyup="countdown"
                                            error="errors.subtitle || $page.props.errors.subtitle"
                                            placeholder="Digite o subtítulo"/>

                            <p class="text-xs text-gray dark:text-white-light -mt-2 mb-2">{{ characterLenght2 }} de 160
                                caracteres</p>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-4 mb-5">
                            <div class="w-full lg:w-6/12">
                                <Select label="Categoria:" v-model='form.category_id' name="category_id"
                                        error="validator.category_id || $page.props.errors.category_id">
                                    <option v-for="category in categories" :value="category.id" :key="category.id">
                                        {{ category.name }}
                                    </option>
                                </Select>
                            </div>

                            <div class="w-full lg:w-6/12">
                                <div class="relative">
                                    <label
                                        class="px-1.5 block z-1 font-medium text-sm text-black dark:text-white ml-3 z-10 bg-white dark:bg-bgadm-dark absolute rounded-md -top-2">Meta
                                        Keywords:</label>
                                    <vue3-tags-input @on-tags-changed="handleChangeTag" :tags="form.tags"
                                                     placeholder="Digite suas keywords"/>
                                </div>
                            </div>
                        </div>

                        <div class="w-full relative">
                            <label
                                class="px-1.5 block font-medium text-sm text-black dark:text-white bg-white dark:bg-[#111827] rounded-md absolute -top-2.5 left-2.5">Descrição:</label>

                            <ckeditor :editor="editorType" v-model="form.description" :config="editorConfig" @ready="onEditorReady" class="text-black dark:text-white"  @blur="onSaveBlur('description')"></ckeditor>


                            <div v-if="validator.description || $page.props.errors.description" class="inline-block">
                                <p class="text-xs bg-red text-white py-1 px-2 rounded">
                                    {{ validator.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl mb-4 hidden">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center">
                            <PhotoIcon class="h-5 stroke-black dark:stroke-white mr-1"/>

                            <h3 class="text-black dark:text-white font-semibold text-base">Galeria de Fotos</h3>
                        </div>

                        <SwitchCheckbox @change="toggleAccordeon('galery')" side="left" id="galery"/>
                    </div>

                    <div ref="galery" class="w-full hidden">
                        <div class="pt-6 mt-2 border-t border-gray-light dark:border-bgadm-light">
                            <div class="flex flex-col md:flex-row gap-4 pb-4">
                                <div class="w-full md:w-10/12">
                                    <div class="flex flex-col md:flex-row md:gap-4">
                                        <div class="flex flex-col items-center relative">
                                            <label
                                                class="block font-medium text-sm w-full text-black dark:text-white bg-white dark:bg-[#111827] rounded-md absolute -top-2 mb-1">Imagem:</label>
                                            <ImageUpload imgCurrent="" size="square" class="mt-1" v-model="imageGallery"
                                                         formats="JPEG ou PNG" filesize="2MB" name="image-galery"/>
                                        </div>
                                        <div class="flex-1 pt-8">
<!--                                            <Input label="Legenda da Imagem:" v-model="imageSubtitleGallery"
                                                            type="text" name="name" :value="imageSubtitleGallery"
                                                            error="errors.imageSubtitleGallery || $page.props.errors.imageSubtitleGallery"
                                                            placeholder="Insira a fonte da imagem" class="w-full mb-5"/>

                                            <Input label="Fonte da imagem:" v-model="imageSourceGallery"
                                                            type="text" name="name" :value="imageSourceGallery"
                                                            error="errors.imageSourceGallery || $page.props.errors.imageSourceGallery"
                                                            placeholder="Insira a fonte da imagem" class="w-full"/>-->

                                            <Button type="button" @click="addImageOn(currentGallery)" class="ml-auto"
                                                    size="sm" color="black">Adicionar
                                            </Button>
                                        </div>
                                    </div>

                                    <p class="text-black/50 dark:text-white/50 text-xs my-3">Obs: A dimensão ideal é
                                        <strong>1024x768</strong>, com um tamanho máximo de <strong>2 MB.</strong></p>

                                    <template v-if="currentGallery.images.length">
                                        <label
                                            class="block font-medium text-sm w-full text-black dark:text-white bg-white dark:bg-[#111827] rounded-md pb-1">Galeria:</label>

                                        <div
                                            class="pt-3 grid grid-cols-8 gap-2 flex-wrap border-t border-gray-light dark:border-bgadm-light">
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
                                    </template>
                                </div>

                                <div class="w-full md:w-4/12">
                                    <label
                                        class="block font-medium text-sm w-full text-black dark:text-white bg-white dark:bg-[#111827] w-full text-center -mt-2">Posição:</label>

                                    <img class="object-cover w-6/12 mx-auto mt-1" src="/images/position-galery.svg"
                                         alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl mb-4">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center">
                            <ClockIcon class="h-5 stroke-black dark:stroke-white mr-1"/>

                            <h3 class="text-black dark:text-white font-semibold text-base">Agenda Publicação</h3>
                        </div>

                        <SwitchCheckbox @change="toggleAccordeon('publish')" side="left" id="publish"/>
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

                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl">
                    <div class="flex justify-end gap-4">
                        <Button href="route('admin.news.index')" size="sm" color="outline-light">
                            Cancelar
                        </Button>
                        <Button type="button" @click="onSubmit" color="success" :loading="loading" :disabled="disabled">
                            Salvar
                        </Button>
                    </div>
                </div>

                <div class="py-6 px-6 bg-white dark:bg-bgadm-dark rounded-xl mb-4 hidden">

                    <div class="flex flex-col gap-4 mb-3">
                        <div class="w-full ">
                            <Input label="Título da Notícia:" v-model="form.title"
                                            type="text" name="title" :value="form.title"
                                            :maxlength="200"
                                            v-on:keyup="countdown"
                                            error="validator.title || $page.props.errors.title"
                                            placeholder="Insira o título"/>
                            <p class="text-xs text-white-light">{{ characterLenght }} de 200 caracteres</p>

                        </div>
                        <div class="w-full ">
                            <Input label="Subtitulo:" v-model="form.subtitle"
                                            type="text" name="subtitle" :value="form.subtitle"
                                            :maxlength="160"
                                            v-on:keyup="countdown"
                                            error="validator.subtitle || $page.props.errors.subtitle"
                                            placeholder="Insira o nome da manchete"/>
                            <p class="text-xs text-white-light">{{ characterLenght2 }} de 160 caracteres</p>

                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4 mb-3">
                        <div class="w-full lg:w-6/12">
                            <Select label="Categoria:" v-model='form.category_id' name="type"
                                    error="validator.category_id || $page.props.errors.category_id">
                                <option v-for="category in categories" :value="category.id" :key="category.id">
                                    {{ category.name }}
                                </option>
                            </Select>
                        </div>
                        <div class="w-full lg:w-6/12">
                            <div class="flex flex-col md:flex-row gap-4 ">
                                <div class="w-full md:w-6/12">
                                    <Input label="Data de publicação" type="date"
                                                    name="date" class="appearance-none"
                                                    placeholder="dd/mm/aaaa" v-model="form.date" error="errors.date"/>
                                </div>
                                <div class="w-full md:w-6/12">
                                    <Input label="Horário de publicação" type="time"
                                                    name="time" class="appearance-none"
                                                    v-model="form.time" error="errors.time"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4 mb-3">
                        <div class="w-full lg:w-6/12">
                            <Input label="Autor:" v-model="form.author"
                                            type="text" name="author" :value="form.author"
                                            error="validator.author || $page.props.errors.author"
                                            placeholder="Insira o nome do autor"/>
                        </div>

                        <div class="w-full lg:w-6/12">
                            <div class="mb-3 relative">
                                <label
                                    class="px-1.5 block z-1 font-medium text-sm text-white mb-1 z-10 left-3 bg-[#111827] absolute rounded-md -top-2">Meta
                                    Keywords:</label>
                                <vue3-tags-input @on-tags-changed="handleChangeTag" :tags="form.tags"
                                                 placeholder="Digite suas keywords"/>
                            </div>
                        </div>
                    </div>

                    <QuillEditor :options="optionsQuill" contentType="html"
                                 v-model:content="form.description"
                                 ref="myQuillEditor"
                                 :modules="modules"
                                 :toolbar="[
                                'bold', 'italic',
                                {'color': []},
                                { 'list': 'ordered' },
                                { 'list': 'bullet' },
                                { 'indent': '-1' },
                                { 'indent': '+1' },
                                { 'script': 'sub' },
                                { 'script': 'super' },
                                'link', 'image',
                                {'custom-gallery': 'button'},
                                 'clean']"
                                 class="text-white"/>

                    <div v-show="validator.description || $page.props.errors.description" class="inline-block">
                        <p class="text-xs bg-red text-white py-1 px-2 rounded">
                            {{ validator.description }}
                        </p>
                    </div>

                    <div class="flex justify-end mt-5 border-t border-bgadm-light pt-4">
                        <Button @click="onSubmit" type="button" color="success" :loading="loading" :disabled="disabled">
                            Salvar
                        </Button>
                    </div>

                </div>
            </form>
        </div>
    </AppLayout>
</template>
