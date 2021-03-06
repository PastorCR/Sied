angular.module("index")
        .controller("controlMeta", ['$scope', 'factoryMeta', 'modalService', 'sessionService', 'ShareDataService', '$rootScope',
            function ($scope, factoryMeta, modalService, sessionService, ShareDataService, $rootScope) {

                $scope.metas = [];
                $scope.tiene_Metas = true;
                $scope.meta = 0;

                $scope.meta_isEvaluable = 1;
                $scope.is_Check = true;
                $scope.metaAprobRH = false;  // para saber si la meta ya fue aprobada por RH.

                $scope.meta_titulo = "";
                $scope.meta_descripcion = "";

                $scope.actual = "0";  // se utiliza para saber cuál es la meta a la que se está haciendo referencia.

                $scope.auto_Evaluacion = 0;
                $scope.userOnline = [];

                // En las siguientes variables comment se guardarán los comentarios de la meta hechos por Jefe y RH.
                $scope.commentJefe = "";
                $scope.commentRH = "";

                $scope.titleMeta = "";
                $scope.pesosEquilibrados = false;

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
                    $scope.meta_titulo = "";
                    $scope.meta_descripcion = "";
                };

// Para limpiar la modal cuando se le da 'x' de cerrar o Cancelar.
                $scope.resetForm = function (form) {
                    form.$setPristine();
                    form.$setUntouched();
                };


                $rootScope.$on("CallParentMethod", function () {
                    $scope.cargar();
                });


                $scope.cargar = function () {
                    var obj = {id: $scope.userOnline.id};
                    $scope.tiene_Metas = true;

                    factoryMeta.cargarMetasUser(obj).then(function (res) {
                        if (res.status === 'error') {
                            alert(res.message);
                        }
                        if (res.status === 'success') {
                            $scope.metas = res.data;
                            if ($scope.metas.length === 0)
                                $scope.tiene_Metas = false;
                            ShareDataService.prepForBroadcast(pesos());
                            $scope.pesosEquilibrados = factoryMeta.getPesosCorrectos();
                        }
                    });
                };


                $scope.verCambio = function () {
                    $('input').on('ifUnchecked', function () {
                        $scope.meta_isEvaluable = 0;
                        $scope.is_Check = false;
                    });

                    $('input').on('ifChecked', function () {
                        $scope.meta_isEvaluable = 1;
                        $scope.is_Check = true;
                    });
                };



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
                            .then(function (res) {
                                if (res.status === 'error') {
                                    alert(res.message);
                                }
                                if (res.status === 'success') {
                                    $scope.cargar();
                                    modalService.modalOk("Éxito", "<p>" + res.message + "</p>")
                                            .result.then(function () {
                                                modalService.modalOk("Aviso", "<p>¡Debe recalcular los pesos de las metas!</p>")
                                                        .result.then(function () {
                                                            angular.element(document.querySelector('#modalPeso')).modal();  // para abrir la modal de los pesos
                                                        });
                                            });
                                }
                            });
                };

                $scope.agregar = function (idForm) {
                    var metaObj = {
                        is_Evaluable: $scope.meta_isEvaluable,
                        peso: '0',
                        titulo: $scope.meta_titulo,
                        descripcion: $scope.meta_descripcion,
                        usuario: $scope.userOnline.id
                    };

                    factoryMeta.agregarMeta(metaObj).then(function (res) {
                        if (res.status === 'error') {
                            alert(res.message);
                        }
                        if (res.status === 'success') {
                            modalService.modalOk("Éxito", "<p>" + res.message + "</p>");
                            $scope.meta_isEvaluable = 1;
                            $scope.is_Check = true;
                            $scope.meta_peso = 0;
                            $scope.meta_titulo = undefined;
                            $scope.meta_descripcion = undefined;
                            $scope.cargar();
                            factoryMeta.notificarAddMetas($scope.userOnline.id);
                            $scope.resetForm(idForm);
                        }
                    });

                };




                $scope.updateActual = function (meta) {
                    $scope.actual = meta.id;
                    $scope.metaAprobRH = false;

                    $scope.meta_isEvaluable = meta.evaluable;
                    ($scope.meta_isEvaluable === "1") ?
                            ($scope.is_Check = true) : ($scope.is_Check = false);


                    if (meta.aprobacion_rh === "1")
                        $scope.metaAprobRH = true;

                    $scope.meta_titulo = meta.titulo;
                    $scope.meta_descripcion = meta.descripcion;
                };




                $scope.modificar = function () {
                    if (!$scope.metaAprobRH) {  // si NO ha sido aprobado por RH, entonces puede cambiar todo...
                        var metaObj = {
                            is_Evaluable: $scope.meta_isEvaluable,
                            titulo: $scope.meta_titulo,
                            descripcion: $scope.meta_descripcion,
                            id: $scope.actual
                        };

                        factoryMeta.updateMeta(metaObj)
                                .then(function (res) {
                                    if (res.status === 'error') {
                                        alert(res.message);
                                    }
                                    if (res.status === 'success') {
                                        modalService.modalOk("Éxito", "<p>" + res.message + "</p>");
                                        $scope.meta_isEvaluable = 1;
                                        $scope.is_Check = true;
                                        $scope.meta_titulo = undefined;
                                        $scope.meta_descripcion = undefined;
                                        $scope.actual = "0";
                                        $scope.cargar();
                                    }
                                });
                    } else { // si YA fue aprobada por RH, entonces solo puede cambiar lo de evaluable...

                        var metaObj = {
                            is_Evaluable: $scope.meta_isEvaluable,
                            id: $scope.actual
                        };

                        factoryMeta.updateEvaluableMeta(metaObj)
                                .then(function (res) {
                                    if (res.status === 'error') {
                                        alert(res.message);
                                    }
                                    if (res.status === 'success') {
                                        modalService.modalOk("Éxito", "<p>" + res.message + "</p>");
                                        $scope.meta_isEvaluable = 1;
                                        $scope.is_Check = true;
                                        $scope.actual = "0";
                                        $scope.cargar();
                                    }
                                });
                    }
                };



                pesos = function () {
                    var x = [];
                    $scope.metas.forEach(function (meta) {
                        x.push({id: meta.id, titulo: meta.titulo, peso: meta.peso});
                    });
                    return {metas: x};
                };



                // función que trae los comentarios hechos por Jefe y RH de una meta en específico.
                $scope.getComments = function (meta) {
                    factoryMeta.getMeta(meta).then(function (res) {
                        if (res.status === 'error') {
                            alert(res.message);
                        }
                        if (res.status === 'success') {
                            $scope.titleMeta = res.data[0].titulo;
                            $scope.commentJefe = res.data[0].comentario_j;
                            $scope.commentRH = res.data[0].comentario_rh;

                            if ($scope.commentJefe === null || $scope.commentJefe === "") {
                                $scope.commentJefe = "";
                            }

                            if ($scope.commentRH === null || $scope.commentRH === "") {
                                $scope.commentRH = "";
                            }
                        }

                    });
                };



            }])
        .factory("factoryMeta", function (apiConnector) {
            var meta = {};
            var pesosCorrectos = false;

            meta.cargarMetas = function () {
                return apiConnector.get('api/metas/all');
            };
            
            
            meta.notificarAprobacionJefe = function (obj) {
                return apiConnector.post('api/evaluaciones/notificacionJefe', obj);
            };
            
            
           meta.notificarAprobacionRH = function (obj) {
                return apiConnector.post('api/evaluaciones/notificacionRH', obj);
            };
            
            
           meta.notificarAutoEvMetas = function (obj) {
                return apiConnector.post('api/evaluaciones/notificacionAutoMetas', obj);
            };
            
            
            meta.notificarEvalMetas = function (obj) {
                return apiConnector.post('api/evaluaciones/notificacionEvaMetas', obj);
            };   
            
            
           meta.notificarAddMetas = function (obj) {
                return apiConnector.post('api/evaluaciones/notificacionIngreso', obj);
            };          


            meta.cargarMetasUser = function (obj) {
                return apiConnector.post('api/metas/all', obj);
            };


            meta.agregarMeta = function (metaObj) {
                return apiConnector.post('api/metas/add', metaObj);
            };


            meta.updateMeta = function (obj) {
                return apiConnector.put('api/metas/set', obj);
            };


            meta.updateEvaluableMeta = function (obj) {
                return apiConnector.put('api/metas/setEvaluable', obj);
            };

            meta.eliminarMeta = function (metaObj) {
                return apiConnector.post('api/metas/del', metaObj);
            };


            meta.updateAutoEvaluaciones = function (metaObj) {
                return apiConnector.put('api/metas/setAuto', metaObj);
            };


            meta.updateEvaluaciones = function (metaObj) {
                return apiConnector.put('api/metas/setEvaluacion', metaObj);
            };

            meta.aprobar_Desaprobar = function (metaObj) {
                return apiConnector.put('api/metas/aprobarMeta', metaObj);
            };

            meta.aprobar_DesaprobarRH = function (metaObj) {
                return apiConnector.put('api/metas/aprobarMetaRH', metaObj);
            };

            meta.getMeta = function (obj) {
                return apiConnector.post('api/metas/allFrom', obj);
            };


            meta.modificarPeso = function (obj) {
                return apiConnector.put('api/metas/setPeso', obj);
            };
            
            
            meta.setPesosCorrectos = function (valor){
                pesosCorrectos = valor;
            };
            
            
            meta.getPesosCorrectos = function (){
                return pesosCorrectos;
            };


            return meta;

        }).directive('popover', function ($compile, $timeout) {
    return {
        restrict: 'A',
        link: function (scope, el, attrs) {
            var content = attrs.content; //get the template from the attribute
            var elm = angular.element('<div />'); //create a temporary element
            elm.append(attrs.content); //append the content
            $compile(elm)(scope); //compile 
            $timeout(function () { //Once That is rendered
                el.removeAttr('popover').attr('data-content', elm.html()); //Update the attribute
                el.popover(); //set up popover
            });
        }
    };
});



