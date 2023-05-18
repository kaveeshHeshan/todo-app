@extends('layouts.app')

@push('custom-styles')

    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .custom-toggle {
            position: relative;
            display: inherit;
            display: inline-block;
            width: 60px;
            height: 1.7rem;
            border: #7979f8 solid 2px;
            border-radius: 20px;
            /* margin-top: 50px; */
        }

        .custom-toggle input {
            display: none;
        }

        .custom-toggle input:checked+.custom-toggle-slider {
            border: 1px solid #1a1f71;
            background: #1a1f71;
        }

        .custom-toggle input:checked+.custom-toggle-slider:before {
            transform: translateX(32px);
            background: #fff;
        }

        .custom-toggle input:disabled+.custom-toggle-slider {
            border: 1px solid #e9ecef;
        }

        .custom-toggle input:disabled:checked+.custom-toggle-slider {
            border: 1px solid #e9ecef;
        }

        .custom-toggle input:disabled:checked+.custom-toggle-slider:before {
            background-color: #8a98eb;
        }

        .custom-toggle input:disabled:checked+.custom-toggle-slider:after {
            /* background-color: #8a98eb; */
            color: #1a1f71;
        }

        .custom-toggle-slider {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            cursor: pointer;
            border: 1px solid #ced4da;
            border-radius: 20px;
            /* border-radius: 34px !important; */
            background-color: transparent;
        }

        .custom-toggle-slider:before {
            position: absolute;
            bottom: 2px;
            left: 2px;
            width: 18px;
            height: 18px;
            content: "";
            transition: all 0.15s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-radius: 50% !important;
            background-color: #1a1f71;
        }

        .custom-toggle-wrapper .custom-toggle+.custom-toggle {
            margin-left: 1rem !important;
        }

        .custom-toggle input:checked+.custom-toggle-slider:after {
            right: auto;
            left: 0;
            content: attr(data-label-on);
            color: #fff;
        }

        .custom-toggle-slider:after {
            font-family: inherit;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 24px;
            position: absolute;
            top: 0;
            right: 0;
            display: block;
            overflow: hidden;
            min-width: 1.66667rem;
            margin: 0 0.21667rem;
            content: attr(data-label-off);
            transition: all 0.15s ease;
            text-align: center;
            color: #1a1f71;
        }

        .task {
            border: #ced4da solid 2px;
            border-radius: 10px;
            padding: 20px 15px 20px 15px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">{{ __('Todo - Information') }}</div>
                <div class="p-4">
                    <h5>{{ __('Todo List - Information') }}</h5>
                    <hr>
                    <form>
                        <div class="form-group py-2">
                            <label for="todo-list-name">{{ __('Name') }}</label>
                            <input type="email" class="form-control" id="todo-list-name" placeholder={{ __('Name') }}>
                        </div>
                        <div class="form-group py-2">
                            <label for="todo-list-desc">{{ __('Description') }}</label>
                            <textarea class="form-control" name="description" id="todo-list-desc" cols="10" rows="5" placeholder={{ __('Description') }}></textarea>
                        </div>
                        {{-- <div class="form-group row py-2">
                            <div class="col row justify-content-center">
                                <label class="form-control-label col-md-4 pt-2" for="input-is_active">
                                    {{ __('Would you like to add tasks as well ?')}}
                                </label>
                                <div class="form-group custom-file col-md-8" style="margin-bottom: 15px;">
                                    <label class="custom-toggle" style="color: #1a1f71 !important;margin-top: 10px !important;">
                                        <input id="customPromoCheckBox" class="" style="margin-top: 20px;" type="checkbox" name="is_active" id="activeInactiveStatus">
                                        <span class="custom-toggle-slider" data-label-off="No" data-label-on="Yes"></span>
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div id="todo-tasks-section" class="">
                            <h5>{{ __('Todo Tasks - Information') }}</h5>
                            <hr>
                            <div class="">
                                {{-- <div id="main-container">
                                    <div id="container-item" class="task-item">
                                        <div class="task">
                                            <div class="form-row row">
                                                <div class="col">
                                                    <label for="task-title">{{ __('Task Title') }}</label>
                                                    <input id="task-title" type="text" class="form-control" placeholder={{ __('Task Title') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-date">{{ __('Due Date') }}</label>
                                                    <input id="task-date" type="date" class="form-control" placeholder={{ __('Due Date') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-time">{{ __('Due Time') }}</label>
                                                    <input id="task-time" type="time" class="form-control" placeholder={{ __('Due Time') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-status">{{ __('Status') }}</label>
                                                    <input id="task-status" type="text" class="form-control" placeholder={{ __('Status') }}>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group" style="margin: 10px 10px 10px 10px;">
                                                        <a href="javascript:void(0)"
                                                            class="remove-item btn btn-sm btn-danger remove-social-media">X</a>
                                                    </div>
                                                </div>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 mb-20">
                                        <div>
                                            <a class="btn btn-sm btn-success AddMore mb-4" id="add-more" href="javascript:;"
                                                role="button"><i class="fa fa-plus"></i>
                                                Add Section
                                            </a>

                                        </div>
                                    </div>
                                </div> --}}
                                <div id="main-container">

                                    {{-- Section --}}
                                    <div class="container-item task row" id="1">

                                            <div class="form-row row">
                                                <div class="col">
                                                    <label for="task-title">{{ __('Title') }}</label>
                                                    <input type="text" class="form-control" placeholder={{ __('Title') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-date">{{ __('Due Date') }}</label>
                                                    <input type="date" class="form-control" placeholder={{ __('Due Date') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-time">{{ __('Due Time') }}</label>
                                                    <input type="time" class="form-control" placeholder={{ __('Due Time') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-status">{{ __('Status') }}</label>
                                                    <input type="text" class="form-control" placeholder={{ __('Status') }}>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group" style="margin: 10px 10px 10px 10px;">
                                                        <a href="javascript:void(0)" onclick="removeTask(1)"
                                                            class="remove-item btn btn-sm btn-danger remove-social-media">X</a>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <div id="clone-section" class=""></div>
                                    {{--  --}}

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-20">
                                        <div>
                                            <a class="btn btn-sm btn-success AddMore mb-4" id="add-more" href="javascript:;"
                                                role="button"><i class="fa fa-plus"></i>
                                                <i class='bx bx-plus'></i> {{ __('Add Task') }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row flex">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript" src="{{ url('/js/cloneData.js') }}"></script>
    <script>

        // Onload
        $(document).ready(function() {
            
            // $('#todo-tasks-section').hide();

        });

        // Todo - Tasks section hide/show
        $(document).on("click", '#customPromoCheckBox', function() {

            if ($('#customPromoCheckBox').is(":checked")) {

                $('#todo-tasks-section').show().fadeIn();

            } else {

                $('#todo-tasks-section').hide().fadeOut();

            }
        });
    </script>

<script>
    // $('a#add-more').cloneData({
    //     mainContainerId: 'main-container',
    //     cloneContainer: 'container-item',
    //     removeButtonClass: 'remove-item',
    //     removeConfirm: true,
    //     removeConfirmMessage: 'Are you sure want to delete?',
    //     minLimit: 1,
    //     maxLimit: 10,
    //     defaultRender: 1,
    //     excludeHTML: ".exclude",
    //     init: function() {
    //         console.info(':: Initialize Plugin ::');
    //     },
    //     beforeRender: function() {
    //         console.info(':: Before rendered callback called');
            
    //     },
    //     afterRender: function() {
    //         console.info(':: After rendered callback called');
            
    //     },
    //     afterRemove: function() {
    //         console.warn(':: After remove callback called');
    //     },
    //     beforeRemove: function() {
    //         console.warn(':: Before remove callback called');
    //     }

    // });
    var minColnes = 1;
    var maxClones = 5;

    $( "a#add-more" ).on( "click", function() {
        var initialId = $('.container-item:last').attr('id');
        console.log(initialId);
        var elCount = $('.container-item').length + 1;
        if (elCount <= maxClones) {
            // var section = $('#1').clone(true);

            var section = `<div class="container-item task row" id=${parseInt(initialId) + 1}>
                                <div class="form-row row">
                                    <div class="col">
                                        <label for="task-title">{{ __('Title') }}</label>
                                        <input type="text" class="form-control" placeholder={{ __('Title') }}>
                                    </div>
                                    <div class="col">
                                        <label for="task-date">{{ __('Due Date') }}</label>
                                        <input type="date" class="form-control" placeholder={{ __('Due Date') }}>
                                    </div>
                                    <div class="col">
                                        <label for="task-time">{{ __('Due Time') }}</label>
                                        <input type="time" class="form-control" placeholder={{ __('Due Time') }}>
                                    </div>
                                    <div class="col">
                                        <label for="task-status">{{ __('Status') }}</label>
                                        <input type="text" class="form-control" placeholder={{ __('Status') }}>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group" style="margin: 10px 10px 10px 10px;">
                                            <a href="javascript:void(0)" onclick="removeTask(${parseInt(initialId) + 1})"
                                                class="remove-item btn btn-sm btn-danger remove-social-media">X</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                            var prevElement = $('.container-item:last')[0];
                            console.log("Selector");
                            console.log(prevElement);
                            prevElement.insertAdjacentHTML('afterend', section)
        } else {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'warning',
                title: 'The Maximum amount of tasks you can add are '+maxClones+'!',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            })
        }
    });

    // $( ".remove-item" ).on( "click", function() {
    //     console.log($('.remove-item'));
    // });
    function removeTask(elId) {
        var elmntCount = $('.container-item').length;
        if (elmntCount > minColnes) {
            $('#'+elId).remove()
        } else {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'warning',
                title: 'Todo list should have atleast '+minColnes+' task!',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            })
        }
        // var parentEl = $(this).parent('.container-item');
        // console.log($('#'+elId).attr('id'));
    }

</script>

@endpush

@endsection
