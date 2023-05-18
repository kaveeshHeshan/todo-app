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
                    <form id="update-todo-list" action="{{route('todo_lists.update', $todoList->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group py-2">
                            <label for="todo-list-name">{{ __('Name') }}</label>
                            <input type="text" name="title" class="form-control" id="todo-list-name" value="{{$todoList->title}}">
                        </div>
                        <div class="form-group py-2">
                            <label for="todo-list-desc">{{ __('Description') }}</label>
                            <textarea class="form-control" name="description" id="todo-list-desc" cols="10" rows="5" placeholder={{ __('Description') }}>{{$todoList->description}}</textarea>
                        </div>
                        
                        <div id="todo-tasks-section" class="mt-2">
                            <h5>{{ __('Todo Tasks - Information') }}</h5>
                            <hr>
                            <div class="p-3">
                                <div id="main-container">
                                    @php
                                        $i = 0;
                                    @endphp
                                    {{-- Section --}}
                                    @foreach ($todoList->tasksData as $task)
                                        <div class="container-item task row" id="{{$i}}">
                                            <input id="r-id-{{$i}}" name="tasks[{{$i}}][r_id]" type="text" value="{{$task->id}}" hidden>
                                            <div class="form-row row">
                                                <div class="col">
                                                    <label for="task-title">{{ __('Title') }}</label>
                                                    <input id="tasks[{{$i}}][title]" name="tasks[{{$i}}][title]" type="text" class="form-control title" value="{{$task->title}}" placeholder={{ __('Title') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-date">{{ __('Due Date') }}</label>
                                                    <input id="tasks[{{$i}}][due_date]" name="tasks[{{$i}}][due_date]" type="date" class="form-control due_date" value="{{$task->due_date}}" placeholder={{ __('Due Date') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-time">{{ __('Due Time') }}</label>
                                                    <input id="tasks[{{$i}}][due_time]" name="tasks[{{$i}}][due_time]" type="time" class="form-control due_time" value="{{$task->due_time}}" placeholder={{ __('Due Time') }}>
                                                </div>
                                                <div class="col">
                                                    <label for="task-status">{{ __('Status') }}</label>
                                                    <select id="tasks[{{$i}}][status]" name="tasks[{{$i}}][status]" class="form-select status" aria-label="Default select example">
                                                        <option disabled selected>{{ __('Select status') }}</option>
                                                        <option value="pending" @if ($task->status == 'pending') selected @endif>{{ __('Pending') }}</option>
                                                        <option value="complete" @if ($task->status == 'complete') selected @endif>{{ __('Complete') }}</option>
                                                        <option value="incomplete" @if ($task->status == 'incomplete') selected @endif>{{ __('Incomplete') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group" style="margin: 10px 10px 10px 10px;">
                                                        <a href="javascript:void(0)" onclick="removeTask({{$i}})"
                                                            class="remove-item btn btn-sm btn-danger remove-social-media">X</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-20">
                                        <div>
                                            <a class="btn btn-md btn-success AddMore mb-4" id="add-more" href="javascript:;"
                                                role="button"><i class="fa fa-plus"></i>
                                                <i class='bx bx-plus'></i> {{ __('Add Task') }} <span id="task-count"></span>
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
            console.log("Initial ID : "+initialId);
            var elCount = $('.container-item').length + 1;

            var taskCountEl = document.getElementById('task-count');

            if (elCount <= maxClones) {

                var section = `<div class="container-item task row" id=${parseInt(initialId) + 1}>
                                    <div class="form-row row">
                                        <input id="r-id-${parseInt(initialId) + 1}" name="tasks[${parseInt(initialId) + 1}][r_id]" type="text" value="" hidden>
                                        <div class="col">
                                            <label for="task-title">{{ __('Title') }}</label>
                                            <input id="tasks[${parseInt(initialId) + 1}][title]" name="tasks[${parseInt(initialId) + 1}][title]" type="text" class="form-control title" placeholder={{ __('Title') }}>
                                        </div>
                                        <div class="col">
                                            <label for="task-date">{{ __('Due Date') }}</label>
                                            <input id="tasks[${parseInt(initialId) + 1}][due_date]" name="tasks[${parseInt(initialId) + 1}][due_date]" type="date" class="form-control due_date" placeholder={{ __('Due Date') }}>
                                        </div>
                                        <div class="col">
                                            <label for="task-time">{{ __('Due Time') }}</label>
                                            <input id="tasks[${parseInt(initialId) + 1}][due_time]" name="tasks[${parseInt(initialId) + 1}][due_time]" type="time" class="form-control due_time" placeholder={{ __('Due Time') }}>
                                        </div>
                                        <div class="col">
                                            <div class="col">
                                                <label for="task-status">{{ __('Status') }}</label>
                                                <select id="tasks[${parseInt(initialId) + 1}][status]" name="tasks[${parseInt(initialId) + 1}][status]" class="form-select status" aria-label="Default select example">
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
            var rIdValue = $( "#r-id-"+elId ).val();
            var elementCount = $('.container-item').length;
            let app_url = {!! json_encode(url('/')) !!};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (rIdValue.length > 0) {
                // console.log("RID is not null");
                if (elementCount > minColnes) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will lead to permanant task delete!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeElementProcedure(elId);
                            $.ajax({
                                type: 'delete',
                                url: `${app_url}/task/remove/${rIdValue}`,
                                success: function(data) {

                                    Swal.fire({
                                        toast: true,
                                        position: 'bottom-end',
                                        icon: 'success',
                                        title: 'Task removed successfully!',
                                        showConfirmButton: false,
                                        timerProgressBar: true,
                                        timer: 3500
                                    });

                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        toast: true,
                                        position: 'bottom-end',
                                        icon: 'error',
                                        title: 'Something went wrong!',
                                        showConfirmButton: false,
                                        timerProgressBar: true,
                                        timer: 3500
                                    });
                                }
                            });
                            // Swal.fire(
                            //     'Deleted!',
                            //     'Your file has been deleted.',
                            //     'success'
                            // )
                        }
                    })
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
            } else {
                // console.log("RID is null");
                removeElementProcedure(elId);
            }
            
        }

        function removeElementProcedure(elmId) {

            var elmntCount = $('.container-item').length;

            if (elmntCount > minColnes) {
                    $('#'+elmId).remove();
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreTodoListRequest', '#update-todo-list'); !!}

@endpush

@endsection
