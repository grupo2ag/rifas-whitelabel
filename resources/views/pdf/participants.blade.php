<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Lines PDF</title>
    <style>
        /* Adicione seus estilos CSS aqui */
    </style>
</head>
<body>
<h1>Multiple Lines PDF</h1>
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
        <tr>
            <th>Numero</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
                <tr>
                    <td>{{ $line['number'] }}</td>
                    <td>{{ $line['name'] }}</td>
                    <td>{{ $line['phone'] }}</td>
                    <td>{{ $line['state'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
