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

    $scope.extendSubscriptionUser = function (user, index) {

        if(user.sub_end == ""){
            return false;
        }

        http.extendUserSubscription(user).then(function(response){
            console.log('extend user subscription: ', response);

            if(response.data.new_end_subscription != ""){
                $scope._users[index].sub_end = response.data.new_end_subscription;
            }

        });

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

housestars.controller('CategoriesCtrl', ['$scope', 'http', function ($scope, http) {

    console.log('categoriesCtrl');

    $scope.categories = [];
    $scope._categories = angular.copy($scope.categories);

    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.limit = 10;

    $scope.changePage = function(newPage){
        console.log('new page: ', newPage);
        $scope.currentPage = newPage;
        $scope.getAllCategories();
    };

    $scope.getAllCategories = function () {
        http.getAllCategories({
            page_no:$scope.currentPage,
            limit:$scope.limit
        }).then(function(response){
            console.log('all categories: ', response);
            $scope.categories = response.data.categories;
            $scope._categories = angular.copy($scope.categories);
            $scope.totalItems = response.data.length;
        });
    };

    $scope.editCategory = function () {

    };

    $scope.deleteCategory = function () {

    };


    // initialize
    $scope.getAllCategories();

}]);

housestars.controller('SuburbsCtrl', ['$scope', 'http', '$uibModal', function ($scope, http, $uibModal) {

    console.log('suburbsCtrl');

    $scope.suburbs = [];
    $scope._suburbs = angular.copy($scope.suburbs);

    $scope.currentSuburb = "";

    $scope.suburbsLength = 0;
    $scope.currentPage = 1;
    $scope.limit = 10;

    $scope.changePage = function(newPage){
        console.log('new page: ', newPage);
        $scope.currentPage = newPage;
        $scope.getAllSuburbs();
    };

    $scope.getAllSuburbs = function () {
        http.getAllSuburbs({
            page_no:$scope.currentPage,
            limit:$scope.limit
        }).then(function(response){
            console.log('all suburbs: ', response);
            $scope.suburbs = response.data.suburbs;
            $scope._suburbs = angular.copy($scope.suburbs);
            $scope.suburbsLength = response.data.length;
        });
    };

    $scope.editSuburb = function () {

    };

    $scope.deleteSuburb = function () {

    };

    $scope.showAvailabilities = function (currentSuburb) {
        $scope.currentSuburb = currentSuburb;
        $scope.openAvailabilityModal();
    };

    $scope.openAvailabilityModal = function () {

        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'suburb-availability-modal.html',
            controller: 'SuburbAvailabilityCtrl',
            // size: 'lg',
            resolve: {
                currentSuburb: function () {
                    return $scope.currentSuburb;
                },
            }
        });

        modalInstance.result.then(function (selectedItem) {
            console.log('Success Modal dismissed at: ' + new Date());
        }, function () {
            console.log('Modal dismissed at: ' + new Date());

        });

    };


    // initialize
    $scope.getAllSuburbs();

}]);

housestars.controller('SuburbAvailabilityCtrl', ['$scope', 'currentSuburb', '$uibModalInstance', 'http', function ($scope, currentSuburb, $uibModalInstance, http) {

    console.log('SuburbAvailabilityCtrl', currentSuburb);

    $scope.currentSuburb = currentSuburb;
    $scope.agents = [];

    $scope.getSuburbAgents = function () {


        http.getSuburbAgents($scope.currentSuburb).then(function(response){
            console.log('all availabilities of - '+$scope.currentSuburb, response);
            $scope.user_metas = response.data.user_metas;
        });

    };

    $scope.getAllAgents = function () {
        http.getAllUsers({
            slug:'agent'
        }).then(function(response){
            console.log('all agents: ', response);
            $scope.agents = response.data.users;
        })
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss("cancel");
    };

    $scope.close = function (response) {

        var response = response || {};

        $uibModalInstance.close(response);
    };



    $scope.removeAgent = function () {

    };

    $scope.addAgent = function () {

    };

    $scope.selectAgent = function () {

    };


    // initialize
    $scope.getAllAgents();
    $scope.getSuburbAgents();

}]);