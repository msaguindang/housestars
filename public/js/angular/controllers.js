'use strict';
var housestars = angular.module('houseStarsControllers', []);

housestars.controller('MainCtrl', ['$scope', function ($scope) {

    console.log('mainCtrl');

}]);

housestars.controller('DashboardCtrl', ['$scope', function ($scope) {

    console.log('dashboardCtrl');

}]);

housestars.controller('MembersCtrl', ['$scope', 'http', function ($scope, http) {

    console.log('membersCtrl');

    $scope.users = [];
    $scope._users = angular.copy($scope.users);

    $scope.getAllUsers = function (){

        http.getAllUsers().then(function(response){
            console.log('all users: ', response);
            $scope.users = response.data.users;
            $scope._users = angular.copy($scope.users);
        });
    };

    $scope.editUser = function (user, index) {

    };

    $scope.deleteUser = function (user, index) {

        var deleteSingleUser = confirm('Are you sure you want to delete?');

        if(deleteSingleUser){

            http.deleteUser(user).then(function(response){
                console.log('user deleted: ', response);
                $scope._users.splice(index, 1);
                $scope.users.splice(index, 1);
            });


        }
    };


    // initialize
    $scope.getAllUsers();

}]);

housestars.controller('PropertiesCtrl', ['$scope', 'http', '$uibModal', function ($scope, http, $uibModal) {

    console.log('propertiesCtrl');

    $scope.properties = [];

    $scope.getAllProperties = function () {

        http.getAllProperties().then(function(response){

            console.log('properties', response);
            $scope.properties = response.data.properties;
            $scope._properties = angular.copy($scope.properties);

        });

    };

    $scope.deleteProperty = function (property, index) {

        var deleteThisProperty = confirm('Are you sure you want to delete?');

        if(deleteThisProperty){

            console.log(property);

            http.deleteProperty(property).then(function(response){
                console.log('property deleted: ', response);
                $scope._properties.splice(index, 1);
                $scope.properties.splice(index, 1);
            });


        }

    };

    $scope.editProperty = function (property, index) {

        http.getProperty(property).then(function(response){

            console.log('property: ', response);
            $scope.propertyData = response.data;
            $scope.openEditPropertyModal(index);

        });

    };

    $scope.showAgency = function (property) {

        http.getAgency(property).then(function(response){
            console.log('agency: ', response);
            $scope.agencyData = response.data;
            $scope.openAgencyModal();
        });

    };

    $scope.openAgencyModal = function () {

        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'agency-modal.html',
            controller: 'AgencyModalCtrl',
            // size: 'lg',
            resolve: {
                agencyData: function () {
                    return $scope.agencyData;
                },
            }
        });

        modalInstance.result.then(function (selectedItem) {
            console.log('Success Modal dismissed at: ' + new Date());
        }, function () {
            console.log('Modal dismissed at: ' + new Date());

        });
    };

    $scope.openEditPropertyModal = function (index) {

        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'edit-property-modal.html',
            controller: 'EditPropertyModalCtrl',
            // size: 'lg',
            resolve: {
                propertyData: function () {
                    return $scope.propertyData;
                },
            }
        });

        modalInstance.result.then(function (response) {

            switch(response.status){
                case 'success':
                    $scope.reloadSingleProperty(index);
                    break;
            }

            console.log('Success Modal dismissed at: ' + new Date());
        }, function () {
            console.log('Modal dismissed at: ' + new Date());

        });

    };

    $scope.reloadSingleProperty = function (index) {
        $scope.getAllProperties();
    };

    // initialize
    $scope.getAllProperties();

}]);

housestars.controller('AgencyModalCtrl', ['$scope', 'agencyData', '$uibModalInstance', function ($scope, agencyData, $uibModalInstance) {

    console.log('AgencyModalCtrl', agencyData);

    $scope.metas = agencyData.metas;

    $scope.cancel = function () {
        $uibModalInstance.dismiss("cancel");
    };

    $scope.close = function () {

        $uibModalInstance.close();
    };

}]);

housestars.controller('EditPropertyModalCtrl', ['$scope', 'propertyData', '$uibModalInstance', 'http', function ($scope, propertyData, $uibModalInstance, http) {

    console.log('EditPropertyModalCtrl', propertyData);

    $scope.code = propertyData.code;
    $scope.user_id = propertyData.user_id;
    $scope.metas = propertyData.metas;
    $scope.users = [];

    $scope.getAllUsers = function () {
        http.getAllUsers().then(function(response){
            console.log('all users:', response);
            $scope.users = response.data.users;
        })
    };

    $scope.saveProperty = function () {

        var propertyObj = {
            code: $scope.code,
            user_id: $scope.user_id,
            metas: $scope.metas
        };

        http.updateProperty(propertyObj).then(function(response){
            console.log('save property: ', response);
            $scope.close({
                status:'success',
                code: $scope.code
            });
        })
    };


    $scope.cancel = function () {
        $uibModalInstance.dismiss("cancel");
    };

    $scope.close = function (response) {

        var response = response || {};

        $uibModalInstance.close(response);
    };


    // initialize
    $scope.getAllUsers();

}]);

housestars.controller('ReviewsCtrl', ['$scope', 'http', function ($scope, http) {

    console.log('reviewsCtrl');

    $scope.reviews = [];
    $scope._reviews = angular.copy($scope.reviews);

    $scope.getAllReviews = function () {
        http.getAllReviews().then(function(response){
            console.log('reviews: ', response);
            $scope.reviews = response.data.reviews;
            $scope._reviews = angular.copy($scope.reviews);
        });
    };


    // initialize
    $scope.getAllReviews();

}]);