@extends('layouts.admin-lte3')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Drivers List</h1>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary add-btn float-right" data-toggle="modal" data-target="#driver-modal">
                            <i class="bi-plus-circle"></i> Create New
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>


    <div class="modal fade" id="driver-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="driver-modal-title">
                        Create Driver
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form id="driver-form">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="number" class="form-control" name="mobile" id="mobile" maxlength="10"
                                minlength="10" required>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="salary" id="salary" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">Per Day</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <div class="input-group-append">
                                    <button type="button" id="password-generate-btn"
                                        class="input-group-text">Generate</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('addscript')
    <script type="text/javascript">
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('drivers/fetch') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $("#driver-form").validate({
            submitHandler: function(form) {
                if ($("#password").val() == $("#confirm_password").val()) {

                    var data = new FormData(form);
                    var url = "{{ url('drivers/store') }}";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function() {
                            $("#driver-modal").modal("hide");
                            table.clear().draw();
                        },
                        error: function(code) {
                            alert(code.statusText);
                        },
                    });
                } else {
                    alert("Password and Confirm Password must be same");
                }
                return false;
            }
        });

        $(document).on("click", ".edit-btn", function() {
            var edit_id = $(this).data('id');
            $("#edit_id").val(edit_id);
            $.ajax({
                url: "{{ url('drivers/fetch-edit') }}/" + edit_id,
                dataType: "json",
                success: function(response) {
                    var driver = response.driver;

                    $("#name").val(driver.name);
                    $("#mobile").val(driver.mobile);
                    $("#email").val(driver.email);
                    $("#salary").val(driver.salary);

                    $("#password").prop("required", false);
                    $("#confirm_password").prop("required", false);

                    $("#driver-modal").modal("show");
                },
                error: function(code) {
                    alert(code.statusText);
                },
            });
        });
        $(document).on("click", "#password-generate-btn", function() {
            var length = 12;
            let result = '';
            const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }

            $("#password").prop("type", "text");

            $("#password").val(result);
            $("#confirm_password").val(result);
        });


        $(document).on("click", ".add-btn", function() {
            $("#edit_id").val("");
            $("#password").prop("required", true);
            $("#confirm_password").prop("required", true);
            $("#driver-form")[0].reset();
        });
        $(document).on("click", ".delete-btn", function() {
            var edit_id = $(this).data('id');
            $("#edit_id").val(edit_id);
            $("#delete-confirm-text").text("Are you confirm to Delete this User");
            $("#delete-confirm-modal").modal("show");
        });

        $(document).on("click", "#confirm-yes-btn", function() {
            var edit_id = $("#edit_id").val();

            $.ajax({
                url: "{{ url('drivers/delete') }}/" + edit_id,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    table.clear().draw();
                },
                error: function(code) {
                    alert(code.statusText);
                },
            });
        });
    </script>
@endsection
