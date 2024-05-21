<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
</script>

<script>
export default {
    props: {
        data: Object,
        index: Number
    },
    data() {
        return {
            randomId: ''
        };
    },
    created() {
        this.randomId = this.index ? this.index : Math.floor(Math.random() * 10000);
    }
}
</script>

<template>
    <div class="w-full p-2 py-4 shadow-xl card bg-base-100">
        <div class="flex flex-row flex-wrap">
            <div class="justify-center hidden w-full lg:w-4/12 lg:flex md:flex sm:flex xl:flex">
                <figure class="h-full">
                    <img class="object-cover w-full h-full rounded-lg"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHEa_CL5PpEOY2FsC7VoTy74EecLP0FEIQ19xZlR3e-Q&s"
                        alt="payment" />
                </figure>
            </div>
            <div class="w-full lg:pl-4 lg:w-8/12">

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
                                <div class="py-3 badge" :class="data?.config ? 'badge-success' : 'badge-error'">
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
                                <h2 class="card-title">{{ data?.name }}</h2>
                            </div>
                            <!-- <div class="w-full">
                                <p>Atributos do metodo de pagamento 1</p>
                            </div> -->
                        </div>
                        <div class="flex flex-row flex-wrap mb-2">
                            <div class="w-full mb-2">
                                <InputLabel for="password" value="Login" />
                                <TextInput class="w-full" :value="data?.config?.login" type="text"></TextInput>
                            </div>
                            <div class="w-full mb-2">
                                <InputLabel for="password" value="Senha" />
                                <TextInput class="w-full" value="" type="password"></TextInput>
                            </div>
                            <div class="w-full mb-2">
                                <InputLabel for="password" value="Access Token" />
                                <TextInput class="w-full" :value="data?.config?.token" type="text"></TextInput>
                            </div>
                        </div>
                        <div class="justify-end card-actions">
                            <button class="border-none btn btn-sm bg-primary text-primary-bw">Configurar</button>
                        </div>
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
                                    <div class="w-4/12 text-center">
                                        Tipo
                                    </div>
                                    <div class="w-4/12 text-center">
                                        Taxa
                                    </div>
                                    <div class="w-4/12 text-center">
                                        Estimativa
                                    </div>
                                </div>
                                <div v-for="(team, key) in [1, 2, 3]" :key="key"
                                    class="flex flex-row w-full px-2 py-2 mb-1 rounded-lg bg-content">
                                    <div class="w-4/12 text-center">
                                        Cartão
                                    </div>
                                    <div class="w-4/12 text-center">
                                        R$ 0,42
                                    </div>
                                    <div class="w-4/12 text-center">
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
