@extends('layout.default')

@section('title')
    My URL Shortener
@endsection

@section('subtitle')
    List all of your own URL Shortener
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">
                <input type="text" class="form-control" placeholder="Search"/>
            </h3>

            <div class="box-tools">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Destination</th>
                    <th>Short URL</th>
                    <th>Click</th>
                    <th>Expired Date</th>
                    <th>Protection</th>
                    <th style="width: 40px">Action</th>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>http://www.google.com</td>
                    <td>http://shorturl.test/s/sasd</td>
                    <td>5</td>
                    <td><label class="label label-success">2020-02-20</label></td>
                    <td><label class="label label-danger">No</label></td>
                    <td>
                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>http://www.google.com</td>
                    <td>http://shorturl.test/s/ssdf</td>
                    <td>5</td>
                    <td><label class="label label-danger">2020-02-20</label></td>
                    <td><label class="label label-success">Yes</label></td>
                    <td>
                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>http://www.google.com</td>
                    <td>http://shorturl.test/s/fffs</td>
                    <td>5</td>
                    <td><label class="label label-info">Never</label></td>
                    <td><label class="label label-success">Yes</label></td>
                    <td>
                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script type="application/javascript">
        const clipboard = new ClipboardJS('.btn');

        $(document).ready(function () {
            clipboard.on('success', function (e) {
                toastr.success("URL Copied");
                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                toastr.failed("Cannot Copy URL");
            });
        });
    </script>
@endsection
