@extends('admin.template')

@php
    $title = __('app.calendar');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.calendar') => false];
@endphp

@section('content')
    <style>
        /* Fix Calendar Boostrap5 Theme */
        .fc-theme-bootstrap5 .fc-list,
        .fc-theme-bootstrap5 .fc-scrollgrid,
        .fc-theme-bootstrap5 td,
        .fc-theme-bootstrap5 th {
            border:1px solid #ddd;
        }

        .fc-toolbar-title:first-letter{
            text-transform: capitalize;
        }
        .fc .fc-daygrid-day.fc-day-today{
            background-color: #71dd37;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.calendar_show') }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div id='calendar'></div>
            <div class="hidden-modal">
                <button type="button" id="info" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal" hidden></button>
                <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title" ></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="date-tour" class="form-label">{{ __('app.date') }}</label>
                                        <input type="text" id="date-tour" class="form-control" disabled >
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col mb-0">
                                        <label for="start" class="form-label">{{ __('app.star') }}</label>
                                        <input type="text" id="start" class="form-control" disabled>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="end" class="form-label">{{ __('app.end') }}</label>
                                        <input type="text" id="end" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row  mt-1">
                                    <div class="col mb-0">
                                        <label for="state" class="form-label">{{ __('app.tour_states_singular') }}</label>
                                        <input type="text" id="state" class="form-control" disabled>
                                    </div>
                                    <div class="col mb-0 ">
                                        <label for="type" class="form-label">{{ __('app.tour_type_singular') }}</label>
                                        <input type="text" id="type" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col mb-0">
                                        <label for="guides" class="form-label"> {{ __('app.quantity')}} {{ __('app.guide') }}</label>
                                        <input type="text" id="guides" class="form-control" disabled>
                                    </div>
                                    <div class="col mb-0 ">
                                        <label for="clients" class="form-label"> {{ __('app.quantity')}} {{ __('app.customer') }}</label>
                                        <input type="text" id="clients" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col mb-3">
                                        <label for="user" class="form-label">{{ __('app.creat_by') }}</label>
                                        <input type="text" id="user" class="form-control" disabled >
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-3">
                                        <label for="info" class="form-label">{{ __('app.information') }}</label>
                                        <textarea type="text" id="info" class="form-control" disabled ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                                @if(!auth()->user()->hasRole('Tour Operador'))
                                    <a id="goTour"><button type="button" class="btn btn-primary">{{ __('app.goTour') }}</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('page-scripts')
    <script>

        function getTourInfo(url){
            const userRole = '{{auth()->user()->hasRole('Tour Operador')}}'
            const result = fetch(url);

            result
                .then(response => response.json())
                .then(data=>{

                    document.getElementById("modal-title").innerHTML = data.title;
                    document.getElementById("date-tour").value = data.date;
                    document.getElementById("start").value = data.start;
                    document.getElementById("end").value = data.end;
                    document.getElementById("state").value = data.state;
                    document.getElementById("type").value = data.type;
                    document.getElementById("guides").value = data.guides;
                    document.getElementById("clients").value = data.clients;
                    document.getElementById("user").value = data.user;
                    document.getElementById("info").innerHTML = data.info;

                    if(Number(userRole)!== 1){
                        document.getElementById("goTour").onclick = function() {
                            this.href = data.route;
                        };
                    }


                    document.getElementById("info").click();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                locale:'es',

                timeFormat: 'H(:mm)',

                slotLabelFormat:{
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true,
                    meridiem: 'short',
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },

                themeSystem: 'bootstrap5',

                buttonIcons:{
                    prev: 'i fc-icon fc-icon-chevron-left',
                    next: 'i fc-icon fc-icon-chevron-right',
                },

                headerToolbar:{
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,listWeek'
                },

                view:{
                    dayGridMonth:{

                    }
                },

                eventSources: [
                    {
                        url: '{{ route('calendar.get') }}', // use the `url` property
                       // color: '#378006',    // an option!
                        //textColor: 'black',  // an option!
                        failure: function() {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.calendar_error') }}',
                                'error'
                            )
                        },
                    },
                ],

                eventClick: function (info){
                    const route = '{{ route('calendar.getInfo',0) }}'
                    const f_route = route.slice(0, -1) + info.event.id;
                    getTourInfo(f_route);
                }

            });
            calendar.render();
        });

    </script>
@endpush


