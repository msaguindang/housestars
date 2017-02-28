@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">Property Listing</h4>
                <div class="card">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>ID</th>
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
                            <tr>
                                <td>1</td>
                                <td>Dakota Rice</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$36,738</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Minerva Hooper</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$23,789</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Sage Rodriguez</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$56,142</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Philip Chaney</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$38,735</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Doris Greene</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$63,542</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Mason Porter</td>
                                <td>Condominium</td>
                                <td>5</td>
                                <td>Abbeywood, Queensland</td>
                                <td>Yes</td>
                                <td>$78,615</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal">Niger Agency</a></td>
                                <td><i class="pe-7s-note"></i>  <i class="pe-7s-trash"></i></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection