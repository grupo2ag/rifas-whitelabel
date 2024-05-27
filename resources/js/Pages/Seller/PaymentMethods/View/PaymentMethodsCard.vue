<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm } from '@inertiajs/vue3';
</script>

<script>
export default {
    props: {
        data: Object,
        index: Number
    },
    data() {
        return {
            randomId: '',
            form: {
                token: this.data?.config?.token ?? '',
                login: this.data?.config?.login ?? ''
            }
        };
    },
    methods: {
      onSubmit(e){

            if(!!this.form.token && !!this.form.login){

                const form = useForm(this.form)

                form.post(route('paymentMethods.store'), {
                    onSuccess: () => {
                        console.log('aqui');
                        this.disabled = false
                        this.loading = false
                    },
                    onError: () => {
                        this.disabled = false
                        this.loading = false

                    }
                })
            }
        }
    },
    created() {
        this.randomId = this.index ? this.index : Math.floor(Math.random() * 10000);
    }
}
</script>

<template>
    <div class="w-full p-2 py-4 shadow-xl card bg-base-100">
        <div class="flex flex-row flex-wrap">
            <div class="justify-center hidden w-full lg:w-4/12 lg:flex md:flex sm:flex xl:flex animate-fade-right">
                <figure class="h-full">
                    <img class="object-cover w-full h-full rounded-lg"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHEa_CL5PpEOY2FsC7VoTy74EecLP0FEIQ19xZlR3e-Q&s"
                        alt="payment" />
                </figure>
            </div>
            <div class="w-full lg:pl-4 lg:w-8/12 animate-fade-left">

                <div class="h-full drawer">
                    <input :id="'my-drawer' + (index ?? randomId)" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content">
                        <!-- Page content here -->
                        <div class="flex flex-row mb-2 lg:hidden md:hidden sm:hidden xl:hidden">
                            <div class="w-full lg:w-4/12 ">
                                <figure class="h-full">
                                    <img class="object-cover w-full h-full rounded-lg"
                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHEa_CL5PpEOY2FsC7VoTy74EecLP0FEIQ19xZlR3e-Q&s"
                                        alt="payment" />
                                </figure>
                            </div>
                        </div>
                        <div class="flex flex-row items-center">
                            <div class="w-6/12">
                                <div class="py-3 badge text-neutral/70" :class="data?.config ? 'badge-success' : 'badge-error'">
                                    {{ data?.config ? 'Ativo' : 'Inativo' }}
                                </div>
                            </div>
                            <div class="flex justify-end w-6/12">
                                <label :for="'my-drawer' + (index ?? randomId)"
                                    class="border-none btn-sm btn bg-primary text-primary-bw drawer-button">Taxas</label>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap mb-2">
                            <div class="w-full">
                                <h2 class="card-title text-neutral/70">{{ data?.name }}</h2>
                            </div>
                            <!-- <div class="w-full">
                                <p>Atributos do metodo de pagamento 1</p>
                            </div> -->
                        </div>
                        <form @submit.prevent="onSubmit">
                            <div class="flex flex-row flex-wrap mb-2">
                                <div class="w-full mb-2">
                                    <InputLabel for="login" class="text-neutral/70" value="Login" />
                                    <TextInput class="w-full" v-model="form.login" type="text"></TextInput>
                                </div>
                                <div class="w-full mb-2">
                                    <InputLabel for="token" class="text-neutral/70" value="Access Token" />
                                    <TextInput class="w-full" v-model="form.token" type="text"></TextInput>
                                </div>
                            </div>
                            <div class="justify-end card-actions">
                                <button type="submit" class="border-none btn btn-sm bg-primary text-primary-bw">Configurar</button>
                            </div>
                        </form>
                    </div>
                    <div class="absolute w-full h-full drawer-side ">
                        <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <ul class="w-full h-full p-4 menu bg-base-100 text-base-content">
                            <div class="flex flex-row items-start justify-end mb-1">
                                <label :for="'my-drawer' + (index ?? randomId)"
                                    class="border-none rounded-full btn btn-sm text-primary-bw bg-primary">
                                    x</label>
                            </div>
                            <div class="flex flex-row flex-wrap items-center w-full">
                                <div class="flex flex-row w-full px-2 py-2 mb-1 rounded-lg bg-base-200">
                                    <div class="w-4/12 text-center text-neutral/70">
                                        Tipo
                                    </div>
                                    <div class="w-4/12 text-center text-neutral/70">
                                        Taxa
                                    </div>
                                    <div class="w-4/12 text-center text-neutral/70">
                                        Estimativa
                                    </div>
                                </div>
                                <div v-for="(team, key) in [1, 2, 3]" :key="key"
                                    class="flex flex-row w-full px-2 py-2 mb-1 rounded-lg bg-content">
                                    <div class="w-4/12 text-center text-neutral/70">
                                        Cartão
                                    </div>
                                    <div class="w-4/12 text-center text-neutral/70">
                                        R$ 0,42
                                    </div>
                                    <div class="w-4/12 text-center text-neutral/70">
                                        1 dia útil
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
