'use strict';

var housestars = angular.module('housestarsDirectives', []);

housestars.directive('stringToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(value) {
                return '' + value;
            });
            ngModel.$formatters.push(function(value) {
                return parseFloat(value);
            });
        }
    };
});

housestars.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                scope.$apply(function () {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

housestars.directive('fileImageSrc', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        scope: {
            fileImageSrc: '='
        },
        link: function (scope, element, attrs) {
            // var model = $parse(attrs.fileImageModel);
            // var modelSetter = model.assign;
            element.bind('change', function () {
                scope.$apply(function () {
                    // modelSetter(scope, element[0].files[0]);
                    if (element[0].files[0]) {
                        var FR = new FileReader();
                        FR.onload = function (e) {
                            scope.$apply(function () {
                                scope.fileImageSrc = e.target.result;
                            });
                        };
                        FR.readAsDataURL(element[0].files[0]);
                    }
                });

            });
        }
    };
}]);