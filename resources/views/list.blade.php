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
        <h3 class="box-title"></h3>

        <div class="box-tools"></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="overflow-x: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:10px;text-align: center;">No</th>
                    <th>Destination</th>
                    <th>Short URL</th>
                    <th style="text-align:center;">Click</th>
                    <th>Expired Date</th>
                    <th>Protection</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-url-address-body">
                <tr>
                    <td colspan="6" style="text-align:center;color:#777;">
                        <i class="fa fa-spinner fa-spin"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        Page <span id="current-page">1</span>,
        Showing <span id="range-start-data">0</span> to <span id="range-end-data">0</span>
        of <span id="total-entries">0</span> entries
        <ul class="pagination pagination-sm no-margin pull-right" id="pagination-button"></ul>
    </div>
</div>
<!-- /.box -->
@endsection

@section('js')
<script type="application/javascript">
    const clipboard = new ClipboardJS('.btn');

        let page = 1;
        let canPageNext = false;
        let canPagePrevious = false;
        let perPage = 15;

        $(document).ready(function () {
            clipboard.on('success', function (e) {
                toastr.success("URL Copied");
                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                toastr.failed("Cannot Copy URL");
            });

            const loadURLAddress = function () {
                $.ajax({
                    type: "GET",
                    url: "/web/url/address/list?page=" + page,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    contentType: "application/json",
                    async: true,
                    beforeSend: function () {
                        $("#table-url-address-body").html("<tr>\n" +
                            "                            <td colspan=\"7\" style=\"text-align:center;color:#777;\">\n" +
                            "                                <i class=\"fa fa-spinner fa-spin\"></i>\n" +
                            "                            </td>\n" +
                            "                        </tr>");
                    },
                    success: function (result) {
                        rebuildPagination(result);
                        if (result.data.length !== 0) {
                            $("#table-url-address-body").html(result.data.map((m, i) => urlAddressRowComponent(m, i)));
                        } else {
                            $("#table-url-address-body").html("<tr>\n" +
                                "                            <td colspan=\"7\" style=\"text-align:center;color:#777;\">\n" +
                                "                                <span>You don't have any shorten url address</span>\n" +
                                "                            </td>\n" +
                                "                        </tr>");
                        }
                    },
                    error: function (result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            }

            const deleteURLAddress = function (id) {
                $.ajax({
                    type: "DELETE",
                    url: "/web/url/address/delete/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    contentType: "application/json",
                    async: true,
                    success: function (result) {
                        toastr.success(result.message);
                        loadURLAddress();
                    },
                    error: function (result) {
                        toastr.error(result.responseJSON.message);
                    }
                });
            }

            const urlAddressRowComponent = function (urlAddressData, i) {
                let expiredStatus = "<label class=\"label label-info\">Never</label>";
                if (urlAddressData.date_expired != null && urlAddressData.date_expired !== "") {
                    expiredStatus = "<label class=\"label " + (urlAddressData.is_expired ? "label-danger" : "label-success") + "\">2020-02-20</label>";
                }
                const protectionStatus = "<label class=\"label " + (urlAddressData.password != null ? "label-success" : "label-danger") + "\">" + (urlAddressData.password != null ? "Yes" : "No") + "</label>";
                const destination = urlAddressData.full_url_destination;
                const generatedURL = "{{$url}}/s/" + urlAddressData.path_generated;
                const row = "<tr>\n" +
                    "                    <td style=\"text-align:center;\">" + ((page !== 1 ? (page - 1) * perPage : 0) + (i + 1)) + "</td>\n" +
                    "                    <td><a href=\"" + destination + "\" target=\"_blank\">" + destination + "</a></td>\n" +
                    "                    <td><a href=\"" + generatedURL + "\" target=\"_blank\">" + generatedURL + "</a></td>\n" +
                    "                    <td align=\"center\">" + urlAddressData.click + "</td>\n" +
                    "                    <td>" + expiredStatus + "</td>\n" +
                    "                    <td>" + protectionStatus + "</td>\n" +
                    "                    <td>\n" +
                    "                        <button class=\"btn btn-danger btn-xs url-address-delete\"><i class=\"fa fa-trash\"></i></button>\n" +
                    "                    </td>\n" +
                    "                </tr>";
                return $(row).on('click', 'button.url-address-delete', function () {
                    deleteURLAddress(urlAddressData.id);
                });
            }

            const rebuildPagination = function (paginationData) {
                const totalData = paginationData.data.length;
                if (totalData === 0 && page !== 1) {
                    page -= 1;
                    loadURLAddress();
                }

                $("#range-start-data").html(paginationData.from != null ? paginationData.from : 0);
                $("#range-end-data").html(paginationData.to != null ? paginationData.to : 0);
                $("#total-entries").html(paginationData.total);

                const canPageNext = (paginationData.next_page_url != null && paginationData.next_page_url !== "");
                const canPagePrevious = paginationData.prev_page_url != null && paginationData.prev_page_url !== ""

                let buttonElements = [];
                if (canPagePrevious) {
                    buttonElements.push($("<li><a href='#' id='pagination-button-prev'>&laquo;</a></li>").click(function () {
                        page -= 1;
                        loadURLAddress();
                    }));
                }
                if (totalData !== 0) {
                    for (let i = 1; i <= paginationData.last_page; i++) {
                        buttonElements.push($("<li><a href='#'>" + i + "</a></li>").click(function () {
                            page = i;
                            loadURLAddress();
                        }));
                    }
                }
                if (canPageNext) {
                    buttonElements.push($("<li><a href='#' id='pagination-button-next'>&raquo;</a></li>").click(function () {
                        page += 1;
                        loadURLAddress();
                    }));
                }
                $("#pagination-button").html(buttonElements);
            }

            // Initialize
            loadURLAddress();
        });
</script>
@endsection
