<script>
import App from '@/Pages/App.vue'
import Icon from '@/Components/Icon/Icon.vue'

export default {
    components: {
        App,
        Icon
    },
    data() {
        return {}
    },
    methods: {}
}
</script>

<template>
<!--    <HeadSite title="Politica de Privacidade"/>-->

    <App>
        <section class="pt-24 pb-2">
            <div class="container">
                <div class="c-content px-10 bg-primary flex flex-col md:flex-row flex-col-reverse items-center justify-between">
                    <div class="">
                        <h1 class="text-3xl md:text-4xl mb-2 md:mb-4 text-center md:text-left font-extrabold text-primary-bw">
                            Termos de Uso</h1>
                        <p class="text-xl text-primary-bw">
                            Confira os termos de uso <br class="hidden md:block"> do nosso site e serviços.
                        </p>
                    </div>

                    <Icon name="icon-privacy-policy" class="w-44 fill-primary-bw mb-3 md:mb-0"></Icon>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content c-text">
                    <h3>Política de Privacidade</h3>

                    <h4>Privacidade</h4>
                    <p>A privacidade dos visitantes do site é
                        muito importante para nós.</p>
                    <p>Reconhecemos a relevância da
                        privacidade. Seus dados pessoais não serão comercializados, distribuídos ou compartilhados com
                        terceiros, exceto em casos de cumprimento de ordens judiciais.</p>
                    <p>Todas as informações pessoais relativas
                        a membros, assinantes, clientes ou visitantes que usem este site serão tratadas em concordância
                        com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98).</p>
                    <p>Os dados relacionados a pagamentos
                        utilizados nas compras nunca são armazenados em nossos servidores e as senhas são armazenadas em
                        bancos de dados de maneira criptografada.</p>
                    <p>Informações submetidas em nossas páginas
                        de contato são utilizadas pela equipe de suporte ao cliente apenas para a finalidade de ajuda e
                        não serão compartilhadas.</p>
                    <p>O endereço de e-mail está seguro e nunca
                        será divulgado. Nós detectamos o spam e protegemos sua privacidade integralmente.</p>


                    <h4 class="text-lg md:text-xl text-textcolor02 font-bold leading-tight mt-6 mb-2">Registros</h4>
                    <p>Assim como outros websites, coletamos e
                        usamos informações relativas aos registros. A informação contida nos registros inclui o seu
                        endereço IP (Internet Protocol), o seu ISP (Internet Service Provider), o navegador que utilizou
                        ao visitar-nos, o tempo da sua visita e que páginas visitou neste site.</p>
                    <p>Rastreamos a localização/endereços de
                        protocolo de internet (IP) para fornecer serviços livres de spam e segurança para todos os
                        nossos clientes.</p>

                    <h4 class="text-lg md:text-xl text-textcolor02 font-bold leading-tight mt-6 mb-2">Os Cookies e Web
                        Beacons</h4>
                    <p>Utilizamos cookies para armazenar
                        informação, tais como as suas preferências pessoais quando visita nosso site, isso poderá
                        incluir um simples popup. Você detém o poder de desligar seus cookies nas opções do browser, ou
                        efetuando alterações nas ferramentas de programas antivírus, como o Norton Internet Security. No
                        entanto, isso poderá modificar a forma de interagir neste ou em outros sites, como a forma de
                        fazer login que pode ser prejudicada.</p>
                    <p>Você pode optar por excluir a coleta e
                        uso das informações para direcionamento de anúncios ou sair de nossa lista de e-mail clicando em
                        “unsubscribe” ao final dos e-mails que recebe.</p>
                    <p>Ao usar nossos sites, você concorda com
                        a Política de Privacidade citada acima.</p>

                    <h4 class="text-lg md:text-xl text-textcolor02 font-bold leading-tight mt-6 mb-2">Ligações a Sites de
                        Terceiros</h4>
                    <p>Este site possui ligações para outros
                        sites, os quais, a nosso ver, podem conter informações/ferramentas úteis para os nossos
                        visitantes. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso
                        visite outro site a partir do nosso deverá ler a política de privacidade do mesmo.</p>
                    <p>Não nos responsabilizamos pela política
                        de privacidade ou conteúdo presente nesses mesmos sites.</p>
                </div>
            </div>
        </section>
    </App>
</template>

<style lang="scss" scoped>
.c-text{
    h3{
        @apply text-2xl md:text-3xl	text-neutral font-black leading-tight mb-8 md:mb-8;
    }

    h4{
        @apply text-lg md:text-xl text-neutral font-bold leading-tight mb-1;
    }

    p{
        @apply  text-neutral/70
    }
}
</style>
