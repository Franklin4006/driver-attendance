<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>.</strong> All
    rights reserved.
</footer>


<div class="modal fade" id="delete-confirm-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h4 class="padding-top-30 mb-30 weight-500" id="delete-confirm-text">
                    Are you sure you want to continue?
                </h4>
                <div class="padding-bottom-30 text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> NO
                    </button>
                    <button type="button" id="confirm-yes-btn" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-check"></i> YES
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('template/AdminLTE3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/AdminLTE3/dist/js/adminlte.min.js') }}"></script>

{{-- jquery-validate --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset('template/AdminLTE3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/AdminLTE3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/AdminLTE3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/AdminLTE3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

</body>

</html>
