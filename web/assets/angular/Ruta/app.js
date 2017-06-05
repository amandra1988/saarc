(function(angular){
    
    angular.module('admin-rutas', [ 'ui.router','ngResource','ui.bootstrap'])
    
    .constant('urlBase', saConstants.urlBase)
    .constant('urlBaseImg', saConstants.urlBaseImg)
    .constant('urlBaseApi', saConstants.urlBaseApi)
    .constant('urlBasePartials', saConstants.urlBaseTmp)
    .constant('apiKey', saConstants.apiKey)
   
    .run(['$http', 'apiKey', function($http, apiKey) {
        $http.defaults.headers.common = {'apikey': apiKey};
    }])

    .config( ['$stateProvider', '$urlRouterProvider', 'urlBasePartials',
        function  ($stateProvider ,  $urlRouterProvider ,  urlBasePartials) {
            var listaDeRutas = {
                name: 'lista_rutas',
                url: '/',
                controller: 'RutasController',
                templateUrl: urlBasePartials + 'lista_rutas.html'
            };
            $stateProvider.state(listaDeRutas);
            $urlRouterProvider.when('', '/');
        }
    ]);
})(angular);