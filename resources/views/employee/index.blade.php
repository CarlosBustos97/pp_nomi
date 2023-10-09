<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <th>Nombre</th>
            <th>Identificación</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Ciuadad</th>
            <th>Departamento</th>
            <th>Acciones</th>

        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td> {{ $employee->name }}</td>
                    <td> {{ $employee->identification }}</td>
                    <td> {{ $employee->addres }}</td>
                    <td> {{ $employee->phone }}</td>
                    <td> {{ $employee->city->name }}</td>
                    <td> {{ $employee->city->department->name }}</td>
                    <td></td>
                </tr>

            @endforeach
        </tbody>
    </table>
</body>
</html>
