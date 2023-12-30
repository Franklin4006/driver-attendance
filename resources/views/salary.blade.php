@extends('layouts.admin-lte3')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Salary</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="card">
                <div class="card-body">
                    <h5 class="text-danger mb-2">This Month</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Workingdays</th>
                                    <th>Salary</th>
                                    <th>Advance</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this_month_data as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['workingdays'] }}</td>
                                        <td>{{ $data['salary'] }}</td>
                                        <td>{{ $data['advance'] }}</td>
                                        <td>{{ $data['balance'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="text-danger mb-2">Last Month</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Workingdays</th>
                                    <th>Salary</th>
                                    <th>Advance</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($last_month_data as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['workingdays'] }}</td>
                                        <td>{{ $data['salary'] }}</td>
                                        <td>{{ $data['advance'] }}</td>
                                        <td>{{ $data['balance'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>
@endsection


@section('addscript')
    <script type="text/javascript">
        $('.data-table').DataTable();
    </script>
@endsection
