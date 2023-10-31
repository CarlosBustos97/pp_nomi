@extends('layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cargos</h6>
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
                        <th>Área</th>
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
                                <td> {{ ($employee->area) ? $employee->area->name : '' }}</td>
                                <td> {{ ($employee->position) ? $employee->position->name : '' }}</td>
                                <td>
                                    @foreach ($employee->employeeRoles as $employeeRol)
                                        {{ $employeeRol->role->name }}
                                    @endforeach
                                </td>
                                <td> {{ ($employee->manager) ? $employee->manager->name : '' }}</td>
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
    'modal_id'      => 'add_position_modal',
    'modal_title'   => 'Nuevo cargo',
    'buttons'       => true,
    'btn_modal_id'  => 'btn_add_position',
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
                <label for="area">Área</label>
                <select class='form-control' name="area" id="area">
                    <option value="">Seleccione...</option>
                    @foreach ($areas as $area)
                        <option value="{{$area->id}}">{{$area->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="position">Cargo</label>
                <select class='form-control' name="position" id="position">
                    <option value="">Seleccione...</option>
                    @foreach ($positions as $position)
                        <option value="{{$position->id}}">{{$position->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="role">Rol</label>
                <select class='form-control' name="role[]" id="role" multiple>
                    <option value="">Seleccione...</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="manager">Jefe</label>
                <select class='form-control' name="manager" id="manager">
                    <option value="">Seleccione...</option>
                    @foreach ($employees as $employee)
                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endslot

@endcomponent

@section('js')
<script>
    function add(){
        $('#type_save').val("POST");
        $('#add_position_modal').modal('show')
    }

    function clearSelect() {
        let areaSelect = $('#area');
        let positionSelect = $('#position');
        let roleSelect = $('#role');
        let managerSelect = $('#manager');
        areaSelect.find('option:not(:first-child)').remove();
        positionSelect.find('option:not(:first-child)').remove();
        roleSelect.find('option:not(:first-child)').remove();
        managerSelect.find('option:not(:first-child)').remove();
    }

    function loadUpdateModal(employee){
        $('#type_save').val("PUT");
        $('#employee_id').val(employee.id);
        $('#name').val(employee.name);
        $('#identification').val(employee.identification);
        $('#area').val((employee.area) ? employee.area.id: '');
        $('#position').val((employee.position) ? employee.position.id: '');
        $('#manager').val((employee.manager) ? employee.manager.id: '');
        $('#add_position_modal').modal('show');
        let roles = $('select[name="role[]"]');
        $.each(employee.employee_roles, (index, value) => {
            roles.find('option[value="' + value.role.id + '"]').prop('selected', true);
        });
    }

    $('#btn_add_position').on('click', () => {
        $('#add_position_modal').modal('hide')
        let confirmation = showConfirmation();
        if( confirmation instanceof Promise){
            confirmation.then(response => {
                if(response)
                    savePosition()
            })
        }
    })

    function savePosition(){
        let employee = {};
        let type = $('#type_save').val();
        let id = $('#employee_id').val()
        employee.name =  $('#name').val();
        employee.identification =  $('#identification').val();
        employee.area_id =  $('#area').val();
        employee.position_id =  $('#position').val();
        employee.role_id =  $('#role').val();
        employee.manager_id =  $('#manager').val();

        if(type == "POST"){
            url = "{{ route('position.store') }}";
        }else{
            url = "{{ route('position.update', ['employee' => 'id']) }}";
            url = url.replace('id', id);
        }
        save(employee, url, type)
    }

    function delete_one(id){
        let confirmation = showConfirmation();
        let url = "{{ route('position.destroy', ['employee' => 'id']) }}"
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
