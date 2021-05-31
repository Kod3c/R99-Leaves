@extends('layouts.main')

@section('page-title')
    {{ __('Dashbord') }}
@endsection

@section('content')
    <div class="page-content">
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col d-flex align-items-center">
                    <h5 class="fullcalendar-title h4 d-inline-block font-weight-400 mb-0 text-white">{{ _('Calendar') }}</h5> &nbsp;&nbsp;
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right rtl-home-menu">
                    @if(Auth::user()->type != 'employee')
                    <div class="d-inline-block">
                        <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title="{{ __('Filter Role') }}">
                            <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-filter"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menulist-scroll calender_role_list">
                                <a class="dropdown-item calender_role_active" data-roll="0" onclick="filter_role(0)">{{ __('Select All') }}</a>
                                @if(!empty($roles)) 
                                    <a class="dropdown-item" data-roll="no_role" onclick="filter_role('no_role')"><i class="fas fa-dot-circle" aria-hidden="true" style="color: #8492a6;"></i>{{ __('Without Role') }}</a>
                                    @foreach ($roles as $role)
                                        <a class="dropdown-item" data-roll="{{ $role['id'] }}"  onclick="filter_role({{ $role['id'] }})">{!! $role['name'] !!}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-inline-block">
                        <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title="{{ __('Filter Location') }}">
                            <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-flag" data-toggle="tooltip"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right employee_menu_listt dropdown-menulist-scroll calender_locatin_list">
                                <a class="dropdown-item calender_location_active" data-location='0' onclick="filter_location(0)">{{ __('Select All') }}</a>
                                @foreach ($locations as $location)
                                    <a class="dropdown-item" data-location='{{ $location['id'] }}' onclick="filter_location({{ $location['id'] }})">{{ $location['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="d-inline-block">
                        <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title="{{ __('View') }}">
                            <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right employee_menu_listt dropdown-menulist-scroll">
                                <a href="{{ url('dashboard') }}"
                                    class="dropdown-item {{ Request::segment(1) == 'dashboard' ? 'calender_active' : '' }}"
                                    onclick="window.location.href=this;">{{ __('Calendar View') }}</a>
                                <a href="{{ url('day') }}" 
                                    class="dropdown-item {{ Request::segment(1) == 'day' ? 'calender_active' : '' }}"
                                    onclick="window.location.href=this;">{{ __('Daily View') }}</a>
                                <a href="{{ url('user-view') }}" 
                                    class="dropdown-item {{ Request::segment(1) == 'user' ? 'calender_active' : '' }}" 
                                    onclick="window.location.href=this;">{{ __('User View') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!-- Fullcalendar -->
                <div class="card overflow-hidden">
                    <div class="calendar" data-toggle="calendar1" id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- {{ $feed_calender }} --}}
@push('pagescript')
<script>

    var feed_calender = {!!  $feed_calender !!};

    function filter_role(role_id = 0)
    {
        $('#calendar').find('.badge1').show();
        if(role_id != 0)
        {
            $('#calendar').find('.badge1').hide();
            $('#calendar').find('.badge1[data_role_id="'+role_id+'"]').show();
        }
        $('.calender_role_list a').removeClass('calender_role_active');
        $('.calender_role_list a[data-roll="'+role_id+'"]').addClass('calender_role_active');
    }

    function filter_location(location_id = 0)
    {
        var data = {
            location_id: location_id,
        }

        $.ajax({
            url: '{{ route('dashboard.location_filter') }}',
            method: 'post',
            data: data,
            success: function (data)
            {
                feed_calender = data;
                $('[data-toggle="calendar1"]').fullCalendar('removeEvents');
                $('[data-toggle="calendar1"]').fullCalendar('addEventSource', feed_calender);
                $('[data-toggle="calendar1"]').fullCalendar('rerenderEvents');
                $('.calender_locatin_list a').removeClass('calender_location_active');
                $('.calender_locatin_list a[data-location="'+location_id+'"]').addClass('calender_location_active');
            }
        });
    }

    // #Full calendar
        var Fullcalendar = function () {
        var e, t, a = $('[data-toggle="calendar1"]');
        a.length && (t = {
            header: {right: "", center: "", left: ""},
            buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
            theme: !1,
            selectable: !0,
            selectHelper: !0,
            editable: !0,
            events: feed_calender,
            eventRender: function(event, element, view) {
                $('[data-toggle="tooltip"]').tooltip();
                var new_description = event.html;
                element.html(new_description);
            },
            dayClick: function (e) {
                var t = moment(e).toISOString();
                $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
            },
            viewRender: function (t) {
                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
            },
            eventClick: function (e, t) {                
                $("#edit-event input[value=" + e.className + "]").prop("checked", !0), $("#edit-event").modal("show"), $(".edit-event--id").val(e.id), $(".edit-event--title").val(e.title), $(".edit-event--description").val(e.description)
            }
        }, (e = a).fullCalendar(t), $("body").on("click", ".new-event--add", function () {
            var t = $(".new-event--title").val(), a = {
                Stored: [], Job: function () {
                    var e = Date.now().toString().substr(6);
                    return this.Check(e) ? this.Job() : (this.Stored.push(e), e)
                }, Check: function (e) {
                    for (var t = 0; t < this.Stored.length; t++) if (this.Stored[t] == e) return !0;
                    return !1
                }
            };
            "" != t ? (e.fullCalendar("renderEvent", {id: a.Job(), title: t, start: $(".new-event--start").val(), end: $(".new-event--end").val(), allDay: !0, className: $(".event-tag input:checked").val()}, !0), $(".new-event--form")[0].reset(), $(".new-event--title").closest(".form-group").removeClass("has-danger"), $("#new-event").modal("hide")) : ($(".new-event--title").closest(".form-group").addClass("has-danger"), $(".new-event--title").focus())
            }), $("body").on("click", "[data-calendar]", function () {
                var t = $(this).data("calendar"), a = $(".edit-event--id").val(), n = $(".edit-event--title").val(), o = $(".edit-event--description").val(), i = $("#edit-event .event-tag input:checked").val(), s = e.fullCalendar("clientEvents", a);
                "update" === t && ("" != n ? (s[0].title = n, s[0].description = o, s[0].className = [i], console.log(i), e.fullCalendar("updateEvent", s[0]), $("#edit-event").modal("hide")) : ($(".edit-event--title").closest(".form-group").addClass("has-error"), $(".edit-event--title").focus())), "delete" === t && ($("#edit-event").modal("hide"), setTimeout(function () {
                    swal({title: "Are you sure?", text: "You won't be able to revert this!", type: "warning", showCancelButton: !0, buttonsStyling: !1, confirmButtonClass: "btn btn-danger", confirmButtonText: "Yes, delete it!", cancelButtonClass: "btn btn-secondary"}).then(function (t) {
                        t.value && (e.fullCalendar("removeEvents", a), swal({title: "Deleted!", text: "The event has been deleted.", type: "success", buttonsStyling: !1, confirmButtonClass: "btn btn-primary"}))
                    })
                }, 200))
            }), $("body").on("click", "[data-calendar-view]", function (t) {
                t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
                var a = $(this).attr("data-calendar-view");
                e.fullCalendar("changeView", a)
            }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
                t.preventDefault(), e.fullCalendar("next")
            }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
                t.preventDefault(), e.fullCalendar("prev")
            }))
        }();


</script>
@endpush

