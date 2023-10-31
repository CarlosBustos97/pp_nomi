@extends('layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Empleados</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-light  btn-circle btn-lg" id="delete" name="delete" onclick="delete()">
                <i class="fas fa-trash" style="color: #0D6CC1"></i>
            </a>
            <a href="#" class="btn btn-light  btn-circle btn-lg" id="add" name="add" onclick="add()">
                <i class="fas fa-user-plus" style="color: #0D6CC1"></i>
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl_employees" width="100%" cellspacing="0">
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
                                <td> {{ $employee->address }}</td>
                                <td> {{ $employee->cellphone }}</td>
                                <td> {{ ($employee->city) ? $employee->city->name : '' }}</td>
                                <td> {{ ($employee->city) ? $employee->city->department->name : '' }}</td>
                                <td>
                                    <a href="#" class="btn btn-light  btn-circle btn-sm" onclick="loadUpdateModal({{$employee}})">
                                        <i class="fas fa-pencil-alt" style="color: #0D6CC1"></i>
                                    </a>
                                    <a href="#" class="btn btn-light  btn-circle btn-sm" onclick="delete_one({{$employee->id}})">
                                        <i class="fas fa-trash" style="color: #0D6CC1"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@component('components.modals.modal', [
    'modal_id'      => 'add_employee_modal',
    'modal_title'   => 'Nuevo empleado',
    'buttons'       => true,
    'btn_modal_id'  => 'btn_add_employee',
    'ppal_btn_text' => 'Guardar',
    'modal_size'    => 'modal-md'
    ])
    @slot('modal_body')
        <div class="row">
            <input class="form-control" type="hidden" id="employee_id" name="employee_id">
            <input class="form-control" type="hidden" id="type_save" name="type_save">
            <div class="col-sm-6">
                <label for="name">Nombre</label>
                <input class="form-control" type="text" id="name" name="name">
            </div>
            <div class="col-sm-6">
                <label for="identification">Identificación</label>
                <input class="form-control" type="text" id="identification" name="identification">
            </div>

            <div class="col-sm-6">
                <label for="phone">Teléfono</label>
                <input class="form-control" type="text" id="phone" name="phone">
            </div>
            <div class="col-sm-6">
                <label for="addres">Dirección</label>
                <input class="form-control" type="text" id="addres" name="addres">
            </div>

            <div class="col-sm-6">
                <label for="country">Pais</label>
                <select class='form-control' name="country" id="country" onchange="getDepartments()">
                    <option value="">Seleccione...</option>
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="department">Departamento</label>
                <select class='form-control' name="department" id="department" onchange="getCities()">
                    <option value="">Seleccione...</option>
                </select>
            </div>

            <div class="col-sm-6">
                <label for="city">Ciudad</label>
                <select class='form-control' name="city" id="city">
                    <option value="">Seleccione...</option>
                </select>
            </div>
        </div>
    @endslot

@endcomponent

@section('js')
<script>
    function add(){
        $('#type_save').val("POST");
        $('#add_employee_modal').modal('show')
    }

    function getDepartments(){
        let country_id = $('#country').val();
        let url = "{{ route('departments.get.country', 'country') }}";
        url = url.replace('country', country_id);
        clearSelect();
        $.get(url, (data, status) => {
            data.departments.forEach(element => {
                $('#department')
                    .append($('<option>',{
                        value: element.id,
                        text: element.name
                    }));

            });
        });
    }

    function getCities(){
        let department_id = $('#department').val();
        let url = "{{ route('city.get.department', 'department') }}";
        url = url.replace('department', department_id);
        $.get(url, (data, status) => {
            data.cities.forEach(element => {
                $('#city')
                    .append($('<option>',{
                        value: element.id,
                        text: element.name
                    }));

            });
        });
    }

    function clearSelect() {
        let departmentSelect = $('#department');
        let citySelect = $('#department');
        departmentSelect.find('option:not(:first-child)').remove();
        citySelect.find('option:not(:first-child)').remove();
    }

    function loadUpdateModal(employee){
        $('#employee_id').val(employee.id)
        $('#name').val(employee.name)
        $('#identification').val(employee.identification)
        $('#phone').val(employee.cellphone)
        $('#addres').val(employee.address)
        $('#country').val()
        $('#type_save').val("PUT");
        $('#add_employee_modal').modal('show')
        if(employee.city)
            loadSelectModal(employee);
    }

    async function loadSelectModal(employee) {
        $('#country').val(employee.city.department.country.id).attr('selected', true).trigger('change');
        await new Promise(resolve => {
            $('#department').on('change', function () {
                resolve();
            });
        });
        $('#department').val(employee.city.department.id).attr('selected', true).trigger('change');
        await new Promise(resolve => {
            $('#city').on('change', function () {
                resolve();
            });
        });
        $('#city').val(employee.city.id).attr('selected', true);
    }

    $('#btn_add_employee').on('click', () => {
        $('#add_employee_modal').modal('hide')
        let confirmation = showConfirmation();
        if( confirmation instanceof Promise){
            confirmation.then(response => {
                if(response)
                    saveEmployee()
            })
        }
    })

    function saveEmployee(){
        let employee = {};
        let type = $('#type_save').val();
        let id = $('#employee_id').val()
        employee.name =  $('#name').val();
        employee.identification =  $('#identification').val();
        employee.cellphone =  $('#phone').val();
        employee.birth_city_id =  $('#city').val();
        employee.address =  $('#addres').val();

        if(type == "POST"){
            url = "{{ route('employees.store') }}";
        }else{
            url = "{{ route('employees.update', ['employee' => 'id']) }}";
            url = url.replace('id', id);
        }
        save(employee, url, type)
    }

    function delete_one(id){
        let confirmation = showConfirmation();
        let url = "{{ route('employees.destroy', ['employee' => 'id']) }}"
        url = url.replace('id', id)
        if( confirmation instanceof Promise){
            confirmation.then(response => {
                if(response)
                    destroy(url)
            })
        }
    }

    $(document).ready(function(){
    })
</script>
@endsection
