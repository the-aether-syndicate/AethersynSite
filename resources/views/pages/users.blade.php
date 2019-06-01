@extends('layouts.grids.4-4-4')
@section('title', 'Doctrine')
@section('content_header')
<h1>TriglavDefense Doctrines</h1>
@stop

@section('left')
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3>Users</h3>
    </div>
    <div class="box-body">
        <table id='userlist' class="table table-hover" style="width: 100%">
            <thead >
            <tr>
                <th></th>
                <th>User</th>

            </tr>
            </thead>
            <tbody style="width: 100%">
            </tbody>
        </table>
    </div>
</div>

@stop
@section('center')
    <div class="box box-primary box-solid" id="rolesBox">
        <div class="box-header">
            <h3 class="box-title" id='middle-header'>
            </h3>
        </div>
        <input type="hidden" width="100" id="userId" value="">
        <input type="hidden" width="100" id="username" value="">
        <div class="box-body">

            <label for="roleSpinner">Roles</label><select id="roleSpinner" >
                    <option value="0">Choose Role....</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            <button type="button" id="giveRole" class="btn btn-sm pull-right btn-success " data-toggle='tooltip' data-placement='top' title='Add Role' >Add Role</button>

            <div id="role-window">
                <div class="box-body">
                    <table id='rolelist' class="table" style="vertical-align: top">
                        <thead>
                        <tr>

                            <th>Role</th>
                            <th>Description</th>
                            <th class="pull-right">Option</th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('right')
@endsection
@push('js')
    <script type="text/javascript">
        let userlist =$('#userlist');
        let userlistbody = $('#userlist tbody');
        let rolebox = $('#rolesBox');
        let rolelist = $('#rolelist');
        let roleSpinner = $('#roleSpinner');
        let addRole = $('#addRole');
        var user;
        var rolesel;
        var usertable = [];

        rolebox.hide();


        $(document).ready(function () {
            usertable = userlist.DataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: '/users/get/data',
                    columns: [
                        {data: 'id', render:
                        function(datafield)
                        {
                            return '<img src=\'https://imageserver.eveonline.com/Character/' + datafield + '_32.jpg\' height=\'24\' />';
                        }},
                        {data: 'name'},

                    ]
                }
            );
            userlistbody.on('click', 'tr', function () {
                rolebox.show();
                user = usertable.row(this).data();
                $('#middle-header').text(user.name);
                //Gets a user's role list
                $.ajax({
                    headers: function () {
                    },
                    url: "/roles/user/get/"+user.id,
                    type: "GET",
                    dataType: 'json',
                    timeout: 10000
                }).done( function (result) {
                    if (result) {
                        fillRoleTable(result);
                    }

                });
                rolelist.on('click', '#takeRole', function () {
                    rolesel = $(this).data('id');
                    $.ajax({
                        headers: function () {
                        },
                        url: "/role/take/"+$('#middle-header').text()+"/"+rolesel,
                        type: "GET",
                        dataType: 'json',
                        timeout: 10000

                    }).done( function (result) {
                        if (result) {
                            fillRoleTable(result);
                        }
                    });

                });
            });
            $('#giveRole').click( function () {
                $.ajax({
                    headers: function () {
                    },
                    url: "/role/give/"+$('#middle-header').text()+"/"+roleSpinner.val(),
                    type: "GET",
                    dataType: 'json',
                    timeout: 10000

                }).done( function (result) {
                        if (result) {
                            fillRoleTable(result);
                        }
                });

            });

        });
        function fillRoleTable(result) {
            rolelist.find("tbody").empty();
            for (let role in result) {
                let row = "<tr id='roleid' data-id='"+result[role].name+"'><td>" + result[role].name + "</td>";
                row = row + "<td>" + result[role].description + "</td>";
                row = row + "<td><button type='button' id='takeRole' class='btn btn-xs btn-danger pull-right' data-id='" + result[role].name + "' data-toggle='tooltip' data-placement='top' title='Remove Role'>";
                row = row + "<span class='fa fa-unlink text-white'></span></button></td></tr>";
                rolelist.find("tbody").append(row);
            }
        }
    </script>
@endpush