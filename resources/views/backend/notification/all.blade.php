@extends('boilerplate::layout.index', [
    'title' => 'All Notifications',
    'subtitle' => 'Your Notifications',
])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">All Notifications</h4>
            @if($notifications->count())
                <ul class="list-group mb-3">
                    @foreach($notifications as $notification)
                        <li class="list-group-item {{ $notification->read_at ? 'text-muted' : 'font-weight-bold' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{!! $notification->data['message'] ?? $notification->data['title'] ?? 'Notification' !!}</span>
                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if($notification->read_at)
                                <span class="badge badge-secondary">Read</span>
                            @else
                                <span class="badge badge-primary">Unread</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="alert alert-info">No notifications found.</div>
            @endif
        </x-boilerplate::card>
    </div>
</div>
@endsection
