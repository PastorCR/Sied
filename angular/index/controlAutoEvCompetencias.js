angular.module("index")
        .controller("controlAutoEvCompetencias", ['$scope', 'factoryCompetenciasColab', 'modalService',
            'servicioCompetAutoEv', 'servicioCompetColab',
            function ($scope, factoryCompetenciasColab, modalService, servicioCompetAutoEv, servicioCompetColab) {

                $scope.competencias = 0;
                $scope.idCompetencias = new Array();
                $scope.autoEvaluaciones = new Array();

                $scope.stringAutoEvaluaciones = new Array();
                $scope.arrayAutoEvaluacionesCompet = [];
                $scope.arrayTemporalAutoEv = new Array();

                $scope.objetoCompuesto = new Array();

                $scope.perfilCompet = undefined;  // aqui se guarda el id del perfil de competencia del usuario.
                $scope.userOnline = undefined;
                $scope.nombrePerfil = undefined;  // aquí se almacena el nombre del perfil de competencia

                $scope.arrayFinal = new Array();
                $scope.objetoCompuesto = {titulo: "", detalles: ""};


                $scope.init = function () {

                    $scope.getUserOnline();
                    $scope.getPerfilCompetencia().then(function () {

                        $scope.cargar().then(function () {

                            var idObj = {id: $scope.userOnline};
                            servicioCompetAutoEv.loadAutoEvaluacionesService(idObj).then(function () {

                                $scope.cargarAutoEvaluaciones();
                                $scope.loadTodo();

                            });
                        });
                    });
                };


                $scope.getAutoEv = function(stringAutoEv){
                    $scope.autoEvaluaciones = [];

                    if (stringAutoEv !== "" && stringAutoEv !== null
                            && stringAutoEv !== undefined) {

                        $scope.arrayAutoEvaluacionesCompet = stringAutoEv.split(';');

                        angular.forEach($scope.arrayAutoEvaluacionesCompet, function (elemento, key) {

                            // autoEvaluaciones contiene la lista de autoevaluaciones
                            $scope.arrayTemporalAutoEv = elemento.split(',');
                            $scope.autoEvaluaciones = $scope.autoEvaluaciones.concat($scope.arrayTemporalAutoEv);
                            $scope.arrayTemporalAutoEv = [];
                        });
                    }
                };



                $scope.getUserOnline = function () {
                    servicioCompetColab.loadUsuarioId();
                    $scope.userOnline = servicioCompetColab.getUsuarioID();
                };



                $scope.getPerfilCompetencia = function () {
                    var obj = {id: $scope.userOnline};
                    return factoryCompetenciasColab.getPerfilCompetUser(obj)
                            .then(function (res) {
                                if (res.status === 'error') {
                                    alert(res.message);
                                }
                                if (res.status === 'success') {
                                    $scope.perfilCompet = res.data.id;
                                    $scope.nombrePerfil = res.data.nombre;
                                }
                            });
                };



                $scope.cargar = function () {
                    return factoryCompetenciasColab.cargarCompetenciasDePerfil($scope.perfilCompet)  // hay que fijarse cuál Perfil de Competencia tiene asociado el Colaborador
                            .then(function (res) {
                                if (res.status === 'error') {
                                    alert(res.message);
                                }
                                if (res.status === 'success') {
                                    $scope.competencias = res.data;

                                    $scope.idCompetencias = new Array();
                                    angular.forEach($scope.competencias, function (compet) {
                                        $scope.idCompetencias = $scope.idCompetencias.concat(compet.id);
                                    });
                                }
                            });
                };




                $scope.confirmarAutoEvCompe = function () {
                    modalService.modalYesNo("Confirmación", "<p>" + "¿Está seguro de realizar la acción?" + "</p>")
                            .result.then(function (selectedItem) {
                                if (selectedItem === "si")
                                    $scope.guardarAutoEvComp();
                            });
                };



                $scope.guardarAutoEvComp = function () {

                    $scope.objAutoEv = new Array();
                    $scope.autoEvaluaciones = [];
                    $scope.string_AutoEv = "";  // string que contiene todas las autoevaluaciones de los detalles de la competencia.

                    // Se recorren los inputs...
                    angular.forEach($scope.idCompetencias, function (id_Elemento, key) {

                        $scope.string_auxiliar = "";
                        /*
                         Encontrar los inputs que tengan el mismo name, con lo cual corresponden a una competencia
                         en específico.
                         */
                        $scope.inputs = angular.element(document).find('input').filter(document.getElementsByName(id_Elemento));

                        /* Se recorren luego cada uno de los inputs de una competencia en específico, para obtener los valores
                         (autoevaluaciones) de los detalles. 
                         */
                        angular.forEach($scope.inputs, function (autoEv, key) {

                            (autoEv.value === "") ?
                                    $scope.autoEvaluaciones = $scope.autoEvaluaciones.concat("-")
                                    :
                                    $scope.autoEvaluaciones = $scope.autoEvaluaciones.concat(autoEv.value);
                        });

                        // Se unen las autoevaluaciones en un solo string, separados por ','
                        $scope.string_auxiliar = $scope.autoEvaluaciones.join(',');

                        // Luego se unen con las anteriores autoevaluaciones, separados por ';'         
                        $scope.string_AutoEv = $scope.string_AutoEv + $scope.string_auxiliar + ";";

                        $scope.autoEvaluaciones = new Array();

                    });

                    $scope.string_AutoEv = $scope.string_AutoEv.substr(0, $scope.string_AutoEv.length - 1);

                    var obj = {value: $scope.string_AutoEv, idColab: $scope.userOnline};  // se envía el user para comprobar
                    //  si ya posee autoevaluaciones o 
                    //  evaluaciones

                    factoryCompetenciasColab.updateAutoEvaluacionesCompe(obj).then(function (res) {
                        if (res.status === 'error') {
                            alert(res.message);
                        }
                        if (res.status === 'success') {
                            modalService.modalOk("Éxito", "<p>" + res.message + "</p>");
                            $scope.getAutoEv($scope.string_AutoEv);
                                if ($scope.is_TodasAutoEvCompet($scope.autoEvaluaciones)) {
                                    factoryCompetenciasColab.notificarAutoEvCompet($scope.userOnline);
                                }
                        }
                    });

                };




                $scope.cargarAutoEvaluaciones = function () {

                    $scope.stringAutoEvaluaciones = servicioCompetAutoEv.getStringAutoEv();
                    $scope.autoEvaluaciones = [];

                    if ($scope.stringAutoEvaluaciones !== "" && $scope.stringAutoEvaluaciones !== null
                            && $scope.stringAutoEvaluaciones !== undefined) {

                        $scope.arrayAutoEvaluacionesCompet = $scope.stringAutoEvaluaciones.split(';');

                        angular.forEach($scope.arrayAutoEvaluacionesCompet, function (elemento, key) {

                            // autoEvaluaciones contiene la lista de autoevaluaciones
                            $scope.arrayTemporalAutoEv = elemento.split(',');
                            $scope.autoEvaluaciones = $scope.autoEvaluaciones.concat($scope.arrayTemporalAutoEv);
                            $scope.arrayTemporalAutoEv = [];
                        });
                    }
                };



                $scope.is_TodasAutoEvCompet = function (listaMetas) {
                    return listaMetas.every(elem => (elem !== '-'));
                };




                $scope.loadTodo = function () {
                    var obj = {};
                    var contadorEvaluaciones = 0;
                    var detalles = new Array();

                    angular.forEach($scope.competencias, function (elemento, key) {
                        if (elemento.detalles.length === 0)
                            contadorEvaluaciones++;
                        angular.forEach(elemento.detalles, function (elemento2, key2) {

                            obj = {detail: elemento2.descripcion, autoev: $scope.autoEvaluaciones[contadorEvaluaciones],
                                idObj: elemento2.id, nameObj: elemento.id, titleCompet: elemento.titulo};
                            detalles = detalles.concat([obj]);
                            contadorEvaluaciones++;
                        });

                        $scope.objetoCompuesto.titulo = elemento.titulo;
                        $scope.objetoCompuesto.detalles = detalles;
                        $scope.arrayFinal = $scope.arrayFinal.concat($scope.objetoCompuesto);
                        $scope.objetoCompuesto = {titulo: "", detalles: ""};
                        detalles = [];
                    });

                };





            }]);



