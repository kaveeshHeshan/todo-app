@extends('layouts.app')

@push('custom-styles')

    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <style>
        .dataTables_length,
        .dataTables_filter{
            margin-bottom: 20px !important;
        }
        .dataTables_filter select,
        .dataTables_filter input {
            border-radius: 40px !important;
        }

        .dataTables_info,
        .dataTables_paginate {
            margin-top: 20px !important;
        }
        .btn-icon-only {
            width: 2rem;
            height: 2rem;
            padding: 0;
        }

        a.btn-icon-only {
            line-height: 2.5;
        }

        .btn-icon-only.btn-sm,
        .btn-group-sm>.btn-icon-only.btn {
            width: 2rem;
            height: 2rem;
        }
        .btn-icon-only::after{
            content: '' !important;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card p-3">
                <div class="card-header bg-dark text-white">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>{{\Auth::user()->name ?? 'User'}},</h3>
                    {{ __('Welcome to the TODO Dashboard ') }}{{__('!')}}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 pb-3">
                    <a class="btn btn-success" href="{{ route('todo_lists.create')}}"><i class='bx bx-plus-circle'></i>{{ __(' Add To-Do List') }}</a>
                </div>
                <div class="col-md-12">
                    <div class="card p-4">
                        @if (count($todoLists) > 0)
                            <table id="todo-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col" class="text-center">{{ __('Tasks') }}</th>
                                        <th scope="col">{{ __('') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todoLists as $todoList)
                                        <tr>
                                            <td>{{ $todoList->title ?? '--' }}</td>
                                            <td>{{ $todoList->description ?? '--' }}</td>
                                            <td>
                                                <ul>
                                                    @if (count($todoList->tasksData) > 0)
                                                        @foreach ($todoList->tasksData as $task)
                                                            <li>{{ $task->title ?? '--'}}</li>
                                                        @endforeach
                                                    @else
                                                        <li>{{ __('No tasks added for this To-Do list.') }}</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-icon-only text-dark" style="background: transparent; outline: none; border: none;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class='bx bx-dots-vertical-rounded' style="font-size: 17px;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu float-left" aria-labelledby="dropdownMenuButton1">
                                                      <li><a class="dropdown-item" href="{{route('todo_lists.show', $todoList->id)}}"><ion-icon name="eye-outline"></ion-icon> {{__('View')}}</a></li>
                                                      <li><a class="dropdown-item" href="{{route('todo_lists.edit', $todoList->id)}}"><i class='bx bx-edit-alt' ></i> {{__('Edit')}}</a></li>
                                                      <li><a class="dropdown-item text-danger" href="#"><i class='bx bx-trash' ></i> {{__('Remove')}}</a></li>
                                                    </ul>
                                                  </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>{{ __('No To-Do List found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        $(document).ready(function () {
            $('#todo-table').DataTable({
                responsive: true,
                language: {
                    oPaginate: {
                        sNext: '<i class="bx bxs-chevron-right"></i>',
                        sPrevious: '<i class="bx bxs-chevron-left"></i>',
                        sFirst: '<i class="bx bxs-chevrons-right"></i>',
                        sLast: '<i class="bx bxs-chevrons-left"></i>'
                    }
                }
            });
        });
    </script>
@endpush

@endsection
