@extends('dashboard', ['pageTitle' => 'Notifications &raquo; Index'])

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! Form::open(['url' => 'user/notifications/search', 'method' => 'get']) !!}
                    <input class="form-control form-inline pull-right" name="search" placeholder="Search">
                    {!! Form::close() !!}
                </div>
                <h1 class="pull-left" style="margin: 0;">Notifications</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if ($notifications->isEmpty())
                    <div class="well text-center">No notifications found.</div>
                @else
                    <table class="table table-striped">
                        <thead>
                            <th>Date</th>
                            <th>Flag</th>
                            <th>Headline</th>
                            <th width="150px">Action</th>
                        </thead>
                        <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td><a href="{!! url('user/notifications/'.$notification->uuid.'/read') !!}">{{ $notification->created_at->format('Y-m-d') }}</a></td>
                                <td>{{ ucfirst($notification->flag) }}</td>
                                <td>{{ $notification->title }}</td>
                                <td class="text-right">
                                    <a class="btn btn-danger btn-xs" href="{!! url('user/notifications/'.$notification->id.'/delete') !!}" onclick="return confirm('Are you sure you want to delete this notification?')">
                                        <i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                {!! $notifications; !!}
            </div>
        </div>
    </div>

@stop