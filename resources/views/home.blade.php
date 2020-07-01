@extends('layout.default')

@section('title')
    Welcome
@endsection

@section('subtitle')
    The Simple URL Shortener
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <form action="/" id="shorten-url-form">
                <input type="text" class="form-control" placeholder="Enter your URL" id="shorten-url-form-field-url"/>
                <br/>
                <div class="form-group">
                    <label>Expired Date</label>

                    <div class="input-group date">
                        <div class="input-group-addon">
                            <input type="checkbox" id="shorten-url-form-field-expiration-date-checkbox"/>
                        </div>
                        <input type="text"
                               class="form-control pull-right"
                               id="shorten-url-form-field-expiration-date"
                               placeholder="Set expired date" readonly>
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /input-group -->
                <div class="form-group">
                    <label>Password Protection</label>

                    <div class="input-group date">
                        <div class="input-group-addon">
                            <input type="checkbox" id="shorten-url-form-field-password-checkbox"/>
                        </div>
                        <input type="password"
                               class="form-control pull-right"
                               placeholder="Insert password"
                               id="shorten-url-form-field-password">
                    </div>
                    <!-- /.input group -->
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 col-sm-4">
                        <button type="submit" class="btn btn-info btn-flat btn-block">
                            <span>Shorten URL</span>
                        </button>
                    </div>
                    <div class="col-md-10 col-sm-8">
                        <br class="visible-xs"/>
                        <div class="input-group" id="shorten-url-form-field-url-generated-group" style="display: none;">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Generated URL"
                                   id="shorten-url-form-field-url-generated"
                                   readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-flat"
                                        data-clipboard-target="#shorten-url-form-field-url-generated">
                                    <i class="fa fa-clipboard"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script type="application/javascript">
        const clipboard = new ClipboardJS('.btn');

        $('#shorten-url-form-field-expiration-date').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "yyyy-mm-dd"
        });

        $(document).ready(function () {
            clipboard.on('success', function (e) {
                toastr.success("URL Copied");
                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                toastr.failed("Cannot Copy URL");
            });

            $("#shorten-url-form").on("submit", function (e) {
                e.preventDefault();
                const url = $("#shorten-url-form-field-url");

                const expiredDateCheckBox = $('#shorten-url-form-field-expiration-date-checkbox').is(":checked");
                const expiredDate = $('#shorten-url-form-field-expiration-date');

                const passwordCheckBox = $('#shorten-url-form-field-password-checkbox').is(":checked");
                const password = $('#shorten-url-form-field-password');

                $.ajax({
                    type: "POST",
                    url: "/s/g",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: JSON.stringify({
                        "url": url.val(),
                        "expired_date": (expiredDateCheckBox) ? expiredDate.val() : null,
                        "password": (passwordCheckBox) ? password.val() : null,
                    }),
                    contentType: "application/json",
                    dataType: "json",
                    async: true,
                    success: function (result) {
                        toastr.success(result.message);
                        $("#shorten-url-form-field-url-generated").val(result.url);
                        $("#shorten-url-form-field-url-generated-group").fadeIn();
                    },
                    error: function (result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
