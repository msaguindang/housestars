(function () {
    'use strict';

    String.prototype.toController = function () {
        var camelizedString = camelize(this);
        var controllerName = camelizedString + 'Ctrl';
        controllerName = controllerName.charAt(0).toUpperCase() + controllerName.slice(1);
        controllerName = controllerName.replace("-", "");
        return controllerName;
    };

    function camelize(str) {
        return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function (match, index) {
            if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
            return index == 0 ? match.toLowerCase() : match.toUpperCase();
        });
    }

    angular.module('app')
        .config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
                var routes, setRoutes;

                routes = [
                    'dashboard',
                    'properties',
                    'members',
                    'reviews'
                ];

                setRoutes = function (route) {
                    var config, url, ctrl;
                    url = '/' + route;
                    ctrl = route.toController();
                    config = {
                        templateUrl: $baseUrl + '/housestars/templates/admin-dashboard/' + route + '.html',
                        controller: ctrl
                    };

                    /*// this is used temporarily until DashboardCtrl not being called is resolved
                     switch(ctrl){
                     case "DashboardCtrl":
                     config.controller = 'DashboardCtrl';
                     break;
                     }*/

                    $routeProvider.when(url, config);
                    return $routeProvider;
                };

                routes.forEach(function (route) {
                    return setRoutes(route);
                });

                $routeProvider
                    .when('/', {redirectTo: '/dashboard'})
                    .when('/404', {templateUrl: $baseUrl + '/housestars/templates/admin-dashboard/404.html'})
                    .otherwise({redirectTo: '/404'});

                $locationProvider
                    .hashPrefix('');

            }]
        );

})();
