@extends('authorization::layout.app_admin_nova')

@section('title')
    {{ __('Show Permission') }}
@endsection

@php
    $view_load_theme = 'base';
@endphp

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Show Permission') }}</h2>
            </div>
        </div>
    </div>
@endsection

@once
    @push('after_header')
        <link href="{{ asset('theme/' . $view_load_theme . '/css/show_permission.css') }}" rel="stylesheet" type="text/css">
    @endpush
@endonce

@section('javascript')
    <script>
        const app = new Vue({
            el: '#permission_field',
            data: {
                list_permissions: [],
                groups: [],
            },
            computed: {

            },
            methods: {
                getPermissions: function() {
                    axios.get('{{ route('get_authorization_home_page') }}' + '?limit=999999')
                        .then(function(response) {
                            response.data.data.forEach(function(item) {
                                if (app.groups[item.group] === undefined && item.group !== null) {
                                    app.groups[item.group] = [];
                                    app.groups.push({
                                        name: item.group,
                                        count: 10,
                                    });
                                }
                                if (item.group === null) {
                                    if (app.groups["None_Group"] === undefined) {
                                        app.groups["None_Group"] = [];
                                        app.groups.push({
                                            name: "None_Group",
                                            count: 10,
                                        });
                                    }
                                    if (app.list_permissions["None_Group"] === undefined) {
                                        app.list_permissions["None_Group"] = [];
                                    }
                                    app.list_permissions["None_Group"].push(item);
                                } else {
                                    if (app.list_permissions[item.group] === undefined) {
                                        app.list_permissions[item.group] = [];
                                    }
                                    app.list_permissions[item.group].push(item);
                                }
                            });

                            app.groups.forEach(function(item) {
                                app.groups[item.name] = app.list_permissions[item.name].length;
                            });
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                limitPermission: function() {
                    axios.get('{{ route('get_authorization_home_page') }}' + '?limit=20')
                        .then(function(response) {
                            app.list_permissions = [];
                            response.data.data.forEach(function(item) {
                                if (!app.groups.includes(item.group) && item.group !== null) {
                                    app.groups.push(item.group);
                                }
                                if (item.group === null) {
                                    if (!app.groups.includes("None_Group")) {
                                        app.groups.push("None_Group");
                                    }
                                    if (app.list_permissions["None_Group"] === undefined) {
                                        app.list_permissions["None_Group"] = [];
                                    }
                                    app.list_permissions["None_Group"].push(item);
                                } else {
                                    if (app.list_permissions[item.group] === undefined) {
                                        app.list_permissions[item.group] = [];
                                    }
                                    app.list_permissions[item.group].push(item);
                                }
                            });
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                seeMore: function(group) {
                    this.groups.forEach(function(item) {
                        if (item.name === group) {
                            item.count += 10;
                        }
                    });
                },
                seeLess: function(group) {
                    this.groups.forEach(function(item) {
                        if (item.name === group) {
                            item.count -= 10;
                        }
                    });
                },
                hidden: function(id) {
                    var x = document.getElementById(id);
                    x.classList.toggle("hidden");
                }
            },
            watch: {
                list_permissions: function(value) {
                    console.log("show list", this.list_permissions);
                },
                groups: function(value) {
                    console.log("show groups", this.groups);
                },
            }
        });

        app.getPermissions();
    </script>
@endsection

@section('content')
    <div class="col-12" id="permission_field">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        List Permission
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="list" v-for="(group, key) in groups">
                    <div class="group mb-2">
                        <div class="group_name mb-1 font-weight-bold" @click="hidden(group.name)">
                            @{{ group.name }}
                        </div>
                        <div class="list-body" v-bind:id="group.name">
                            <table class="table ml-4">
                                <tbody>
                                    <tr v-for="(permission, index) in list_permissions[group.name]"
                                        v-if="index < group.count">
                                        <td>@{{ permission.name }}</td>
                                        <td>@{{ permission.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="btn-group">
                                <div class="btn btn-secondary" @click='seeLess(group.name)' v-if="group.count > 10">
                                    See less
                                </div>

                                <div class="show-more btn btn-primary" @click="seeMore(group.name)"
                                    v-if="group.count < groups[group.name]">
                                    See more
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
