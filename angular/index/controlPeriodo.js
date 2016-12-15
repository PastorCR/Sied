angular.module('index')
        .controller('controlPeriodo', ['$scope', 'apiConnector', function ($scope, apiConnector) {

                $scope.periodos = [];
                $scope.periodo = {};
                $scope.periodoActual = {};
                $scope.model = {
                    date1: {
                        startDate: undefined,
                        endDate: undefined
                    },
                    date2: {
                        startDate: undefined,
                        endDate: undefined
                    },
                    date3: {
                        startDate: undefined,
                        endDate: undefined
                    },
                    nombre: undefined,
                    id: undefined
                };
                $scope.addBool = false;

                $scope.init = function () {
                    $scope.cargar();
                };
                $scope.cargar = function (){
                    apiConnector.get('api/periodos/get').then(function (res) {
                        if (res.status == "success") {
                            $scope.setPeriodoActual(res.data);
                            $scope.setPeriodo(res.data);
                        }
                    });
                    apiConnector.get('api/periodos/getAll').then(function (res) {
                        if (res.status == "success") {
                            $scope.periodos = res.data;
                        }
                    });
                };
                
                $scope.verPeriodo = function (periodo) {
                    $scope.setPeriodo(periodo);
                };
                $scope.isPeriodoActual = function () {
                    return $scope.periodo.id === $scope.periodoActual.id;
                };
                $scope.agregarPeriodo = function () {
                    $scope.addBool = true;
                };
                $scope.cancelar = function () {
                    $scope.addBool = false;
                    $scope.perABool = false;
                    $scope.setModel();
                };
                $scope.setModel = function () {
                    $scope.model = {
                        date1: {
                            startDate: undefined,
                            endDate: undefined
                        },
                        date2: {
                            startDate: undefined,
                            endDate: undefined
                        },
                        date3: {
                            startDate: undefined,
                            endDate: undefined
                        },
                        nombre: undefined,
                        id: undefined
                    };
                };

                $scope.setPeriodo = function (periodo) {

                    $scope.periodo = {
                        nombre: periodo.nombre,
                        id: periodo.id,
                        date1: {
                            startDate: periodo.fechainicio,
                            endDate: periodo.fechafinal
                        },
                        date2: {
                            startDate: periodo.fiper1,
                            endDate: periodo.ffper1
                        },
                        date3: {
                            startDate: periodo.fiper2,
                            endDate: periodo.ffiper2
                        }
                    };
                };
                $scope.setPeriodoActual = function (periodo) {

                    $scope.periodoActual = {
                        nombre: periodo.nombre,
                        id: periodo.id,
                        date1: {
                            startDate: periodo.fechainicio,
                            endDate: periodo.fechafinal
                        },
                        date2: {
                            startDate: periodo.fiper1,
                            endDate: periodo.ffper1
                        },
                        date3: {
                            startDate: periodo.fiper2,
                            endDate: periodo.ffiper2
                        }
                    };
                };

                $scope.agregar = function () {
                    apiConnector.post('api/periodos/add',$scope.model).then(function(res){
                        if(res.status === "success"){
                            $scope.cancelar();
                            $scope.cargar();
                        }
                    });
                };

                $scope.validar = function () {
                    return $scope.model.date2.startDate.isSameOrAfter($scope.model.date1.startDate)
                            && $scope.model.date3.startDate.isSameOrAfter($scope.model.date2.endDate)
                            && $scope.model.date3.endDate.isSameOrBefore($scope.model.date1.endDate);

                };
                $scope.time = function (x, moment) {
                    return $scope.$eval("model." + x + "." + moment);
                };
                $scope.$watch('model.date1', function () {
                    $scope.model.nombre = "Periodo" + ($scope.model.date1.startDate.month() + 1) + "-" + ($scope.model.date1.endDate.month() + 1) + "/" + $scope.model.date1.startDate.year();
                }, true);


            }]);