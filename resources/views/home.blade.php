@extends('layouts.admin-lte3')
@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title mt-2">Hi! {{ auth()->user()->name }}</h3>
                        </div>
                        <div class="col-6">
                            @if (!$check_punched)
                                <button class="btn btn-success float-right" id="punch-in-btn">Punch In</button>
                            @else
                                <span style="font-size: 16px;font-weight: 600;margin-top: 5px;"
                                    class="text-success float-right"> <i class="fas fa-user-clock"></i>
                                    {{ date('h:i A', strtotime($check_punched->punch_in_at)) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-danger">This Month ({{ date('F') }})</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label>Workingdays</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>{{ $this_month['workingdays'] }}</label></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label> Salary</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $this_month['salary'] }}</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label> Advance</div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $this_month['advance'] }}</label></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label>Balance</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $this_month['balance'] }}</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="col-sm-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-danger">Last Month ({{ date('F', strtotime('-1 month')) }})</h3>
                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label>Workingdays</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>{{ $last_month['workingdays'] }}</label></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label> Salary</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $last_month['salary'] }}</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label> Advance</div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $last_month['advance'] }}</label></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card p-2" style="border: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-6"><label>Balance</label></div>
                                            <div class="col-2"><label>:</label></div>
                                            <div class="col-4"><label>₹{{ $last_month['balance'] }}</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>



    <div class="modal fade" id="punch-in-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="punch-in-modal-title">
                        Punch In
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form id="punch-in-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Date Time</label>
                            <input type="datetime-local" class="form-control" name="datetime" id="datetime" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location" id="location" readonly required>
                        </div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="punch-in-submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('addscript')
    <script>
        $("#punch-in-form").validate({
            submitHandler: function(form) {
                $("#punch-in-submit").prop("disabled", true);
                var data = new FormData(form);
                var url = "{{ url('attendance/punch-in') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function() {
                        location.reload();
                    },
                    error: function(code) {
                        alert(code.statusText);
                    },
                });

                return false;
            }
        });

        $(document).on("click", "#punch-in-btn", function() {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    $.ajax({
                        type: "GET",
                        url: "{{ url('get-date-time') }}",
                        success: function(response) {
                            $("#datetime").val(response);
                        },
                        error: function(code) {
                            alert(code.statusText);
                        },
                    });

                    var my_latitude = position.coords.latitude;
                    var my_longitude = position.coords.longitude;

                    $("#latitude").val(my_latitude);
                    $("#longitude").val(my_longitude);

                    $("#location").val(my_latitude + " " + my_longitude);

                    $("#punch-in-modal").modal("show");

                });
            } else {
                alert("Can not Punch In");
            }
        });
    </script>
@endsection
