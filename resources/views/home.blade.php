@extends('layouts.app')

@push('custom-styles')

    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    
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
                    {{ __('Welcome to the TODO Dashboard ') }}{{\Auth::user()->name ?? 'User'}}{{__('!')}}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 pb-3">
                    <a class="btn btn-success" href="{{ route('todo_lists.create')}}"><i class='bx bx-plus-circle'></i>{{ __(' Add To-Do List') }}</a>
                </div>
                <div class="col-md-12">
                    <div class="card p-4">
                        <table id="todo-table" class="table table-hover">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                              </tr>
                              <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    
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
