
@extends('.emails.email')

@section('content')
<div>
    {{ $emailSend['conteudo'] }}
    {{ $emailSend['nome'] }}
    {{ $emailSend['numbers'] }}
</div>

<table class="body-wrap">
    <tr>
        <td class="container">
            <table>
                <tr>
                    <td class="u-tc u-px-24" align="center">
                        <h3 class="u-fs-16 u-fw-400 u-color-black u-mt-8 u-mb-8">
                            Olá, Parabéns {{ !empty($emailSend['nome']) ? $ema['nome'] : 'Nome' }}
                        </h3>

                        <img width="90" class="icon-check u-mb-8"
                             src="https://xas-presave-public.s3.us-west-2.amazonaws.com/default/icon-check.png" />

                        <h2 class="title u-fs-20 u-color-black u-fw-600 u-tc u-mb-16">
                            Pagamento Aprovado!
                        </h2>

                        <p class="text u-fs-16 u-fw-500 u-tc u-mb-16">
                            Pedido <br> <b
                                class="u-fw-600 u-color-black">{{ !empty($params['uuid']) ? $params['uuid'] : 'Nome' }}</b>
                        </p>
                    </td>
                </tr>
            </table>


            <h2 class="title u-fs-14 u-fw-600 u-color-black u-uppercase u-mb-8 u-tc">
                Detalhes da Compra
            </h2>
            <table class="table-access table-access--vertical u-mb-24">
                <tr>
                    <td class="u-tc u-px-24 u-fs-14">
                        <p class="text u-fs-12 u-fw-400 u-tc">Nome</p>
                        {{ !empty($params['buyer_name']) ? $params['buyer_name'] : 'Nome' }}
                    </td>
                </tr>
                <tr>
                    <td class="u-tc u-px-24 u-fs-14">
                        <p class="text u-fs-12 u-fw-400 u-tc">Data e Hora</p>
                        {{ date('d/m/Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td class="u-tc u-px-24 u-fs-14">
                        <p class="text u-fs-12 u-fw-400 u-tc">Forma de pagamento</p>
                        {{ $params['payment_type'] === 'CREDIT_CARD' ? 'Cartão de Crédito' : $params['payment_type'] }}
                    </td>
                </tr>
                <tr>
                    <td class="u-tc u-px-24 u-fs-14">
                        <p class="text u-fs-12 u-fw-400 u-tc">Parcelas</p>
                        {{ $params['installments'] > 1 ? +$params['installments'] . 'x' : 'à vista' }}
                    </td>
                </tr>

                <tr>
                    <td class="u-tc u-px-24 u-fs-14">
                        <p class="text u-fs-12 u-fw-400 u-tc">Endereço de Cobrança/Entrega</p>
                        {{ $address }}
                    </td>
                </tr>

            </table>

            <h2 class="title u-fs-14 u-fw-600 u-color-black u-uppercase u-mb-8 u-tc">
                Itens da Compra
            </h2>

            <div class="box">

                <div class="u-pd-12 u-bg-white-light u-rounded-10 u-mb-16">
                    <table style="width: 100%;">
                        <thead>
                        <tr style="border-bottom: 1px solid #e4e4e4;">
                            <th class="u-pd-4 u-tl u-color-black u-fw-200 u-fs-12"></th>
                            <th class="u-pd-4 u-tl u-color-black u-fw-200 u-fs-12">Produto</th>
                            <th class="u-pd-4 u-tc u-color-black u-fw-200 u-fs-12">qnt</th>
                            <th class="u-pd-4 u-tr u-color-black u-fw-200 u-fs-12">Valor</th>
                        </tr>
                        </thead>
                        <tr style="border-bottom: 1px solid #e4e4e4;">
                            <td class="u-pd-4 u-tl u-fs-14 u-color-black" style="width: 67px;">
                                <img src="{{ !empty($params['thumb']) ? $params['thumb'] : '' }}" alt="" style="width: 55px; height: 55px">
                            </td>
                            <td class="u-pd-4 u-tl u-fs-14 u-color-black" style="vertical-align: middle">
                                {{ !empty($params['name']) ? $params['name'] : '' }}
                            </td>
                            <td class="u-pd-4 u-tc u-fs-14 u-color-black" style="vertical-align: middle">
                                1
                            </td>
                            <td class="u-pd-4 u-tr u-fs-14 u-color-black" style="vertical-align: middle">
                                {{ !empty($params['value']) ? number_format($params['value'] / 100, 2, ',', '.') : '0,00' }}
                            </td>
                        </tr>

                    </table>

                    <table class="u-mt-6" style="width: 100%;">
                    <!--                            <tr>
                                <td class="u-px-4 u-tr u-color-black u-opacity-90 u-fw-300 u-fs-14" width="75%">Subtotal:
                                </td>
                                <td class="u-px-4 u-tr u-color-black u-opacity-90 u-fw-300 u-fs-14">R$
                                    {{ !empty($params['value']) ? number_format($params['value'] / 100, 2, ',', '.') : '0,00' }}
                        </td>
                    </tr>-->


                        <tr>
                            <td class="u-px-4 u-tr u-color-black u-opacity-90 u-fw-600 u-fs-16" width="75%">Total:
                            </td>
                            <td class="u-px-4 u-tr u-color-black u-opacity-90 u-fw-600 u-fs-16">R$
                                {{ !empty($params['value_tax']) ? number_format($params['value_tax'] / 100, 2, ',', '.') : '0,00' }}
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="u-mt-16">
                    <tr>
                        <td class="u-px-24">
                            <p class="u-color-black u-tc u-fs-12 u-fw-600">Se tiver alguma dúvida, entre em contato com
                                a pessoa responsável pela venda pelo e-mail: agenciamultdigital@gmail.com</p>
                        </td>
                    </tr>
                </table>
            </div>

        </td>
    </tr>
</table>


@endsection
