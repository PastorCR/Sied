<!-- Content Header (Page header) -->
<section class="content-header">

    <h1>Administración de Usuarios
    </h1>
    <ol class="breadcrumb">
        <li><a href="#/"><i class="fa  fa-building-o"></i> Índice</a></li>
        <li><a href="#/admin_usuarios">Usuarios</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content" ng-controller="controlUsuario as cu" ng-init="init()">
    <!-- Default box -->
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <span ng-show="solicitudes.length != 0" class="label label-danger">{{solicitudes.length}}</span>
            <h3 class="box-title">Administración de solicitudes</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="solicitudes" class="table table-hover table-bordered table-responsive" datatable="ng" style="border-top: 3px solid #3c8dbc;">
                <thead>
                    <tr>
                        <th ng-show="false">Id</th>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Perfil</th>
                        <th style="text-align: center;">Estado</th>
                        <th style="text-align: center;">Departamento</th>
                        <th style="text-align: center;">Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="user in solicitudes" sglclick="" dblclick="modalModificar({{user}},true);">
                        <td ng-show="false"> {{user.id}} </td>
                        <td> {{user.nombre + " " + user.apellido1 + " " + user.apellido2}} </td>
                        <td class="text-center"> 
                            <small class="label bg-blue margin">Sin perfil</small>
                        </td>
                        <td> 
                            <small ng-show="user.estado == 1" class="label bg-green margin">Activo</small>
                            <small ng-show="user.estado != 1"class="label bg-red margin">Inactivo</small>
                        </td>
                        <td> {{user.departamento}}</td>
                        <td> {{user.empresa}}</td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#modalUserAdd">Agregar Usuario</button>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

    <!-- Default box -->
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Administración de Usuarios</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <table id="usuarios" class="table table-hover table-bordered table-responsive" datatable="ng" style="border-top: 3px solid #3c8dbc;">
                <thead>
                    <tr>
                        <th ng-show="false">Id</th>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Perfil</th>
                        <th style="text-align: center;">Estado</th>
                        <th style="text-align: center;">Departamento</th>
                        <th style="text-align: center;">Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="user in users" sglclick="" dblclick="modalModificar({{user}});">
                        <td ng-show="false"> {{user.id}} </td>
                        <td> {{user.nombre + " " + user.apellido1 + " " + user.apellido2}} </td>
                        <td class="text-center"> 
                            <small ng-show="user.perfil.Colaborador == 1" class="label bg-blue margin">Colaborador</small>
                            <small ng-show="user.perfil.Jefe == 1"class="label bg-blue margin">Jefe</small>
                            <small ng-show="user.perfil.RH == 1"class="label bg-blue margin">RH</small>
                        </td>
                        <td> 
                            <small ng-show="user.estado == 1" class="label bg-green margin">Activo</small>
                            <small ng-show="user.estado != 1"class="label bg-red margin">Inactivo</small>
                        </td>
                        <td> {{user.departamento}}</td>
                        <td> {{user.empresa}}</td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#modalUserAdd">Agregar Usuario</button>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

    <!-- /modalAdd -->
    <div class="modal" id="modalUserAdd">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3c8dbc; color:#FFF">
                    <button type="reset" style='opacity: initial; color: #FFF' class="close" data-dismiss="modal" ng-click="resetForm(formAdd)" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar un Usuario</h4>
                </div>
                <form id="formAdd" name="formAdd"  method="post" class="form-horizontal" ng-submit="agregar()">
                    <div class="modal-body">

                        <div class="form-group" ng-class="{ 'has-error' : formAdd.nombre.$invalid && !formAdd.nombre.$pristine }">
                            <label for="nombre" class="col-sm-4 control-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre" ng-model="userAdd.nombre" required> 
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formAdd.apellido1.$invalid && !formAdd.apellido1.$pristine }">
                            <label for="apellido1" class="col-sm-4 control-label">Primer Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Primer Apellido" name="apellido1" ng-model="userAdd.apellido1" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formAdd.apellido2.$invalid && !formAdd.apellido2.$pristine }">
                            <label for="apellido2" class="col-sm-4 control-label">Segundo Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Segundo Apellido" name="apellido2" ng-model="userAdd.apellido2" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formAdd.cedula.$invalid && !formAdd.cedula.$pristine }">
                            <label for="cedula" class="col-sm-4 control-label">Cedula</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Cédula" name="cedula" ng-model="userAdd.id" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formAdd.correo.$invalid && !formAdd.correo.$pristine }">
                            <label for="correo" class="col-sm-4 control-label">Correo</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Correo" name="correo" ng-model="userAdd.correo" required>
                            </div>
                        </div>
                        <div  name="empresa" class="form-group"  ng-class="{ 'has-error' : formAdd.empresa.$invalid && !formAdd.empresa.$pristine }">
                            <label for="empresa" class="col-sm-4 control-label">Empresa</label>
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap" ng-model="userAdd.empresa" on-select="selectEmpresa($item)" class="form-control select2" title="Empresa" required>
                                    <ui-select-match placeholder="">{{userAdd.empresa.nombre}}</ui-select-match>
                                    <ui-select-choices repeat="empresa in empresas | filter: $select.search" >
                                        <div ng-bind-html="empresa.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group"  ng-class="{ 'has-error' : formAdd.departamento.$invalid && formAdd.departamento.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Departamento</label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userAdd.departamento" on-select="" class="form-control select2" title="Departamento" required>
                                    <ui-select-match placeholder="">{{userAdd.departamento.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="departamento in departamentos | filter: $select.search | filter: filtro">
                                        <div ng-bind-html="departamento.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group"  ng-class="{ 'has-error' : formAdd.perfilcompetencia.$invalid && formAdd.perfilcompetencia.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Perfil de competencia</label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userAdd.perfilcompetencia" on-select="" class="form-control select2" title="Perfil Competencia" required>
                                    <ui-select-match placeholder="">{{userAdd.perfilcompetencia.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="perfilcompetencia in competencias | filter: $select.search">
                                        <div ng-bind-html="perfilcompetencia.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formAdd.empresa.$invalid && !formAdd.empresa.$pristine }">
                            <label for="perfil" class="col-sm-4 control-label">Perfil</label>
                            <div class="col-sm-8">
                                <ui-select  multiple  class="form-control select2" ng-model="userAdd.perfil" on-remove="onRemove($item)" on-select="onSelect($item)" close-on-select="false" style="width: 100%;" title="Asigna el perfil" required>
                                    <ui-select-match placeholder="Seleccione los perfiles">{{$item}}</ui-select-match>
                                    <ui-select-choices repeat="a in opciones  |  filter: $select.search">
                                        {{a}}
                                    </ui-select-choices>
                                </ui-select>
                            </div> 
                        </div>
                        <div ng-show="jefeb" class="form-group"  ng-class="{ 'has-error' : formAdd.aCargo.$invalid && formAdd.aCargo.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Departamento a cargo</label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userAdd.aCargo" on-select="" class="form-control select2" title="Departamento a cargo">
                                    <ui-select-match placeholder="">{{userAdd.aCargo.empnombre +" - "+userAdd.aCargo.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="departamento in departamentos | filter: $select.search">
                                        <div ng-bind-html="departamento.empnombre +' - '+departamento.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado" class="col-sm-4 control-label">Estado</label>
                            <div class="col-sm-3">
                                <input type="checkbox" id="" name="" ng-model="userAdd.estado" color="green"  i-check 
                                       ng-checked="userAdd.estado == 1" ng-true-value="'1'" ng-false-value="'0'">
                                <label for="" class="control-label">Activo</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" id="" name="" ng-model="userAdd.estado" color="red"  i-check 
                                       ng-checked="userAdd.estado != 1" ng-true-value="'0'" ng-false-value="'1'">
                                <label for="" class="control-label">Inactivo</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default pull-left" ng-click="resetForm(formAdd)" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" ng-disabled="formAdd.$invalid" closemodal="modalUserAdd">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /modalEditar -->
    <div class="modal modal-primary" id="modalUserEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 ng-show="!bandera" class="modal-title">Editar un Usuario</h4>
                    <h4 ng-show="bandera"class="modal-title">Solicitud de Usuario</h4>
                </div>
                <form name="formEdit" method="post" class="form-horizontal" ng-submit="modificar()">
                    <div class="modal-body">

                        <div class="form-group" ng-class="{ 'has-error' : formEdit.nombre.$invalid && !formEdit.nombre.$pristine }">
                            <label for="nombre" class="col-sm-4 control-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre" ng-model="userEdit.nombre" required> 
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formEdit.apellido1.$invalid && !formEdit.apellido1.$pristine }">
                            <label for="apellido1" class="col-sm-4 control-label">Primer Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Primer Apellido" name="apellido1" ng-model="userEdit.apellido1" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formEdit.apellido2.$invalid && !formEdit.apellido2.$pristine }">
                            <label for="apellido2" class="col-sm-4 control-label">Segundo Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Segundo Apellido" name="apellido2" ng-model="userEdit.apellido2" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formEdit.cedula.$invalid && !formEdit.cedula.$pristine }">
                            <label for="cedula" class="col-sm-4 control-label">Cedula</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Cédula" name="cedula" ng-model="userEdit.id" required disabled>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formEdit.correo.$invalid && !formEdit.correo.$pristine }">
                            <label for="correo" class="col-sm-4 control-label">Correo</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Correo" name="correo" ng-model="userEdit.correo" required>
                            </div>
                        </div>
                        <div  name="empresa" class="form-group"  ng-class="{ 'has-error' : formEdit.empresa.$invalid && !formEdit.empresa.$pristine }">
                            <label for="empresa" class="col-sm-4 control-label">Empresa </label>
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap" ng-model="userEdit.empresa" on-select="selectEmpresa($item)" class="form-control select2" title="Empresa">
                                    <ui-select-match placeholder="">{{userEdit.empresa.nombre}}</ui-select-match>
                                    <ui-select-choices repeat="empresa in empresas | filter: $select.search" >
                                        <div ng-bind-html="empresa.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group"  ng-class="{ 'has-error' : formEdit.departamento.$invalid && formEdit.departamento.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Departamento </label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userEdit.departamento" on-select="" class="form-control select2" title="Departamento">
                                    <ui-select-match placeholder="">{{userEdit.departamento.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="departamento in departamentos | filter: $select.search | filter: filtro">
                                        <div ng-bind-html="departamento.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group"  ng-class="{ 'has-error' : formEdit.perfilcompetencia.$invalid && formEdit.perfilcompetencia.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Perfil de competencia</label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userEdit.perfilcompetencia" on-select="" class="form-control select2" title="Perfil Competencia" required>
                                    <ui-select-match placeholder="">{{userEdit.perfilcompetencia.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="perfilcompetencia in competencias | filter: $select.search">
                                        <div ng-bind-html="perfilcompetencia.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : formEdit.empresa.$invalid && !formEdit.empresa.$pristine }">
                            <label for="perfil" class="col-sm-4 control-label">Perfil</label>
                            <div class="col-sm-8">
                                <ui-select  multiple  class="form-control select2" on-remove="onRemove($item)" on-select="onSelect($item)" ng-model="userEdit.perfil" close-on-select="false" style="width: 100%;" title="Asigna el perfil" required>
                                    <ui-select-match placeholder="Seleccione los perfiles">{{$item}}</ui-select-match>
                                    <ui-select-choices repeat="a in opciones  |  filter: $select.search">
                                        {{a}}
                                    </ui-select-choices>
                                </ui-select>
                            </div> 
                        </div>

                        <div ng-show="jefeb" class="form-group"  ng-class="{ 'has-error' : formEdit.aCargo.$invalid && formEdit.aCargo.$dirty }">
                            <label for="departamento" class="col-sm-4 control-label">Departamento a cargo</label>                     
                            <div class="col-sm-8">
                                <ui-select theme="bootstrap"  ng-model="userEdit.aCargo" on-select="" class="form-control select2" title="Departamento a cargo">
                                    <ui-select-match placeholder="">{{userEdit.aCargo.empnombre +" - "+userEdit.aCargo.nombre}}</ui-select-match>
                                    <ui-select-choices allow-clear ="true" repeat="departamento in departamentos | filter: $select.search">
                                        <div ng-bind-html="departamento.empnombre +' - '+departamento.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="estado" class="col-sm-4 control-label">Estado</label>
                            <div class="col-sm-3">
                                <input type="checkbox" id="" name="" ng-model="userEdit.estado" color="green"  i-check 
                                       ng-checked="userEdit.estado == 1" ng-true-value="'1'" ng-false-value="'0'">
                                <label for="" class="control-label">Activo</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" id="" name="" ng-model="userEdit.estado" color="red"  i-check 
                                       ng-checked="userEdit.estado != 1" ng-true-value="'0'" ng-false-value="'1'">
                                <label for="" class="control-label">Inactivo</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-show="!bandera" class="btn btn-primary" ng-disabled="formEdit.$invalid" closemodal="modalUserEdit">Modificar</button>
                        <button type="button"  ng-click="confirmar()" ng-show="bandera" class="btn btn-primary" ng-disabled="" closemodal="modalUserEdit">Eliminar Solicitud</button>
                        <button type="submit" ng-show="bandera" class="btn btn-primary" ng-disabled="formEdit.$invalid" closemodal="modalUserEdit">Aceptar Solicitud</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</section>
<!-- /.content -->




<script>

</script>  
