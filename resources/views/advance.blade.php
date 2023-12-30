@extends('layouts.admin-lte3')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Advance</h1>
                    </div>
                    @if (auth()->user()->is_admin == 'Yes')
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-btn float-right" data-toggle="modal"
                                data-target="#advance-modal">
                                <i class="bi-plus-circle"></i> Create New
                            </button>
                        </div>
                    @endif
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
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    @if (auth()->user()->is_admin == 'Yes')
                                        <th>Action</th>
                                    @endif
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

    @if (auth()->user()->is_admin == 'Yes')
    <div class="modal fade" id="advance-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="advance-modal-title">
                        Advance
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form id="advance-form">
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
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" required>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ date('Y-m-d') }}" required>
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
    @endif
@endsection


@section('addscript')
    <script type="text/javascript">
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('advance/fetch') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'user.name',
                    name: 'name'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                @if (auth()->user()->is_admin == 'Yes')
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                @endif
            ]
        });
        @if (auth()->user()->is_admin == 'Yes')
        $("#advance-form").validate({
            submitHandler: function(form) {
                var data = new FormData(form);
                var url = "{{ url('advance/create') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function() {
                        $("#advance-modal").modal("hide");
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
                url: "{{ url('advance/fetch-edit') }}/" + edit_id,
                dataType: "json",
                success: function(data) {

                    $("#driver").val(data.user_id);
                    $("#date").val(data.date);
                    $("#amount").val(data.amount);

                    $("#advance-modal").modal("show");
                },
                error: function(code) {
                    alert(code.statusText);
                },
            });
        });

        $(document).on("click", ".add-btn", function() {
            $("#edit_id").val("");
            $("#advance-form")[0].reset();
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
                url: "{{ url('advance/delete') }}/" + edit_id,
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
        @endif
    </script>
@endsection
