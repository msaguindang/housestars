"use strict";

HouseStarModule.PropertiesModule = (function(){

    var properties = {
        agencyId:0,
        propertyCode:0,
    };

    var $agencyModalBtn = {},
        $agencyModal = {},
        $agencyModalTitle = {},
        $agencyModalPrincipalName = {},
        $agencyModalBusinessAddress = {},
        $agencyModalWebsite = {},
        $agencyModalPhone = {},
        $agencyModalAbn = {},
        $agencyModalPositions = {};

    var $editPropertyModalBtn = {},
        $editPropertyModal = {},
        $propertyTypeInput = {},
        $numberOfRoomsInput = {},
        $postCodeInput = {},
        $suburbInput = {},
        $stateInput = {};
        

    function config(){
        $agencyModalBtn = $('.show-agent-modal');
        $agencyModal = $('#agency-modal');
        $agencyModalTitle = $agencyModal.find('.modal-title');
        $agencyModalPrincipalName = $agencyModal.find('.principal-name-text');
        $agencyModalBusinessAddress = $agencyModal.find('.business-address-text');
        $agencyModalWebsite = $agencyModal.find('.website-text');
        $agencyModalPhone = $agencyModal.find('.phone-text');
        $agencyModalAbn = $agencyModal.find('.abn-text');
        $agencyModalPositions = $agencyModal.find('.positions-text');

        $editPropertyModalBtn = $('.edit-property');
        $editPropertyModal = $('#edit-property-modal');
        $propertyTypeInput = $editPropertyModal.find('select[name=property_type]');
    }

    var agencyModal = function(){

        function click(){
            config();
            $agencyModalBtn.click(function(e){
                e.preventDefault();
                HouseStarModule.PropertiesModule.properties.agencyId = $(this).attr('data-id');
                HouseStarModule.PropertiesModule.agencyModal.open();
            })
        }

        function open(){
            config();

            $agencyModal.modal({
                show:true,
            });

            HouseStarModule.PropertiesModule.agencyModal.loadContents();
        }

        function loadContents(){

            var agencyId = HouseStarModule.PropertiesModule.properties.agencyId;

            $.ajax({
                method: 'GET',
                url: $baseUrl + '/admin/agency',
                data: {
                    id: agencyId
                },
                dataType:'json',
                success:function(response){
                    console.log('agency: ', response);

                    $agencyModalTitle.text(response.metas['agency-name']);
                    $agencyModalPrincipalName.text(response.metas['principal-name']);
                    $agencyModalBusinessAddress.text(response.metas['business-address']);
                    $agencyModalWebsite.text(response.metas['website']);
                    $agencyModalPhone.text(response.metas['phone']);
                    $agencyModalAbn.text(response.metas['abn']);
                    $agencyModalPositions.text(response.metas['positions']);

                },
                error: function(error){
                    console.log('an error has occured');
                    console.log(error.responseText);
                }
            })

        }

        return {
            click: click,
            open: open,
            loadContents: loadContents
        }

    }();

    var editPropertyModal = function(){

        function click(){
            config();
            $editPropertyModalBtn.click(function(e){
                e.preventDefault();
                HouseStarModule.PropertiesModule.properties.propertyCode = $(this).attr('data-id');
                HouseStarModule.PropertiesModule.editPropertyModal.open();
            })
        }

        function open(){
            config();

            $editPropertyModal.modal({
                show:true,
            });

            HouseStarModule.PropertiesModule.editPropertyModal.loadContents();
        }

        function loadContents(){

            var propertyCode = HouseStarModule.PropertiesModule.properties.propertyCode;

            $.ajax({
                method: 'GET',
                url: $baseUrl + '/admin/property',
                data: {
                    code: propertyCode
                },
                dataType:'json',
                success:function(response){
                    console.log('property: ', response);

                    $propertyTypeInput.val(response.metas['property-type'].value);

                },
                error: function(error){
                    console.log('an error has occured');
                    console.log(error.responseText);
                }
            })

        }

        return {
            click: click,
            open: open,
            loadContents: loadContents
        }

    }();

    return {
        agencyModal: agencyModal,
        editPropertyModal: editPropertyModal,

        properties: properties
    }

})();