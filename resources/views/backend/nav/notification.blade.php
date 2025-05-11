<!-- Navbar -->

<style>
  #notifDropdown {
    max-width: 300px; /* Set a maximum width for the dropdown */
    word-wrap: break-word; /* Ensure long text wraps to the next line */
    white-space: normal !important; /* Force text to wrap */
    overflow-wrap: break-word; /* Break words if necessary */
    max-height: 400px; /* Limit the height of the dropdown */
    overflow-y: auto; /* Add vertical scrolling only for the content */
  }

  .dropdown-item {
    display: flex; /* Use flexbox for better alignment */
    flex-wrap: wrap; /* Allow text to wrap to the next line */
    align-items: flex-start; /* Align items at the start vertically */
    word-break: break-word; /* Break long words to prevent overflow */
    white-space: normal !important; /* Force text to wrap */
  }
</style>
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
<script>
function humanTime(timestamp) {
    const now = new Date();
    const time = new Date(timestamp);
    const diff = Math.floor((now - time) / 1000); // Difference in seconds

    if (diff < 60) return `${diff} seconds ago`;
    if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
    if (diff < 2592000) return `${Math.floor(diff / 86400)} days ago`;

    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
    return time.toLocaleString('en-US', options);
}

function loadNotifications() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('notifDropdown');
            const count = document.getElementById('notifCount');
            container.innerHTML = '';
            count.innerText = data.unread_count;

            // Toggle badge visibility based on count
            if (data.unread_count > 0) {
                count.style.display = 'inline';
            } else {
                count.style.display = 'none';
            }

            // Show unread
            if (data.unread.data.length) {
                container.innerHTML += `<span class="dropdown-header">${data.unread.total} New Notifications</span>`;
                data.unread.data.forEach(notif => {
                    const iconClass = notif.data.icon ? notif.data.icon : 'fas fa-bell';
                    container.innerHTML += `
                    <div class="dropdown-divider"></div>
                    <a href="${notif.data.url}" class="dropdown-item mark-read-link" data-id="${notif.id}">
                        <i class="${iconClass} mr-2"></i> ${notif.data.message}
                        <span class="float-right text-muted text-sm">${humanTime(notif.created_at)}</span>
                    </a>`;
                });
            }

            // Show read
            if (data.read.data.length) {
                container.innerHTML += `<div class="dropdown-divider"></div><span class="dropdown-header">Earlier</span>`;
                data.read.data.forEach(notif => {
                    const iconClass = notif.data.icon ? notif.data.icon : 'fas fa-bell';
                    container.innerHTML += `
                    <div class="dropdown-divider"></div>
                    <a href="${notif.data.url}" class="dropdown-item">
                        <i class="${iconClass} mr-2 text-muted"></i> ${notif.data.message}
                        <span class="float-right text-muted text-sm">${humanTime(notif.created_at)}</span>
                    </a>`;
                });
            }

            if (data.unread_count > 0) {
                container.innerHTML += `<div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer bg-warning text-center d-flex justify-content-center" id="markAllRead">Mark all as read</a>
                <a href="{{ route('backend.notifications.all') }}" class="dropdown-item dropdown-footer bg-danger text-center d-flex justify-content-center">See all notifications</a>`;
            } else {
                container.innerHTML += `<div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer bg-success text-center d-flex justify-content-center">All notifications read</a>
                <a href="{{ route('backend.notifications.all') }}" class="dropdown-item dropdown-footer bg-danger text-center d-flex justify-content-center">See all notifications</a>`;
            }
        });
}

// Polling interval based on environment
if (typeof isLiveServer === 'undefined') {
    const isLiveServer = {{ config('app.live_server') ? 'true' : 'false' }};
    const pollingInterval = isLiveServer ? 1000 : 30000; // 1 second for live server, 30 seconds otherwise
    setInterval(loadNotifications, pollingInterval);
}

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