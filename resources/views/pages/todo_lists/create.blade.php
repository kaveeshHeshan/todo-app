@extends('layouts.app')

@push('custom-styles')

    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .form-control:focus {
            outline: none !important;
        }
        .task {
            border: #ced4da solid 2px;
            border-radius: 10px;
            padding: 20px 15px 20px 15px;
            margin-bottom: 20px;
        }
        .has-error input,
        .has-error textarea {
            border: red solid 2px !important;
        }
        .error-help-block,
        .has-error .error-help-block {
            color: red !important;
            padding: 10px 10px 10px 10px !important;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="py-4">
        <a class="btn btn-success" href="{{url('/home')}}"><i class='bx bx-chevron-left'></i> {{ __('Back') }}</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">{{ __('Todo - Information') }}</div>
                <div class="p-4">
                    <h5>{{ __('Todo List - Information') }}</h5>
                    <hr>
                    <form id="add-todo-list" action="{{route('todo_lists.store')}}" method="POST">
                        @csrf
                        <div class="form-group py-2">
                            <label for="todo-list-name">{{ __('Name') }}</label>
                            <input type="text" name="title" class="form-control" id="todo-list-name" placeholder={{ __('Name') }}>
                        </div>
                        <div class="form-group py-2">
                            <label for="todo-list-desc">{{ __('Description') }}</label>
                            <textarea class="form-control" name="description" id="todo-list-desc" cols="10" rows="5" placeholder={{ __('Description') }}></textarea>
                        </div>
                        
                        <div id="todo-tasks-section" class="mt-2">
                            <h5>{{ __('Todo Tasks - Information') }}</h5>
                            <hr>
                            <div class="p-3">
                                <div id="main-container">

                                    {{-- Section --}}
                                    <div class="container-item task row" id="1">

                                            <div class="form-row row">
                                                <div class="col">
                                                    <label for="task-title">{{ __('Title') }}</label>
                                                    <input id="tasks[0][title]" name="tasks[0][title]" type="text" class="form-control title" placeholder={{ __('Title') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-date">{{ __('Due Date') }}</label>
                                                    <input id="tasks[0][due_date]" name="tasks[0][due_date]" type="date" class="form-control due_date" placeholder={{ __('Due Date') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-time">{{ __('Due Time') }}</label>
                                                    <input id="tasks[0][due_time]" name="tasks[0][due_time]" type="time" class="form-control due_time" placeholder={{ __('Due Time') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-status">{{ __('Status') }}</label>
                                                    <select id="tasks[0][status]" name="tasks[0][status]" class="form-select status" aria-label="Default select example">
                                                        <option disabled selected>{{ __('Select status') }}</option>
                                                        <option value="pending">{{ __('Pending') }}</option>
                                                        <option value="complete">{{ __('Complete') }}</option>
                                                        <option value="incomplete">{{ __('Incomplete') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group" style="margin: 10px 10px 10px 10px;">
                                                        <a href="javascript:void(0)" onclick="removeTask(1)"
                                                            class="remove-item btn btn-sm btn-danger remove-social-media">X</a>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-20">
                                        <div>
                                            <a class="btn btn-md btn-success AddMore mb-4" id="add-more" href="javascript:;"
                                                role="button"><i class="fa fa-plus"></i>
                                                <i class='bx bx-plus'></i> {{ __('Add Task') }} <span id="task-count">( 4 )</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-3">
                            <button type="submit" class="btn btn-primary rounded-lg">{{ __('Save') }}</button>
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

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    <script>
        // Clone HTML Element
        var minColnes = 1;
        var maxClones = 5;
        var maxTaskCount = maxClones - 1;
        var initialInputID = 0;

        $( "a#add-more" ).on( "click", function() {

            var initialId = $('.container-item:last').attr('id');

            var elCount = $('.container-item').length + 1;

            var taskCountEl = document.getElementById('task-count');

            if (elCount <= maxClones) {

                var section = `<div class="container-item task row" id=${parseInt(initialId) + 1}>
                                    <div class="form-row row">
                                        <div class="col">
                                            <label for="task-title">{{ __('Title') }}</label>
                                            <input id="tasks[${parseInt(initialId)}][title]" name="tasks[${parseInt(initialId)}][title]" type="text" class="form-control title" placeholder={{ __('Title') }}>
                                        </div>
                                        <div class="col">
                                            <label for="task-date">{{ __('Due Date') }}</label>
                                            <input id="tasks[${parseInt(initialId)}][due_date]" name="tasks[${parseInt(initialId)}][due_date]" type="date" class="form-control due_date" placeholder={{ __('Due Date') }}>
                                        </div>
                                        <div class="col">
                                            <label for="task-time">{{ __('Due Time') }}</label>
                                            <input id="tasks[${parseInt(initialId)}][due_time]" name="tasks[${parseInt(initialId)}][due_time]" type="time" class="form-control due_time" placeholder={{ __('Due Time') }}>
                                        </div>
                                        <div class="col">
                                            <div class="col">
                                                <label for="task-status">{{ __('Status') }}</label>
                                                <select id="tasks[${parseInt(initialId)}][status]" name="tasks[${parseInt(initialId)}][status]" class="form-select status" aria-label="Default select example">
                                                    <option disabled selected>{{ __('Select status') }}</option>
                                                    <option value="pending">{{ __('Pending') }}</option>
                                                    <option value="complete">{{ __('Complete') }}</option>
                                                    <option value="incomplete">{{ __('Incomplete') }}</option>
                                                </select>
                                            </div>
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
                                prevElement.insertAdjacentHTML('afterend', section)
                                var restTaskCount = maxClones - elCount;
                                $('#task-count').text(`( ${restTaskCount} )`)

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

        function removeTask(elId) {
            var elmntCount = $('.container-item').length;
            if (elmntCount > minColnes) {
                $('#'+elId).remove();
                var afterRemvTaskCount = (maxClones - elmntCount) + 1;
                $('#task-count').text(`( ${afterRemvTaskCount} )`);

                // Rearrange index array
                // For Titles
                $('.title').each(function(i, obj) {
                    $(this).attr('id', `tasks[${i}][title]`);
                    $(this).attr('name', `tasks[${i}][title]`);
                });

                // For Due dates
                $('.due_date').each(function(i, obj) {
                    $(this).attr('id', `tasks[${i}][due_date]`);
                    $(this).attr('name', `tasks[${i}][due_date]`);
                });

                // For Due times
                $('.due_time').each(function(i, obj) {
                    $(this).attr('id', `tasks[${i}][due_time]`);
                    $(this).attr('name', `tasks[${i}][due_time]`);
                });

                // For Status
                $('.status').each(function(i, obj) {
                    console.log(i);
                    $(this).attr('id', `tasks[${i}][status]`);
                    $(this).attr('name', `tasks[${i}][status]`);
                });
            } else {
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'warning',
                    title: 'Todo list should have at least '+minColnes+' task !',
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3500
                })
            }
            
        }

    </script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreTodoListRequest', '#add-todo-list'); !!}

@endpush

@endsection
