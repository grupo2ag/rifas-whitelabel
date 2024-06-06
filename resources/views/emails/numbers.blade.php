@extends('.emails.email')

@section('content')
<table class="body-wrap">
    <tr>
        <td class="container">
            <table>
                <tr>
                    <td class="u-tc u-px-24" align="center">
                        <h3 class="u-fs-16 u-fw-400 u-color-black u-mt-8 u-mb-8">
                            Olá, {{ empty($parms['nome']) ? $params['nome'] : 'Nome' }}
                        </h3>

                        <img width="90" class="icon-check u-mb-8"
                             src="https://xas-presave-public.s3.us-west-2.amazonaws.com/default/icon-check.png" />

                        <h2 class="title u-fs-20 u-color-black u-fw-600 u-tc u-mb-16">
                            Seu Pagamento foi aprovado
                        </h2>

                        <p class="text u-fs-16 u-fw-500 u-tc u-mb-16">
                            Você está participando do sorteio
                        </p>
                    </td>
                </tr>
            </table>

            <table class="table-access u-mb-8" >
                <tr>
                    <td class="u-pl-16 u-py-8 u-tl u-fs-14 u-color-black" style="width: 67px; ">
                        <img src="{{ !empty($params['thumb']) ? $params['thumb'] : '' }}" alt="" style="width: 55px; height: 55px">
                    </td>
                    <td class="u-pd-8   " style="width: auto !important;vertical-align: middle">
                        <p class="u-fs-14 u-color-black u-fw-600">{{ !empty($params['title']) ? $params['title'] : 'CHEVROLET CRUZE 1.4 TURBO' }}</p>
                        <p class="u-fs-12 text  ">Data prevista do sorteio: {{ !empty($params['expected_date']) ? $params['expected_date'] : '' }}</p>
                    </td>
                </tr>
            </table>

            <table class="table-access u-mb-8">
                <tr>
                    <td class="u-tc u-px-24 u-fs-14 u-pt-16 u-pb-16 u-color-black">
                        <p class="u-fs-12 u-color-black u-fw-600 u-tc u-mb-2">Titulo(s)</p>

                        <?php $tags = explode(',', $params['numbers']); ?>

                        @foreach($tags as $key)
                            <span>
                                <div style="display: table-cell;padding-top: 2px; padding-bottom: 2px;" >
                                    <span style="display: table-cell;  border: 1px solid #000000; width: 70px; ">{{$key}}</span>
                                </div>
                            </span>
                        @endforeach
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="u-tc u-px-24 u-pt-16" align="center">
                        <p class="u-fs-14 u-fw-700 u-color-black u-tc u-mb-8">
                            Boa Sorte!
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection
