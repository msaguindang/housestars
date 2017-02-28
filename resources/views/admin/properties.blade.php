@extends('layouts.admin')

@section('css')
    <style>
        /* temporary styles */
        .form-item{
            margin-bottom:10px;
        }

        .form-item label {
            margin-top: 10px;
        }

        .form-item .radio-inline{
            margin-top:10px;
        }

        input.number-input{
            width:50%;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4 class="title">Property Listing</h4>
            <div class="card">
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                        {{--<th>ID</th>--}}
                        <th>Vendor Name</th>
                        <th>Type</th>
                        <th>No. of Rooms</th>
                        <th>Location</th>
                        <th>Currently Leased?</th>
                        <th>Property Value</th>
                        <th>Agent</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($properties as $property)

                            <tr>
                                {{--<td>{{ $property['id'] }}</td>--}}
                                <td>{{ isset($property['vendor-name'])?$property['vendor-name']:'' }}</td>
                                <td>{{ isset($property['property-type'])?$property['property-type']:'' }}</td>
                                <td>{{ isset($property['number-rooms'])?$property['number-rooms']:'' }}</td>
                                <td>{{ isset($property['suburb'])?$property['suburb'].',':'' }} {{ isset($property['state'])?$property['state']:'' }} {{ isset($property['post-code'])?$property['post-code']:'' }}</td>
                                <td>{{ isset($property['leased'])?$property['leased']:'' }}</td>
                                <td>{{ isset($property['value-to'])?'$'.$property['value-to']:'' }}</td>
                                <td><a class="show-agent-modal" href="#"
                                       data-id="{{ isset($property['agent'])?$property['agent']:'' }}">{{ isset($property['agent-name'])?$property['agent-name']:'' }}</a>
                                </td>
                                <td>
                                    <a href="#" class="edit-property"
                                       data-id="{{ isset($property['property-code'])?$property['property-code']:'' }}"><i
                                                class="pe-7s-note"></i></a>
                                    <a href="#" class="delete-property"
                                       data-id="{{ isset($property['property-code'])?$property['property-code']:'' }}"><i
                                                class="pe-7s-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


    </div>

@endsection

@section('modals')

    <!-- AGENCY MODAL -->
    <div class="modal fade" id="agency-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Principal Name</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="principal-name-text"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Business Address</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="business-address-text"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Website</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="website-text"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Phone</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="phone-text"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>ABN</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="abn-text"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Positions</label>
                        </div>
                        <div class="col-xs-8">
                            <p class="positions-text"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PROPERTY MODAL -->
    <div class="modal fade" id="edit-property-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Property</h4>
                </div>
                <div class="modal-body">

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Vendor Name</label>
                        </div>
                        <div class="col-xs-8">
                            <select name="property_type" class="form-control">
                                <option value="">Select Vendor Name</option>

                            </select>
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Property Type</label>
                        </div>
                        <div class="col-xs-8">
                            <select name="property_type" class="form-control">
                                <option value="">Select Property Type</option>
                                <option value="Condominium">Condominium</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Number of Rooms</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="number_of_rooms" type="text" class="form-control number-input">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Post Code</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="post_code" type="text" class="form-control number-input">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Suburb</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="suburb" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>State</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="state" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Leased</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" value="Yes" name="leased">Yes</label>
                            <label class="radio-inline"><input type="radio" value="No" name="leased">No</label>
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Value From</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="value_from" type="text" class="form-control number-input">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Value To</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="value_to" type="text" class="form-control number-input">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>More Details</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="more_details" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-item">
                        <div class="col-xs-4">
                            <label>Agent</label>
                        </div>
                        <div class="col-xs-8">
                            <select class="form-control" name="agent">
                                <option value="">Select Agent</option>
                                <option value="">Agent 1</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{ asset('js/modules/properties-module.js') }}"></script>
    <script type="text/javascript">
        HouseStarModule.PropertiesModule.agencyModal.click();
        HouseStarModule.PropertiesModule.editPropertyModal.click();
    </script>

@endsection