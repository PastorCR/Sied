<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SIED | Registro</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>


    </head>
    <body class="hold-transition register-page" ng-app="registro" >

        <div class="register-box" ng-controller="controlRegistro" ng-init="">

            <div class="register-box-body">
                <p class="login-box-msg"><b>Registro</b></p>
                <form name="form" ng-submit="agregarUsuario()" class="form-horizontal" novalidate form-autofill-fix>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.nombre.$invalid && !form.nombre.$pristine }">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" ng-model="user.nombre" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.apellido1.$invalid && !form.apellido1.$pristine }">
                        <input type="text" class="form-control" placeholder="Primer Apellido" name="apellido1" ng-model="user.apellido1" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.apellido2.$invalid && !form.apellido2.$pristine }">
                        <input type="text" class="form-control" placeholder="Segundo Apellido" name="apellido2" ng-model="user.apellido2" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.cedula.$invalid && !form.cedula.$pristine }">
                        <input type="text" class="form-control" placeholder="Cédula" name="cedula" ng-model="user.cedula" required>
                        <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.correo.$invalid && !form.correo.$pristine }">
                        <input type="text" class="form-control" placeholder="Correo" name="correo" ng-model="user.correo" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.contrasena.$invalid && !form.contrasena.$pristine }">
                        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" ng-model="user.contrasena" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" ng-class="{ 'has-error' : form.contrasena.$invalid && !form.contrasena.$pristine }">
                        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" ng-model="user.contrasena" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div  name="empresa" class="form-group" ng-controller="controlEmpresa" ng-init="cargarSimple()" ng-class="{ 'has-error' : form.empresa.$invalid && !form.empresa.$pristine }">
                        <select ng-change="update()" ng-model="empresa" class="form-control select2"  
                                ng-options="option.nombre for option in empresas track by option.id"
                                style="width: 100%" required>
                            <option value="" disabled="disabled">Empresa</option>
                        </select>
                    </div>

                    <div class="form-group" ng-controller="controlDepartamento" ng-init="init()" ng-class="{ 'has-error' : form.departamento.$invalid && form.departamento.$dirty }">
                        <select name="departamento" class="form-control select2"  ng-change="update()" 
                                ng-options="option.nombre for option in departamentosfiltrados track by option.id"
                                ng-model="departamento" style="width: 100%" required >
                            <option value="" disabled="disabled">Departamento</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="login.php" class="text-center">¿Ya te has registrado?</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit" ng-disabled="form.$invalid || bandera" class="btn btn-primary btn-block btn-flat">Registrarse</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->

        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
            <button type="button" class="close" ng-click="$close()" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">{{ vm.titulo }} </h3>
            </div>
            <form name="form" class="form-horizontal" novalidate>
            <div class="modal-body">
            <div compile-data template="{{vm.contenido}}">

            </div>
            </div>
            <div class="modal-footer">
            <div compile-data template="{{vm.footer}}">

            </div>
            </div>
            </form>
        </script> 

        <!-- Angular -->


        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="plugins/select2/select2.full.min.js"></script>
        <!-- Angular-->
        <script src="angular/angular.min.js" type="text/javascript"></script>
        <script src="angular/angular-route.min.js" type="text/javascript"></script>
        <script src="angular/app.js" type="text/javascript"></script>
        <script src="bootstrap/js/ui-bootstrap-tpls-2.1.4.min.js" type="text/javascript"></script>
        <script src="angular/registro/controlRegistro.js" type="text/javascript"></script>
        <script src="angular/index/controlEmpresa.js" type="text/javascript"></script>
        <script src="angular/index/controlDepartamento.js" type="text/javascript"></script>
        <script src="angular/modal/modalService.js" type="text/javascript"></script>
        <script src="angular/usuario/userService.js" type="text/javascript"></script>
        <script src="angular/ngStorage.min.js" type="text/javascript"></script>
        <script>
                                //Initialize Select2 Elements
                                $(".select2").select2();
        </script>
    </body>
</html>
