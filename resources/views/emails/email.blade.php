<!doctype html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <meta content="ArtizThemes" name="Rifas8">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,500,700,800&display=swap" rel="stylesheet">

    <style type="text/css">
        <?php include(public_path().'/css/email/main.css'); ?>
    </style>
</head>

<body>
<table class="main">
    <tr>
        <td align="center">
            <table class="header-wrap">
                <tr>
                    <td class="container">
                        <table>
                            <tr>
                                <td class="u-tc">
                                    <img class="logo " src="{{config('constants.LOGO_PNG')}}" width="90" alt="Logo {{config('NOME_SISTEMA') }}">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            @yield('content')

            <table class="footer-wrap u-mt-8 u-mb-16">
                <tr>
                    <td>
                        <div class="container">
                            <table>
                                <tr>
                                    <td class="u-tc u-pb-8" align="center">
                                        <p class="u-fs-10 u-fw-300 u-color-black u-tc u-leading-3">
                                            * Esse email é necessário para a utilização do site e não pode ser cancelado.
                                            Emails enviados para este endereço não serão respondidos.
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p class="u-color-black u-fs-12 u-tc u-mb-2">Feito com <span style="color: red">❤</span> por <span class="u-fw-600">Rifas8</span></p>
                                     </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
