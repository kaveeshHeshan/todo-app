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
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>{{ __('Name :') }}</b>&nbsp; {{$todoList->title ?? '--'}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>{{ __('Description :') }}</b>&nbsp;{{$todoList->description ?? '--'}}</p>
                        </div>
                    </div>
                    <br>
                    <div class="row px-2">
                        <h6><b>{{ __('Tasks') }}</b></h6>
                        <hr>
                        @if (count($todoList->tasksData) > 0)
                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">{{ __('Name :') }}</th>
                                <th scope="col">{{ __('Due Date :') }}</th>
                                <th scope="col">{{ __('Due Time :') }}</th>
                                <th scope="col">{{ __('Status :') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($todoList->tasksData as $task)
                                    <tr>
                                        @php
                                            $formattedDate = \Carbon\Carbon::parse($task->due_date)->format('m-d-Y');
                                            $formattedTime = \Carbon\Carbon::parse($task->due_time)->format('h:i A');
                                        @endphp
                                        <td>{{$task->title ?? '--'}}</td>
                                        <td>{{$formattedDate ?? '--'}}</td>
                                        
                                        <td>{{ $formattedTime ?? '--'}}</td>
                                        <td style="text-transform: capitalize;">{{$task->status ?? '--'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        @else
                            <h5>{{ __('No Tasks assigned to this Todo list') }}</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

@endpush

@endsection
