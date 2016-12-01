angular.module("index")
        .controller("controlMeta", ['$scope', 'factoryMeta', 'modalService', 'sessionService', 'ShareDataService', function ($scope, factoryMeta, modalService, sessionService, ShareDataService) {

                $scope.metas = [];
                $scope.meta = 0;

                $scope.meta_isEvaluable = 1;
                $scope.is_Check = true;

                $scope.meta_peso = 0;
                $scope.meta_titulo = "";
                $scope.meta_descripcion = "";

                $scope.actual = "0";  // se utiliza para saber cuál es la meta a la que se está haciendo referencia.

                $scope.auto_Evaluacion = 0;
                $scope.userOnline = [];

                /*
                 * Función que inicializa la lista de metas 
                 */
                $scope.init = function () {
                    $scope.getUserOnline();
                    $scope.cargar();
                };


                $scope.getUserOnline = function () {
                    $scope.userOnline = sessionService.getUsuario();
                };


                /*
                 * Función que resetea las variables
                 */
                $scope.resetValues = function () {
                    $scope.meta_isEvaluable = 1;
                    $scope.is_Check = true;

                    $scope.meta_peso = 0;
                    $scope.meta_titulo = "";
                    $scope.meta_descripcion = "";
                };


                $scope.cargar = function () {
                    var obj = {id: $scope.userOnline.id};
                    factoryMeta.cargarMetasUser(obj)
                            .success(function (data, status, headers, config) {
                                $scope.metas = data.metas;
                                ShareDataService.prepForBroadcast(pesos());
                            })
                            .error(function (data, status, headers, config) {
                                alert("failure message: " + JSON.stringify(headers));
                            });
                };



                $('input').on('ifUnchecked', function () {
                    $scope.meta_isEvaluable = 0;
                    $scope.is_Check = false;

                });

                $('input').on('ifChecked', function () {
                    $scope.meta_isEvaluable = 1;
                    $scope.is_Check = true;
                });



                $scope.confirmarEliminacion = function (id) {
                    modalService.modalYesNo("Confirmación", "<p>" + "¿Está seguro de realizar la acción?" + "</p>")
                            .result.then(function (selectedItem) {
                                if (selectedItem === "si")
                                    $scope.eliminar(id);
                            });
                };




                $scope.eliminar = function (idParam) {

                    var metaObj = {
                        id: idParam
                    };

                    factoryMeta.eliminarMeta(metaObj)
                            .success(function (data, status, headers, config) {
                                modalService.modalOk(data.titulo, "<p>" + data.msj + "</p>");
                                $scope.cargar();
                            })
                            .error(function (data, status, headers, config) {
                                alert("failure message: " + JSON.stringify(data));
                            });
                };


                $scope.agregar = function () {
                    var metaObj = {
                        is_Evaluable: $scope.meta_isEvaluable,
                        peso: $scope.meta_peso,
                        titulo: $scope.meta_titulo,
                        descripcion: $scope.meta_descripcion,
                        usuario: $scope.userOnline.id
                    };

                    factoryMeta.agregarMeta(metaObj)
                            .success(function (data, status, headers, config) {
                                modalService.modalOk(data.titulo, "<p>" + data.msj + "</p>");
                                $scope.meta_isEvaluable = 1;
                                $scope.is_Check = true;

                                $scope.meta_peso = 0;
                                $scope.meta_titulo = "";
                                $scope.meta_descripcion = "";
                                $scope.cargar();
                            })
                            .error(function (data, status, headers, config) {
                                alert("failure message: " + JSON.stringify(data));
                            });
                };




                $scope.updateActual = function (meta) {
                    $scope.actual = meta.id;

                    $scope.meta_isEvaluable = meta.evaluable;
                    ($scope.meta_isEvaluable === "1") ?
                            ($scope.is_Check = true) : ($scope.is_Check = false);

                    $scope.meta_peso = parseInt(meta.peso);
                    $scope.meta_titulo = meta.titulo;
                    $scope.meta_descripcion = meta.descripcion;
                };




                $scope.modificar = function () {
                    var metaObj = {
                        is_Evaluable: $scope.meta_isEvaluable,
                        peso: parseInt($scope.meta_peso),
                        titulo: $scope.meta_titulo,
                        descripcion: $scope.meta_descripcion,
                        id: $scope.actual
                    };

                    factoryMeta.updateMeta(metaObj)
                            .success(function (data, status, headers, config) {
                                modalService.modalOk(data.titulo, "<p>" + data.msj + "</p>");
                                $scope.meta_isEvaluable = 1;
                                $scope.is_Check = true;
                                $scope.meta_peso = 0;
                                $scope.meta_titulo = "";
                                $scope.meta_descripcion = "";
                                $scope.actual = "0";
                                $scope.cargar();
                            })
                            .error(function (data, status, headers, config) {
                                alert("failure message: " + JSON.stringify(data));
                            });
                };
                
                
                
               pesos = function () {
                    var x = [];
                    $scope.metas.forEach(function (meta) {
                        x.push({id: meta.id, titulo: meta.titulo, peso: meta.peso});
                    });
                    return {metas: x};
                };



            }])
        .factory("factoryMeta", function ($http) {
            var meta = {};

            meta.cargarMetas = function () {
                return $http.get('/Sied/services/meta/get-metas.php');
            };


            meta.cargarMetasUser = function (obj) {
                return $http.post('/Sied/services/meta/get-metas.php', obj);
            };


            meta.agregarMeta = function (metaObj) {
                return $http.post('/Sied/services/meta/add-meta.php', metaObj);
            };


            meta.updateMeta = function (obj) {
                return $http.post('/Sied/services/meta/set-meta.php', obj);
            };

            meta.eliminarMeta = function (metaObj) {
                return $http.post('/Sied/services/meta/del-meta.php', metaObj);
            };


            meta.updateAutoEvaluaciones = function (metaObj) {
                return $http.post('/Sied/services/meta/set-autoevMetas.php', metaObj);
            };


            meta.updateEvaluaciones = function (metaObj) {
                return $http.post('/Sied/services/meta/set-EvalMetas.php', metaObj);
            };

            meta.aprobar_Desaprobar = function (metaObj) {
                return $http.post('/Sied/services/meta/aprobar_desaprobarMeta.php', metaObj);
            };

            meta.getMeta = function (obj) {
                return $http.post('/Sied/services/meta/get-metaEspecifica.php', obj);
            };


            meta.modificarPeso = function (obj) {
                return $http.post('/Sied/services/meta/set-PesoMeta.php', obj);
            };

            return meta;

        });



