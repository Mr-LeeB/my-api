@extends('releasevuejs::layout.app_admin_nova')

@section('title')
    {{ __('Release') }}
@endsection

@php
    $view_load_theme = 'base';
@endphp

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Show Releases') }}</h2>
            </div>
        </div>
    </div>
@endsection

@once
    @push('after_header')
        <link href="{{ asset('theme/' . $view_load_theme . '/css/admin_show_release_css.css') }}" rel="stylesheet" type="text/css">
    @endpush
@endonce

<style>
    .undisplay {
        display: none;
    }

    .boloc:hover {
        cursor: pointer;
        background-color: aliceblue !important;
    }
</style>

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Danh sách Release') }}</h2>
            </div>
        </div>
    </div>
@endsection

{{-- @section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#search-by-name').keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const limit = params.get('limit');
            let orderBy = params.get('orderBy');
            let sortedBy = params.get('sortedBy');

            if (orderBy != null && sortedBy != null) {
                $('.icon-' + orderBy).css('display', 'inline-block');
                $('.icon-' + orderBy).css('color', '#a9cef3');
                $('.icon-' + orderBy + '.icon-' + sortedBy).css('color', '#3699FF');
                $('.field-' + orderBy).css('color', '#3699FF');
            }

            if (limit != null) {
                $('.form-limit').val(limit);
            }
        });

        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);

        let orderBy = params.get('orderBy');
        let sortedBy = params.get('sortedBy');
        let limit = params.get('limit');
        let page = params.get('page');

        let search = params.get('search')
        // if (search) {
        //     search = url.search.substring(url.search.indexOf('search=') + 7, url.search.length);
        //     // console.log(search);

        //     search = search.replace(/%3A/, ':');
        //     search = search.replace(/%3A/, ':');
        //     search = search.replace(/%3A/, ':');
        //     search = search.replace(/%3A/, ':');
        //     search = search.replace(/%26/, '&');
        // }
        // console.log(search);
        let searchFields = params.get('searchFields');

        $('.form-limit').on('change', function() {
            var changeLimit = $(this).val();

            var form = $("<form action='{{ route('web_releasevuejs_get_all_release') }}' method='GET'></form>");

            form.append("<input type='hidden' name='limit' value='" + changeLimit + "'>");

            if (orderBy != null && sortedBy != null) {
                form.append("<input type='hidden' name='orderBy' value='" + orderBy + "'>");
                form.append("<input type='hidden' name='sortedBy' value='" + sortedBy + "'>");
            }

            if (search != null) {
                form.append("<input type='hidden' name='search' value='" + search + "'>");
            }

            if (searchFields != null) {
                form.append("<input type='hidden' name='searchFields' value='" + searchFields + "'>");
            }

            $(document.body).append(form);
            form.submit();
        });

        $('.btn-search-release').on('click', function() {
            var url = "http://" + window.location.host + '/releasesvuejs?search=';
        });

        function activeBody(id) {
            $('#body' + id).toggleClass('hidden');
        }

        $('.input-group-text').on('click', function() {
            $('.show-searchable').toggleClass('hidden');
        });

        $('.set-searchable').on('click', function() {
            $('.searchable').html($(this).html());
        });

         function searchRelease() {
             var search = $('#search-by-name').val();
             var url = '';
             if ($('#field-name').is(':checked')) {
                 url = "{{ route('web_release_search') }}";
                 $('#search-by-name').attr('type', 'text');
                 $('#search-by-name').attr('name', 'name');
                 $('#search-by-name').attr('placeholder', 'Search by Name');

             } else if ($('#field-id').is(':checked')) {
                 url = "{{ route('web_release_search_by_id') }}";
                 $('#search-by-name').attr('name', 'id');
                 $('#search-by-name').attr('type', 'number');
                 $('#search-by-name').attr('placeholder', 'Search by Id');

             } else if ($('#field-date').is(':checked')) {
                 url = "{{ route('web_release_search_by_date') }}";
                 $('#search-by-name').attr('name', 'date_created');
                 $('#search-by-name').attr('type', 'date');
             }

             if (search.trim() == '') {
                 $('#result').html('');
                 return;
             }

             $.ajax({
                 url: url,
                 type: "POST",
                 data: $('#form-search-release').serialize(),
                 success: function(data) {
                     $('#result').html(
                         `<p>Result: ${data.length} release(s)</p>
                     <div class="release-note-list">
                       ${data.map((release) => {
                           release.detail_description = release.detail_description.length > 62 ? release.detail_description.substring(0, 62).concat('...'):release.detail_description;
                           return`<div class="release-note-item">
                         <div class="release-note-item-header" @click="activeBody(${release.id})">
                           <div class="release-note-item-header-title">
                             ${release.name}
                           </div>
                           <div class="release-note-item-header-date">
                             ${release.created_at.substring(0, 10)}
                           </div>
                         </div>
                         <div class="release-note-item-body hidden" id="body${release.id}">
                           <div class="release-note-item-body-title ">
                             Title: ${release.title_description}
                           </div>
                           <div class="release-note-item-body-description">
                             Description: ${release.detail_description}
                           </div>
                           <div class="more-detail">
                             <a href="/releases/${release.id}">More detail</a>
                           </div>
                         </div>
                       </div>`}).join('')}
                     </div>`
                     );
                 },
                 error: function(data) {
                     $('#result').html(
                         '<p>Result: 0 release(s)</p>'
                     )
                 }
             });
         }

        function confirmDeleteMoreRelease(releaseIDs) {
            for (var i = 0; i < releaseIDs.length; i++) {
                if (!document.getElementById('select_release' + releaseIDs[i]).checked) {
                    document.getElementById('selectedManyReleaseToDel' + releaseIDs[i].toString()).removeAttribute("name");
                }
            }
            if (confirm("Are you sure you want to delete this release?")) {
                document.querySelector('#form-delete-more-release').submit();
            }
        }

        function checkOne(releaseID_json) {
            var checkAll = document.getElementById('checkAll');
            var count = 0;
            for (var i = 0; i < releaseID_json.length; i++) {
                if (document.getElementById('select_release' + releaseID_json[i]).checked == true) {
                    count++;
                }
            }
            if (count == releaseID_json.length) {
                checkAll.checked = true;
            } else {
                checkAll.checked = false;
            }

            if (count > 0) {
                document.getElementsByClassName('delete-more-release')[0].style.display = "block";
            } else {
                document.getElementsByClassName('delete-more-release')[0].style.display = "none";
            }
        }

        function checkAll(releaseID_json) {
            var checkAll = document.getElementById('checkAll');
            var select_release = document.getElementById('select_release');
            if (checkAll.checked == true) {
                for (var i = 0; i < releaseID_json.length; i++) {
                    document.getElementById('select_release' + releaseID_json[i]).checked = true;
                    document.getElementsByClassName('delete-more-release')[0].style.display = "block";

                }
            } else {
                for (var i = 0; i < releaseID_json.length; i++) {
                    document.getElementById('select_release' + releaseID_json[i]).checked = false;
                    document.getElementsByClassName('delete-more-release')[0].style.display = "none";
                }
            }
        }

        function deleteRelease(id) {
            if (confirm("Are you sure you want to delete this release?")) {
                $('#form-delete-release-id-' + id).submit();
            }
        }

        function sortRelease(newOrderBy) {
            var form = $("<form action='{{ route('web_releasevuejs_get_all_release') }}' method='GET'></form>");

            //if orderBy is null or not equal newOrderBy => set sortedBy = asc
            if (orderBy == null || orderBy != newOrderBy) {
                orderBy = newOrderBy;
                sortedBy = 'asc';
            } else {
                //if orderBy is equal newOrderBy => change sortedBy
                if (sortedBy == null) {
                    sortedBy = 'asc';
                } else {
                    sortedBy = sortedBy == 'asc' ? 'desc' : 'asc';
                }
            }

            if (limit != null) {
                form.append("<input type='hidden' name='limit' value='" + limit + "'>");
            }

            form.append("<input type='hidden' name='orderBy' value='" + orderBy + "'>");
            form.append("<input type='hidden' name='sortedBy' value='" + sortedBy + "'>");

            if (page != null) {
                form.append("<input type='hidden' name='page' value='" + page + "'>");
            }

            if (search != null) {
                form.append("<input type='hidden' name='search' value='" + search + "'>");
            }

            if (searchFields != null) {
                form.append("<input type='hidden' name='searchFields' value='" + searchFields + "'>");
            }

            $(document.body).append(form);
            form.submit();
        }

        function showReleaseDetailPage(id) {
            window.location.href = '/releasesvuejs/' + id;
        }

        function enableEdit(id) {
            window.location.href = '/releasesvuejs/' + id + '/edit';
        }

        $('#search_release').on('click', function() {
            var title = $('.search-title').val();
            var description = $('.search-description').val();
            var date = $('.search-date').val();

            var field_title = $('.field-search-title').val();
            var field_description = $('.field-search-description').val();

            var url = "{{ route('web_releasevuejs_get_all_release') }}";

            if (title != '') {
                url += '?search=title_description:' + title;
            }

            if (description != '') {
                if (title != '') {
                    url += '&detail_description:' + description;
                } else {
                    url += '?search=detail_description:' + description;
                }
            }

            if (date != '') {
                if (title != '' || description != '') {
                    url += '&created_at:' + date;
                } else {
                    url += '?search=created_at:' + date;
                }
            }

            if (field_title != 'like') {
                if (title != '') {
                    url += '&searchFields=title_description:' + field_title;
                } else {
                    url += '?searchFields=title_description:' + field_title;
                }
            }

            if (field_description != 'like') {
                if (title != '' || description != '') {
                    url += '&searchFields=detail_description:' + field_description;
                } else {
                    url += '?searchFields=detail_description:' + field_description;
                }
            }

            window.location.href = url;
        });
    </script>
@endsection --}}

@section('javascript')
    <script>
        const app = new Vue({
            el: '#manage_release',
            data: {
                releases: @json($releases->items()),
                total: @json($releases->total()),
                length: @json($releases->count()),
                message: @json(session('success')),
                error: @json(session('error')),
                success: @json(session('success')),

                params: {
                    orderBy: null,
                    sortedBy: null,
                    limit: null,
                    page: null,
                    search: null,
                    searchFields: null,
                },
                lastPage: @json($releases->lastPage()),
                isLoading: false,
            },
            computed: {

            },
            methods: {
                getRelease: function() {
                    this.isLoading = true;
                    axios.get('releasevuejs/', {
                            params: {
                                orderBy: app.params.orderBy,
                                sortedBy: app.params.sortedBy,
                                limit: app.params.limit,
                                page: app.params.page,
                                search: app.params.search,
                                searchFields: app.params.searchFields,
                            }
                        })
                        .then(function(response) {
                            app.isLoading = false;
                            app.releases = response.data.data.data;
                            app.total = response.data.data.total;
                            app.length = app.releases.length;
                            app.lastPage = response.data.data.last_page;
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                enableEdit: function(id) {
                    window.location.href = 'releasevuejs/' + id + '/edit';
                    // axios.get('releasevuejs/' + id + '/edit')
                    //     .then(function(response) {
                    //         console.log(response);
                    //     })
                    //     .catch(function(error) {
                    //         console.log(error);
                    //     });
                },
                deleteRelease: function(id) {
                    if (confirm("Are you sure you want to delete this release?")) {
                        this.isLoading = true;
                        axios.delete('releasevuejs/' + id + '/delete')
                            .then(function(response) {
                                if (response.data.status == "success") {
                                    app.success = response.data.success;
                                    app.message = response.data.message;
                                    app.getRelease();
                                } else {
                                    app.error = response.data.error;
                                    app.message = response.data.message;
                                }
                                this.isLoading = false;
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                },
                confirmDeleteMoreRelease: function() {
                    this.isLoading = true;
                    var checkBoxes = document.getElementById("body-content")
                        .querySelectorAll('input[type="checkbox"]');
                    var releaseIDs = [];
                    checkBoxes.forEach((checkbox) => {
                        if (checkbox.checked && checkbox.value != 'on') {
                            releaseIDs.push(checkbox.value);
                            checkbox.checked = false;
                        }
                    });

                    if (confirm("Are you sure you want to delete this release?")) {
                        axios.post("{{ route('web_releasevuejs_delete_bulk') }}", {
                                id: releaseIDs,
                                _method: 'DELETE',
                            })
                            .then(function(response) {
                                if (response.data.status == "success") {
                                    app.getRelease();
                                    app.success = response.data.success;
                                    app.message = response.data.message;
                                } else {
                                    app.error = response.data.error;
                                    app.message = response.data.message;
                                }
                                this.isLoading = false;
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                },
                checkAll: function() {
                    var checkBoxes = document.getElementById("body-content")
                        .querySelectorAll('input[type="checkbox"]');

                    check = document.getElementById("checkAll").checked;
                    checkBoxes.forEach((checkbox) => {
                        checkbox.checked = check;
                    });

                    if (check) {
                        $(".delete-more-release").removeClass('hidden');
                    } else {
                        $(".delete-more-release").addClass('hidden');
                    }
                },
                check: function() {
                    var checkBoxes = document.getElementById("body-content")
                        .querySelectorAll('input[type="checkbox"]');

                    var check = true;
                    var count = 0;
                    checkBoxes.forEach((checkbox) => {
                        if (!checkbox.checked) {
                            check = false;
                        } else {
                            count++;
                        }
                    });

                    if (checkBoxes.length) {}
                    document.getElementById("checkAll").checked = check;

                    if (count) {
                        $(".delete-more-release").removeClass('hidden');
                    } else {
                        $(".delete-more-release").addClass('hidden');
                    }
                },
                showReleaseDetailPage: function(id) {
                    window.location.href = 'releasevuejs/' + id;
                },
                sortRelease: function(newOrderBy) {
                    //if orderBy is null or not equal newOrderBy => set sortedBy = asc
                    if (this.params.orderBy == null || this.params.orderBy != newOrderBy) {
                        this.params.orderBy = newOrderBy;
                        this.params.sortedBy = 'asc';
                    } else {
                        //if orderBy is equal newOrderBy => change sortedBy
                        if (this.params.sortedBy == null) {
                            this.params.sortedBy = 'asc';
                        } else {
                            this.params.sortedBy = this.params.sortedBy == 'asc' ? 'desc' : 'asc';
                        }
                    }

                    // change color icon
                    $('.icon-nm').css('color', '#3f4254');
                    $('.icon-' + this.params.orderBy).css('display', 'inline-block');
                    $('.icon-' + this.params.orderBy).css('color', '#a9cef3');
                    $('.icon-' + this.params.orderBy + '.icon-' + this.params.sortedBy).css('color', '#3699FF');
                    $('.field').css('color', '#3f4254');
                    $('.field-' + this.params.orderBy).css('color', '#3699FF');

                },
                searchRelease: function() {
                    this.isLoading = true;

                    this.resetParams();

                    var title = $('.search-title').val();
                    var description = $('.search-description').val();
                    var date = $('.search-date').val();

                    var field_title = $('.field-search-title').val();
                    var field_description = $('.field-search-description').val();

                    search = '';
                    searchFields = '';
                    if (title != '') {
                        search += 'title_description:' + title;
                    }

                    if (description != '') {
                        if (title != '') {
                            search += ';detail_description:' + description;
                        } else {
                            search += 'detail_description:' + description;
                        }
                    }

                    if (date != '') {
                        if (title != '' || description != '') {
                            search += ';created_at:' + date;
                        } else {
                            search += 'created_at:' + date;
                        }
                    }

                    if (field_title != 'like') {
                        searchFields += 'title_description:' + field_title;
                    }

                    if (field_description != 'like') {
                        if (field_title != 'like') {
                            searchFields += ';detail_description:' + field_description;
                        } else {
                            searchFields += 'detail_description:' + field_description;
                        }
                    } else {
                        if (field_title == 'like') {
                            searchFields = null;
                        }
                    }

                    if (search != '') {
                        this.params.search = search;
                    }

                    if (searchFields != '') {
                        this.params.searchFields = searchFields;
                    }

                    console.log(this.params)

                    this.isLoading = false;
                },
                limitRelease: function() {
                    this.params.limit = $('.form-limit').val();

                    this.params.page = 1;
                },
                strip_tags: function(description) {
                    return description.replace(/(<([^>]+)>)/gi, "");
                },
                mb_str_split: function(description) {
                    if (description.length > 20) {
                        return description.substring(0, 20).concat('...');
                    } else {
                        return description;
                    }
                },
                resetParams: function() {
                    this.isLoading = true;

                    // clear params
                    this.params.orderBy = null;
                    this.params.sortedBy = null;
                    this.params.limit = null;
                    this.params.page = null;
                    this.params.search = null;
                    this.params.searchFields = null;

                    // clear message
                    this.success = null;
                    this.error = null;
                    this.message = null;

                    // clear search
                    // $('.search-title').val('');
                    // $('.search-description').val('');
                    // $('.search-date').val('');

                    // $('.field-search-title').val('like');
                    // $('.field-search-description').val('like');

                    // $('.boloc-show').addClass('hidden');

                    // clear icon
                    $('.form-limit').val(10);

                    $('.icon-nm').css('color', '#3f4254');
                    $('.field').css('color', '#3f4254');

                    // clear checkbox
                    var checkBoxes = document.getElementById("body-content")
                        .querySelectorAll('input[type="checkbox"]');
                    checkBoxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            checkbox.checked = false;
                        }
                    });
                    this.check();

                    this.isLoading = false;
                },
                cssPagination: function(page) {
                    if (page == this.params.page || (page == 1 && this.params.page == null)) {
                        return {
                            'background-color': '#3699FF',
                            'color': 'white',
                        };
                    }
                },
                changePage: function(page) {
                    if (page == this.params.page || (page == -1 && this.params.page == null)) {
                        return;
                    }
                    if (page == 1) {
                        $(".previous").addClass("disabled");
                        $(".previous").removeClass("cursor-pointer");
                    } else {
                        $(".previous").removeClass("disabled");
                        $(".previous").addClass("cursor-pointer");
                    }

                    if (page == this.lastPage) {
                        $(".next").addClass("disabled");
                        $(".next").removeClass("cursor-pointer");
                        // return;
                    } else {
                        $(".next").removeClass("disabled");
                        $(".next").addClass("cursor-pointer");
                    }

                    console.log(page, this.params.page, this.lastPage);

                    this.params.page = page;
                },
            },
            watch: {
                releases: function() {
                    console.log("Releases changed: ", this.releases);
                    this.$nextTick(() => {
                        app.check();
                    });
                },
                total: function() {
                    console.log("Rotal changed: " + this.total);
                },
                length: function() {
                    console.log("Length changed: " + this.length);
                },
                params: {
                    handler: function() {
                        this.getRelease();
                        console.log("Params changed: ", this.params);
                    },
                    deep: true,
                },
                lastPage: function() {
                    console.log("LastPage changed: " + this.lastPage);
                },
            }
        })
    </script>
@endsection

@php
    $releaseID = [];
    foreach ($releases as $key => $value) {
        array_push($releaseID, $value->id);
    }
    $releaseID_json = json_encode($releaseID);
@endphp

@section('content')
    <div class="col-12" id="manage_release">
        <div class="row">
            @can('search-users')
                <div class="col">
                    <div class="card card-custom gutter-b card-stretch">
                        <div class="card-header boloc border-0 py-5">
                            <h3 class="card-title"><span class="font-weight-bolder">{{ __('Bộ Lọc') }}</span></h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body boloc-show hidden">
                            <div class="tab-content">
                                <form class="form gutter-b col">
                                    <div class="form-group row mt-4">
                                        <label class="col-3 col-form-label">Title: </label>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-title"
                                                    placeholder="Enter title" />
                                                <div class="input-group-append">
                                                    <select
                                                        class="field-search-title form-control form-control-nm font-weight-bold border-0 bg-light"
                                                        style="width: 75px;">
                                                        <option value="like">like</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Description: </label>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-description"
                                                    placeholder="Enter description" />
                                                <div class="input-group-append">
                                                    <select
                                                        class="field-search-description form-control form-control-nm font-weight-bold border-0 bg-light"
                                                        style="width: 75px;">
                                                        <option value="like">like</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Date Created: </label>
                                        <div class="col-9">
                                            <div class="input-group date">
                                                <input type="date" class="form-control search-date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row-reverse">
                                        <button type="button" id="search_release" class="btn btn-primary btn-block"
                                            style="width: 180px" @click="searchRelease()">{{ __('Lọc danh sách') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        @can('create-admins')
            <div class="create-release">
                <div class="create">
                    <a href="{{ route('web_releasevuejs_create') }}">
                        <button class="btn btn-primary mt-6">
                            Create New Release
                        </button>
                    </a>
                </div>
            </div>
        @endcan

        <div class="table-list-all-release">
            <div class="py-2">
                <div v-if="error" v-html="error"></div>
                <div v-if="success" v-html="success"></div>
            </div>


            @can('delete-users')
                <div class="delete-more-release mb-2 hidden">
                    <input type="button" @click="confirmDeleteMoreRelease()" class="btn btn-light-danger font-weight-bold mr-2"
                        value="Delete Releases">
                </div>
            @endcan

            <div class="card card-custom card-fit">
                <div class="card-header">
                    <div class="card-title">
                        <h3>{{ __('Danh sách') }} Release </h3>
                        <div class="d-flex align-items-center ml-2" v-if="isLoading">
                            <div class="mr-2 text-muted">Loading...</div>
                            <div class="spinner mr-10"></div>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <i class="flaticon2-reload cursor-pointer reset_params" @click="resetParams()" data-toggle="tooltip"
                            title="Reset"></i>
                    </div>
                </div>

                <div class="card-body py-0">
                    <table class="table">
                        <thead>
                            <tr>
                                @can('delete-users')
                                    <td>
                                        <input type="checkbox" id="checkAll" @click="checkAll()">
                                    </td>
                                @endcan
                                <td @click="sortRelease('id')" class="field field-id cursor-pointer"> ID
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-id"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-id"></i>
                                </td>
                                <td @click="sortRelease('name')" class="field field-name cursor-pointer"> Name
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-name"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-name"></i>
                                </td>
                                <td class="field field-title_description cursor-pointer"
                                    @click="sortRelease('title_description')"> Title
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-title_description"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-title_description"></i>
                                </td>
                                <td class="field field-detail_description cursor-pointer"
                                    @click="sortRelease('detail_description')">Description
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-detail_description"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-detail_description"></i>
                                </td>
                                <td class="text-center field field-created_at cursor-pointer"
                                    @click="sortRelease('created_at')"> Date Created
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-created_at"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-created_at"></i>
                                </td>
                                <td class="text-center">Is Publish</td>
                                <td class="text-center"> Images </td>
                                @canany(['search-users', 'update-users', 'delete-users'])
                                    <td class="text-center" colspan="3"> Actions </td>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="body-content">
                            <div v-if="length > 0">
                                @can('list-users')
                                    <tr class="bg-hover-secondary" v-for="release in releases">
                                        @can('delete-users')
                                            <td style="text-align: center;">
                                                <input type="checkbox" :value="release.id" @click="check()">
                                            </td>
                                        @endcan
                                        <td>
                                            @{{ release.id }}
                                        </td>
                                        <td>
                                            @{{ mb_str_split(release.name) }}
                                        </td>
                                        <td class="">
                                            @{{ mb_str_split(release.title_description) }}
                                        </td>
                                        <td>
                                            @{{ mb_str_split(strip_tags(release.detail_description)) }}
                                        </td>
                                        <td class="text-center">
                                            @{{ release.created_at.substring(0, 10) }}
                                        </td>
                                        <td class="text-center">
                                            @{{ release.is_publish }}
                                        </td>
                                        <td>
                                            <div class="small-image d-flex flex-column align-items-center"
                                                v-if="release.images != null">
                                                <div class="symbol symbol-40 mr-3">
                                                    <img alt="Image" :src="release.images[0]" />
                                                </div>
                                                <span style="font-size: 12px" v-if="release.images.length > 1">
                                                    More @{{ release.images.length - 1 }} image(s)
                                                </span>
                                            </div>
                                            <div class="small-image d-flex flex-column align-items-center" v-else>
                                                <p> Not image </p>
                                            </div>
                                        </td>
                                        @can('search-users')
                                            <td style="text-align: center">
                                                <i class="fa la-info-circle btn-show-info"
                                                    @click="showReleaseDetailPage(release.id)"></i>
                                            </td>
                                        @endcan
                                        @can('update-users')
                                            <td style="text-align: center">
                                                <i class="fa fa-pen btn-edit" @click="enableEdit(release.id)"></i>
                                            </td>
                                        @endcan
                                        @can('delete-users')
                                            <td style="text-align: center">
                                                <i class="fa fa-trash btn-delete-one" @click="deleteRelease(release.id)"></i>
                                            </td>
                                        @endcan
                                    </tr>
                                @endcan
                            </div>
                            <div v-else="">
                                <tr v-if="length == 0">
                                    <td colspan="100%" class=" bg-hover-secondary text-center">
                                        <b>{{ __('global.no_data') }}</b>
                                    </td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer pt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center py-0">
                                <div class="d-flex align-items-center" v-if="isLoading">
                                    <div class="mr-2 text-muted">Loading...</div>
                                    <div class="spinner mr-10"></div>
                                </div>
                                <select
                                    class="form-limit form-control form-control-sm font-weight-bold mr-4 border-0 bg-light"
                                    style="width: 75px;" v-on:change="limitRelease()">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="text-muted">Displaying @{{ length }} of @{{ total }}
                                    records</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="paginate">
                                <nav aria-label="navigation">
                                    <ul class="pagination">
                                        <li class="page-item previous disabled">
                                            <div class="page-link" aria-label="Previous"
                                                @click="changePage(params.page-1)">
                                                <span aria-hidden="true">&laquo;</span>
                                            </div>
                                        </li>
                                        <li class="page-item cursor-pointer" v-for="page in lastPage">
                                            <div class="page-link" @click="changePage(page)" :style="cssPagination(page)">
                                                @{{ page }}
                                            </div>
                                        </li>
                                        <li class="page-item cursor-pointer next">
                                            <div class="page-link" aria-label="Next" @click="changePage(params.page+1)">
                                                <span aria-hidden="true">&raquo;</span>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@once
    @push('after_script')
        <script>
            $('.boloc').on('click', function() {
                $('.boloc-show').toggleClass('hidden');
            });
        </script>
    @endpush
@endonce