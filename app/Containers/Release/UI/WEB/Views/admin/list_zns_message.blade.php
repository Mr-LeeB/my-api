@extends('release::layout.app_admin_nova')
@section('title')
    {{ __('List Zns Message') }}
@endsection
@php
    $view_load_theme = 'base';
@endphp

{{-- thêm Style --}}
<style>
    .undisplay {
        display: none;
    }

    .boloc:hover {
        cursor: pointer;
        background-color: aliceblue !important;
    }
</style>
@once
    @push('after_header')
        <link href="{{ asset('theme/' . $view_load_theme . '/css/truecloud_volumes_list.css') }}" rel="stylesheet" type="text/css">
    @endpush
@endonce

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Danh sách Zns Messages') }}</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        use Illuminate\Support\Collection;
        $zns = new Collection();
        $success = 0;
        $fail = 0;
        for ($i = 0; $i < 20; $i++) {
            $zns->push(
                (object) [
                    'status' => rand(0, 1),
                    'message' => 'message ' . $i,
                ],
            );

            if ($zns[$i]->status == 1) {
                $success++;
            } else {
                $fail++;
            }
        }
    @endphp
    <div class="col-12">
        <div class="row">
            <div class="col">
                <div class="card card-custom gutter-b card-stretch">
                    {{-- thêm class boloc --}}
                    <div class="card-header boloc border-0 py-5">
                        <h3 class="card-title"><span class="font-weight-bolder">{{ __('Bộ Lọc') }}</span></h3>
                        <div class="card-toolbar">
                            <!-- // -->
                        </div>
                    </div>


                    <div class="card-body boloc-show undisplay">
                        {{-- <div class="card-body d-flex flex-column" style="position: relative;"> --}}
                        <div class="tab-content">
                            {{-- sửa lại form --}}
                            <form class="form gutter-b col" action="">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col col-12">
                                            <div class="form-group">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 my-2 my-md-0">
                                                        <div class="input-group date" id="datetime_picker">
                                                            <input type="text" class="form-control"
                                                                placeholder="Chọn thời gian ..." name="time_range"
                                                                id="time_range" value="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar-check-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="col col-12">
                                            <div class="form-group">
                                                <select class="form-control" name="status">
                                                    <option value="">{{ __('Tất cả') }}</option>
                                                    <!-- <option value="all">All</option> -->
                                                    <option value="success">{{ __('Thành công') }}</option>
                                                    <option value="fail">{{ __('Thất bại') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <button type="submit" id="search_zns" class="btn btn-primary btn-block"
                                        style="width: 180px">{{ __('Lọc danh sách') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="card card-custom card-fit">
            <div class="card-header">
                <h3 class="card-title">{{ __('Danh sách') }} Zns</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Reseller</td>
                            <td>Phone</td>
                            <td class="text-center">Http code</td>
                            <td class="text-center">Trạng thái</td>
                            <td class="text-center">Nội dung</td>
                            <td>Ngày tạo</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($zns->isNotEmpty())
                            @foreach ($zns as $zn)
                                <tr class="bg-hover-secondary list_zns">
                                    <td>
                                        {{-- {{ ucfirst($zn->reseller_namespace) ?? '' }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $zn['api_send_data']['phone'] ?? '' }} --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- {{ $zn->api_http_code ?? '' }} --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- @if (!is_null($zn->msg_send_status) && $zn->msg_send_status == '0') --}}
                                        <span class="label label-success">
                                            {{-- {{ $zn->msg_send_status }} --}}
                                        </span>
                                        {{-- @else
                                            <span
                                                class="label label-danger label-inline">{{ $zn->msg_send_status ?? 'error' }}</span>
                                        @endif --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- @if ('Success' === ($zn->api_result['message'] ?? ''))
                                            success
                                        @else
                                        @endif --}}
                                    </td>
                                    <td>
                                        {{-- {{ $zn->created_at }} --}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class=" bg-hover-secondary text-center">
                                    <b>{{ __('global.no_data') }}</b>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if ($zns->isNotEmpty())
                    <span class="paginate zns">
                        {{-- @include("user::$view_load_layout.components.pagination", ['object' => $zns]) --}}
                    </span>
                @endif
            </div>
        </div>


    </div>


@endsection




@once
    @push('after_script')
        <script>
            //datetime picker
            let timeFormat = 'YYYY-MM-DD HH:mm';
            $('#datetime_picker').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',
                timePicker: true,
                timePickerIncrement: 1,
                // endDate: end,
                locale: {
                    format: timeFormat
                },
                ranges: {
                    '1 Ngày': [moment().subtract(1, 'days'), moment()],
                    '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')]
                },
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month'),
            }, function(start, end, label) {
                $('#datetime_picker .form-control').val(start.format(timeFormat) + ' to ' + end.format(timeFormat));
            });

            if (!$('#time_range').val()) {
                $('#time_range').val(moment().startOf('month').format(timeFormat) + ' to ' + moment().endOf('month').format(
                    timeFormat))
            } else {
                // do nothing
            }

            // thêm script
            $('.boloc').on('click', function() {
                $('.boloc-show').toggleClass('undisplay');
            });
        </script>
    @endpush
@endonce
