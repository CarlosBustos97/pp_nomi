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
            <th>Area</th>
            <th>Cargo</th>
            <th>Rol</th>
            <th>Jefe</th>
            <th>Acciones</th>

        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td> {{ $employee->name }}</td>
                    <td> {{ $employee->identification }}</td>
                    <td> {{ $employee->area->name }}</td>
                    <td> {{ $employee->position->name }}</td>
                    <td>
                        @foreach ($employee->employeeRoles as $role)
                            {{ $role->role->name }}/
                        @endforeach
                    </td>
                    <td> {{ ($employee->manager) ? $employee->manager->name : '' }}</td>
                    <td></td>
                </tr>

            @endforeach
        </tbody>
    </table>
</body>
</html>
