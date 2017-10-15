jQuery(document).ready(function($){

});


var organizacionOperacionApp = angular.module('organizacionOperacion', []);

organizacionOperacionApp.controller('jornadaLaboralTurnos', [
    '$scope',
    function($scope){
        $scope.forms = [];

        $scope.addForm = function(){
            $scope.forms.push($scope.forms.length);
        };
    }
]);

organizacionOperacionApp.controller('mantenimientos', [
    '$scope',
    function($scope){
        $scope.activar = '';
    }
]);

organizacionOperacionApp.controller('consumo', [
    '$scope',
    function($scope){
        $scope.sumatoria = function(cantidades){
            var total = 0;
            if(cantidades != null){
                $.each(cantidades, function(index, value){
                    total += parseInt(value);
                });
            }
            return total;
        };
    }
]);

organizacionOperacionApp.controller('estadoInicial', [
    '$scope',
    function($scope){
        $scope.sistemasInformacion = [];
        $scope.addSistemaInformacionForm = function(){
            $scope.sistemasInformacion.push($scope.sistemasInformacion.length);
        };

        $scope.sistemasMedicion = [];
        $scope.addSistemaMedicionForm = function(){
            $scope.sistemasMedicion.push($scope.sistemasMedicion.length);
        };
    }
]);

organizacionOperacionApp.controller('censoCarga', [
    '$scope',
    function($scope){
        $scope.forms = [];

        $scope.addForm = function(){
            $scope.forms.push($scope.forms.length);
        };
    }
]);