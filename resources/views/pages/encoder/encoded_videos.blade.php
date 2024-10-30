@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Encoded Videos</li>
        </ol>
    </nav>
    {{--St--}}
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Encoded Videos</h4>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-table">
                            <thead>
                            <tr>
                                <th>
                                    Video Id
                                </th>
                                <th>
                                    File Name
                                </th>
                                <th>
                                    Video Formats
                                </th>
                                <th>
                                    Destination Path
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($videos) > 0)
                                @foreach($videos as $video)
                                    <tr>
                                        <td>
                                            {{ $video->video_id }}
                                        </td>
                                        <td>
                                            {{ $video->file_name }}
                                        </td>
                                        <td>
                                            {{ implode(', ', json_decode($video->video_formats)) }}
                                        </td>
                                        <td>
                                            {{ $video->destination_path }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No video encoded yet.!</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush

