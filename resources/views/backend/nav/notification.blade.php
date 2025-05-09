<!-- Navbar -->
<li class="nav-item dropdown">
  <a class="nav-link" data-toggle="dropdown" href="#" id="notificationToggle">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge" id="notifCount">0</span>
  </a>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifDropdown">
    <span class="dropdown-header">No notification...</span>
  </div>
</li>


@push('js')
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<script>
function humanTime(timestamp) {
    return moment(timestamp).fromNow(); // requires moment.js
}

function loadNotifications() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('notifDropdown');
            const count = document.getElementById('notifCount');
            container.innerHTML = '';
            count.innerText = data.unread_count;

            // Show unread
            if (data.unread.data.length) {
                container.innerHTML += `<span class="dropdown-header">${data.unread.total} New Notifications</span>`;
                data.unread.data.forEach(notif => {
                    container.innerHTML += `
                    <div class="dropdown-divider"></div>
                    <a href="${notif.data.url}" class="dropdown-item mark-read-link" data-id="${notif.id}">
                        <i class="fas fa-info-circle mr-2"></i> ${notif.data.message}
                        <span class="float-right text-muted text-sm">${humanTime(notif.created_at)}</span>
                    </a>`;
                });
            }

            // Show read
            if (data.read.data.length) {
                container.innerHTML += `<div class="dropdown-divider"></div><span class="dropdown-header">Earlier</span>`;
                data.read.data.forEach(notif => {
                    container.innerHTML += `
                    <div class="dropdown-divider"></div>
                    <a href="${notif.data.url}" class="dropdown-item">
                        <i class="fas fa-clock mr-2 text-muted"></i> ${notif.data.message}
                        <span class="float-right text-muted text-sm">${humanTime(notif.created_at)}</span>
                    </a>`;
                });
            }

            if (data.unread_count > 0) {
                container.innerHTML += `<div class="dropdown-divider"></div>
                <a href="{{ route('backend.notifications.all') }}" class="dropdown-item dropdown-footer">See all notifications</a>
                <a href="#" class="dropdown-item dropdown-footer" id="markAllRead">Mark all as read</a>`;
            } else {
                container.innerHTML += `<div class="dropdown-divider"></div>
                <a href="{{ route('backend.notifications.all') }}" class="dropdown-item dropdown-footer">See all notifications</a>
                <a href="#" class="dropdown-item dropdown-footer">All notifications read</a>`;
            }
        });
}

// Polling interval based on environment
const isLiveServer = {{ config('app.live_server') ? 'true' : 'false' }};
const pollingInterval = isLiveServer ? 1000 : 30000; // 1 second for live server, 30 seconds otherwise
setInterval(loadNotifications, pollingInterval);

// Load initially
document.addEventListener("DOMContentLoaded", function () {
    loadNotifications();

    document.body.addEventListener('click', function (e) {
        // Mark all as read
        if (e.target.id === 'markAllRead') {
            e.preventDefault();
            fetch('/notifications/mark-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(() => loadNotifications());
        }

        // Mark single notification as read (works for notifications with or without a link)
        if (e.target.classList.contains('mark-read-link')) {
            e.preventDefault();
            const notifId = e.target.getAttribute('data-id');
            const notifUrl = e.target.getAttribute('href');
            fetch(`/notifications/mark-read/${notifId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => {
                if (notifUrl && notifUrl !== '#') {
                    window.location.href = notifUrl;
                } else {
                    loadNotifications();
                }
            });
        }
    });
});
</script>

@endpush