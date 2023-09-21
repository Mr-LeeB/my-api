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
        Vue.component('show-list-permission', {
            props: {
                groups: Array,
                list_permissions: Array,
                num: Number,
            },
            methods: {
                seeMore: function(group) {
                    return app.seeMore(group);
                },
                seeLess: function(group) {
                    return app.seeLess(group);
                },
                hidden: function(id) {
                    return app.hidden(id);
                }
            },
            template: `<div class="card card-flush h-md-100" style="width: 100%;">
                                    <div class="card-header" @click="hidden(groups[num-1].name)">
                                        <div class="card-title mb-0">
                                            <h3 class="d-flex justify-content-between font-weight-bold">
                                                @{{ groups[num - 1].name }}
                                                <i class="flaticon2-next hidden" :id="groups[num - 1].name + 'next'"></i>
                                                <i class="flaticon2-down" :id="groups[num - 1].name + 'down'"></i>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="content px-0 py-0" :id="groups[num - 1].name">
                                        <div class="card-body pt-1">
                                            <div class="font-weight-bold text-gray-600 mb-5">
                                                Total permission in @{{ groups[num - 1].name }} group: @{{ groups[groups[num - 1].name] }}
                                            </div>
                                            <div class="d-flex flex-column text-gray-600">
                                                <div class="d-flex align-items-center"
                                                    v-for="(permission, index) in list_permissions[groups[num-1].name]"
                                                    v-if="index < groups[num-1].count">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 35%">@{{ permission.name }}</td>
                                                                <td style="width: 65%">@{{ permission.description }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer py-2 mb-0" v-show="groups[groups[num-1].name] > 10">
                                            <div class="btn-group btn-group-sm">
                                                <div class="btn btn-secondary" @click='seeLess(groups[num-1].name)'
                                                    v-if="groups[num-1].count > 10">
                                                    See less
                                                </div>
                                                <div class="show-more btn btn-primary" @click="seeMore(groups[num-1].name)"
                                                    v-if="groups[num-1].count < groups[groups[num-1].name]">
                                                    See more
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`,
        });
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
                    var y = document.getElementById(id + 'next');
                    var z = document.getElementById(id + 'down');
                    x.classList.toggle("hidden");
                    y.classList.toggle("hidden");
                    z.classList.toggle("hidden");
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
                    <h2 class="">
                        List Permission
                    </h2>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row d-flex justify-content-between">
                        <div class="col-6 ">
                            <div class="row mb-2 mr-2" v-for="num in Math.floor(groups.length / 2)">
                                <show-list-permission :groups="groups" :list_permissions="list_permissions"
                                    :num="num">
                                </show-list-permission>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row mb-2 ml-2" v-for="num in groups.length"
                                v-if="num > Math.floor(groups.length / 2)">
                                <show-list-permission :groups="groups" :list_permissions="list_permissions"
                                    :num="num">
                                </show-list-permission>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
