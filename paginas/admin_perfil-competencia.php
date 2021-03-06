<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Administración de Perfiles de Competencia
    </h1>
    <ol class="breadcrumb">
        <li><a href="#/"><i class="fa  fa-building-o"></i> Índice</a></li>
        <li><a href="#/admin_perfil-competencia">Perfil de Competencias</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content"ng-controller="controlPerfilCompetencia" ng-init="init()">
    <!-- Default box -->
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border ">
                <h3 class="box-title">Perfiles</h3>

                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body table-responsive no-padding" >
                <table class="table table-hover" id='tablaCompetencias'> 
                    <tr class='clickable-row' ng-repeat="perfil in perfiles" sglclick="selectPerfil({{perfil}})" dblclick="modalModificar({{perfil}});">
                        <td> {{perfil.nombre}} </td>
                        <td style="text-align:center"><a ng-click="confirmar(perfil.id)"><i class="fa fa-close"></i>  </a> </td>
                    </tr>
                </table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer" >    
                <a class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#modalPerfilAdd">Agregar </a>
            </div>
        </div>
        <!-- /.box-footer-->
        <!-- /.modal -->
        <div class="modal" id="modalPerfilAdd">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3c8dbc; color:#FFF">
                        <button type="reset" style='opacity: initial; color: #FFF' class="close" data-dismiss="modal" ng-click="resetForm(perfilFormAdd)" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar Perfil de Competencia</h4>
                    </div>
                    <form id="perfilFormAdd" name="perfilFormAdd" class="form-horizontal" ng-submit="agregar()" novalidate> 
                        <div class="modal-body">

                            <div class="form-group" ng-class="{ 'has-error' : perfilFormAdd.perfilAdd.$invalid && !perfilFormAdd.perfilAdd.$pristine }">
                                <label for="perfil" class="col-sm-2 control-label">Perfil</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="Nombre" id="perfil" name="perfilAdd" ng-model="perfilAdd" required>
                                    <p ng-show="perfilFormAdd.perfilAdd.$invalid && !perfilFormAdd.perfilAdd.$pristine" class="help-block">Nombre del perfil</p>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-default pull-left" ng-click="resetForm(perfilFormAdd)" data-dismiss="modal" id="cancelar">Cancelar</button>
                            <button type="submit" class="btn btn-primary" ng-disabled="perfilFormAdd.$invalid" closemodal="modalPerfilAdd">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <!-- /.modalEditar -->
        <div class="modal" id="modalPerfilEdit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Perfil de Competencia {{perfil.nombre}}</h4>
                    </div>
                    <form name="perfilFormEdit" class="form-horizontal" ng-submit="modificar()" novalidate> 
                        <div class="modal-body">

                            <div class="form-group" ng-class="{ 'has-error' : perfilFormEdit.perfilEdit.$invalid && !perfilFormEdit.perfilEdit.$pristine }">
                                <label for="perfil" class="col-sm-2 control-label">Perfil</label>
                                <div class="col-sm-10">
                                    <input class="form-control" placeholder="Nombre" id="perfil" name="perfilEdit" ng-model="perfilEdit" required>
                                    <p ng-show="perfilFormEdit.perfilEdit.$invalid && !perfilFormEdit.perfilEdit.$pristine" class="help-block">Nombre del perfil</p>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancelar">Cancelar</button>
                            <button type="submit" class="btn btn-primary" ng-disabled="perfilFormEdit.$invalid" closemodal="modalPerfilEdit">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Competencias de Perfil: <b>{{perfil.nombre}}</b> </h3>
                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body table-responsive">
                <div class="box-group" id="accordion">
                    <div class="panel box box-primary" ng-repeat="competencia in perfil.competencias">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" data-target="#collapse{{$index}}">
                                     {{competencia.titulo}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$index}}" class="panel-collapse collapse">
                            <div class="box-body">
                                <b>Descripción:</b>
                                <p>{{competencia.descripcion}}</p>
                                <div class="box-group">   
                                    <table class="table table-bordered table-hover table-responsive">
                                        <thead>
                                        <th>Detalles de la competencia</th>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="detalle in competencia.detalles">
                                                <td>{{detalle.descripcion}}</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                <!-- ./detalles-->
                            </div>
                        </div>
                    </div>
                </div>
                
                <p style="font-size: 90%" ng-show="perfil.competencias.length == 0" class="label bg-red margin">Este perfil no posee competencias</p>

            </div>
            <!-- /.box-body -->
            <div class="box-footer" >    
                <a class="btn btn-primary btn-lg pull-right"  href="#/editar_perfil-competencia/{{perfil.id}}">Editar </a>
            </div>
        </div>

    </div> 

    <!-- /.box-footer-->
    
</section>
<!-- /.content -->
<script type="text/javascript">
//    $("tr").click(function () {
//        $(this).addClass("active").siblings().removeClass("active");
//    });
    
 $('#tablaCompetencias').on('click', '.clickable-row', function(event) {
  $(this).addClass('active').siblings().removeClass('active');
});
</script>
