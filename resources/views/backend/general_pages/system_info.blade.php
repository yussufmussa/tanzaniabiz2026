@extends('backend.layouts.base')
@section('title', 'System Info')

@section('contents')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope mr-2"></i>
                            System Info
                        </h3>
                    </div>

                    <table class="table text-center">
                        <tbody>
                        @foreach($systemInfo as $key => $info)
                        <tr>
                            <td><strong>{{$key}}</strong></td>
                            <td>{{$info}}</td>
                        </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
                    
            </div>
        </div>
@endsection

