@extends('release::admin.admin-list-release')

@section('css')
    <style>
        @include('release::admin.admin-main-css');
    </style>
@endsection

@section('js')
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
        });

        function activeBody(id) {
            $('#body' + id).toggleClass('unactive');
        }

        function searchRelease() {
            var search = $('#search-by-name').val();

            var url = "{{ route('web_release_search') }}";
            if ($('#field-id').is(':checked')) {
                url = "{{ route('web_release_search_by_id') }}";
                $('#search-by-name').attr('name', 'id');

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
                            return`<div class="release-note-item">
                                                          <div class="release-note-item-header" onclick="activeBody(${release.id})">
                                                            <div class="release-note-item-header-title">
                                                              ${release.name}
                                                            </div>
                                                            <div class="release-note-item-header-date">
                                                              ${release.date_created}
                                                            </div>
                                                          </div>
                                                          <div class="release-note-item-body unactive" id="body${release.id}">
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
                    console.log(data);
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
    </script>
@endsection

@section('php')
    @php
        $releaseID = [];
        foreach ($releases as $key => $value) {
            array_push($releaseID, $value->id);
        }
        $releaseID_json = json_encode($releaseID);
    @endphp
@endsection
