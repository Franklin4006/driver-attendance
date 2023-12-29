@extends('layouts.admin-lte3')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attendance</h1>
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
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
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
                        Attendance
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
                            <label>Driver Name</label>
                            <select class="form-control" name="driver" id="driver" required>
                                <option value="">Select Driver</option>
                                @foreach ($drivers as $dr)
                                    <option value="{{ $dr->id }}">{{ $dr->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude">
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Punch In Date</label>
                                    <input type="date" class="form-control" name="date" id="date"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Punch In Time</label>
                                    <input type="time" class="form-control" name="time" id="time"
                                        value="{{ date('H:i:s') }}" required>
                                </div>
                            </div>
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


    <div class="modal fade" id="location-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="driver-modal-title">
                        Location
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <div id="location-div"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('addscript')
    <script type="text/javascript">
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('attendance/fetch') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'user.name',
                    name: 'name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'time',
                    name: 'time'
                },
                {
                    data: 'location',
                    name: 'location',
                    orderable: false,
                    searchable: false
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
                var data = new FormData(form);
                var url = "{{ url('attendance/create') }}";
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

                return false;
            }
        });

        $(document).on("click", ".edit-btn", function() {
            var edit_id = $(this).data('id');
            $("#edit_id").val(edit_id);
            $.ajax({
                url: "{{ url('attendance/fetch-edit') }}/" + edit_id,
                dataType: "json",
                success: function(data) {

                    $("#driver").val(data.driver);
                    $("#latitude").val(data.latitude);
                    $("#longitude").val(data.longitude);
                    $("#date").val(data.date);
                    $("#time").val(data.time);

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
            $("#delete-confirm-text").text("Are you confirm to Delete this Record");
            $("#delete-confirm-modal").modal("show");
        });

        $(document).on("click", "#confirm-yes-btn", function() {
            var edit_id = $("#edit_id").val();

            $.ajax({
                url: "{{ url('attendance/delete') }}/" + edit_id,
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

        function open_location(latitude, longitude) {
            var html_text = `<iframe width="100%" height="500px"
                src="https://maps.google.com/maps?q=${latitude},${longitude}&hl=es&z=14&amp;output=embed">
            </iframe>`;

            $("#location-div").html(html_text);

            $("#location-modal").modal("show");
        }
    </script>
@endsection
