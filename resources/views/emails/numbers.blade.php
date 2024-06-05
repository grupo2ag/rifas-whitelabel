@extends('.emails.email')

@section('content')
<div>
    {{ $params['conteudo'] }}
    {{ $params['nome'] }}
    {{ $params['numbers'] }}
</div>

<table class="body-wrap">
    <tr>
        <td class="container">
            <table>
                <tr>
                    <td class="u-tc u-px-24" align="center">
                        <h3 class="u-fs-16 u-fw-400 u-color-black u-mt-8 u-mb-8">
                            Olá, Parabéns {{ !empty($params['nome']) ? $params['nome'] : 'Nome' }}
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


            </table>

            <h2 class="title u-fs-14 u-fw-600 u-color-black u-uppercase u-mb-8 u-tc">
                Itens da Compra
            </h2>

        </td>
    </tr>
</table>


@endsection
