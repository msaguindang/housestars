'use strict';

var housestars = angular.module('houseStarServices', []);

housestars.factory('http', ['$http', '$q', '$rootScope' , function($http, $q, $rootScope) {
    return {
        _token: $_token,
        post: function (url, data, processData, contentType) {

            var data = data || {};

            if (processData == undefined) {
                processData = true;
            }

            if (contentType == undefined) {
                contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
            }

            var self = this;
            //cfpLoadingBar.start();
            return $q(function (resolve, reject) {
                data._token = self._token;

                console.log(data._token);
                console.log($_token);

                jQuery.ajax({
                    cache: false,
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: data,
                    processData: processData,
                    contentType: contentType,
                    headers: {
                        'X-CSRF-TOKEN': self._token
                    },
                    success: function (data) {

                        /*if (data.type !== undefined && data.msg !== undefined) {
                            var oldMsg = self.alert.msg;
                            self.alert.type = data.type;
                            self.alert.msg = data.msg;
                            //if(oldMsg != self.alert.msg){
                            global.alert.listUpdate(self.alert);
                            //}
                        }*/

                        /*$rootScope.$broadcast('event', {
                            test:'hello'
                        });*/

                        //self._token = data._token;
                        //delete data['_token'];
                        resolve({
                            data: data,
                            status: 200,
                            statusText: "OK"
                        });
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    },
                    error: function (data) {

                        //try{
                        var data = JSON.parse(data.responseText);

                        /*if (data.errors.type !== undefined && data.errors.msg !== undefined) {
                            self.alert.type = data.errors.type;
                            self.alert.msg = data.errors.msg;
                            global.alert.listUpdate(self.alert);
                        }*/
                        //}catch(e){
                        //	console.log('error object: ', data);
                        //	console.log('service error: ', "response text is not a valid JSON");
                        //}


                        //self._token = data._token;
                        //delete data['_token'];
                        reject(data);
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    }
                });
            });
        },
        postUpload: function (url, data) {

            var data = data || {};

            var self = this;
            //cfpLoadingBar.start();
            return $q(function (resolve, reject) {
                data._token = self._token;

                console.log(data._token);
                console.log($_token);

                jQuery.ajax({
                    cache: false,
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    async:false,
                    headers: {
                        'X-CSRF-TOKEN': self._token
                    },
                    success: function (data) {

                        /*if (data.type !== undefined && data.msg !== undefined) {
                            var oldMsg = self.alert.msg;
                            self.alert.type = data.type;
                            self.alert.msg = data.msg;
                            //if(oldMsg != self.alert.msg){
                            global.alert.listUpdate(self.alert);
                            //}
                        }*/

                        //self._token = data._token;
                        //delete data['_token'];
                        resolve({
                            data: data,
                            status: 200,
                            statusText: "OK"
                        });
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    },
                    error: function (data) {

                        //try{
                        var data = JSON.parse(data.responseText);

                        /*if (data.errors.type !== undefined && data.errors.msg !== undefined) {
                            self.alert.type = data.errors.type;
                            self.alert.msg = data.errors.msg;
                            global.alert.listUpdate(self.alert);
                        }*/
                        //}catch(e){
                        //	console.log('error object: ', data);
                        //	console.log('service error: ', "response text is not a valid JSON");
                        //}


                        //self._token = data._token;
                        //delete data['_token'];
                        reject(data);
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    }
                });
            });
        },
        get: function (url, data, processData, contentType) {

            var data = data || {};

            if (processData == undefined) {
                processData = true;
            }

            if (contentType == undefined) {
                contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
            }

            var self = this;
            //cfpLoadingBar.start();
            $('#loading').show();
            return $q(function (resolve, reject) {
                data._token = self._token;
                jQuery.ajax({
                    cache: false,
                    type: 'GET',
                    dataType: 'json',
                    url: url,
                    data: data,
                    processData: processData,
                    contentType: contentType,
                    headers: {
                        'X-CSRF-TOKEN': self._token
                    },
                    success: function (data) {

                        /*if (data.type !== undefined && data.msg !== undefined) {
                         var oldMsg = self.alert.msg;
                         self.alert.type = data.type;
                         self.alert.msg = data.msg;
                         //if(oldMsg != self.alert.msg){
                         global.alert.listUpdate(self.alert);
                         //}
                         }*/

                        /*self._token = data._token;
                        delete data['_token'];*/
                        resolve({
                            data: data,
                            status: 200,
                            statusText: "OK"
                        });
                        $('#loading').fadeOut('slow');
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    },
                    error: function (data) {

                        //try{
                        var data = JSON.parse(data.responseText);

                        /*if (data.errors.type !== undefined && data.errors.msg !== undefined) {
                         self.alert.type = data.errors.type;
                         self.alert.msg = data.errors.msg;
                         global.alert.listUpdate(self.alert);
                         }*/
                        //}catch(e){
                        //	console.log('error object: ', data);
                        //	console.log('service error: ', "response text is not a valid JSON");
                        //}


                        /*self._token = data._token;
                        delete data['_token'];*/
                        reject(data);
                        $('#loading').fadeOut('slow');
                        //cfpLoadingBar.complete();
                        //$anchorScroll();
                    }
                });
            });
        },

        getAllProperties: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/property', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllUsers: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/user', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllReviews: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/review', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllCategories: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/category', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllSuburbs: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/suburb', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllAdvertisements: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/advertisement', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllReviewees: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/review/reviewees', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllRoles: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/user/role', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAllPotentialCustomers: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/potential-customer', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        saveAdvertisement: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.postUpload('admin/advertisement/insert', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        saveCategory: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/category/insert', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        createMember: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/user/insert', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        updateProperty: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/property/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        updateCategory: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/category/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        updateMember: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/user/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        updateAdvertisement: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.postUpload('admin/advertisement/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        updatePropertyProcessStatus: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/property/property-process/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        updateSuburbAvailability: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/suburb/availability/update', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        getAgency: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/agency/get', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getProperty: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/property/get', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getAdvertisement: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/advertisement/get', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        deleteProperty: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/property/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deleteUser: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/user/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deleteSuburb: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/suburb/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deleteCategory: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/category/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deleteReview: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/review/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deleteAdvertisement: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/advertisement/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        deletePotentialCustomer: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/potential-customer/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        toggleStatus: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/status/toggle', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        getSuburbAgents: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/suburb/agent', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },
        getReviewsByFilter: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/review/filter', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        extendUserSubscription: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/user/subscription/extend', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        removeSuburbAgent: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.post('admin/suburb/agent/delete', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

        exportPotentialCustomers: function (data) {
            var self = this;
            return $q(function(resolve, reject) {
                self.get('admin/potential-customer/export', data).then(function(response) {

                    resolve({
                        data:response.data,
                        status:200,
                        statusText:"OK"
                    });
                }, function (data) {
                    reject(data);
                });
            });
        },

    }
}]);

housestars.factory('validator', [function () {
    return {
        errors: {},
        hasError: function (key, classError) {
            return (this.errors[key] === undefined) ? '' : classError;
        },
        showErrorBlock: function (key, classError) {
            return (this.errors[key] === undefined) ? classError : '';
        }
    };
}]);