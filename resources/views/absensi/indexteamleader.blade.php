@extends('masterlayout')


@section('content')
    <h2>Absensi Karyawan</h2>

    <!-- Dropdown untuk memilih user -->
    <label for="userSelect">Pilih Karyawan:</label>
    <select id="userSelect" class="form-control">
        <option value="">-- Pilih Karyawan --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <div id="calendar" style="margin-top: 20px;"></div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var userSelect = document.getElementById('userSelect');
    var calendar;

    function initCalendar(events = []) {
        if (calendar) {
            calendar.destroy();
        }
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            eventClick: function(info) {
                var userId = userSelect.value;
                var clickedDate = info.event.startStr;
                if (userId) {
                    window.location.href = `/absensi/edit?user_id=${userId}&tanggal=${clickedDate}`;
                }
            },
            eventContent: function(arg) {
                let eventTitle = document.createElement('div');
                eventTitle.innerText = arg.event.title;
                eventTitle.style.fontWeight = "bold";
                eventTitle.style.padding = "5px";
                eventTitle.style.borderRadius = "5px";

                let container = document.createElement('div');
                container.appendChild(eventTitle);
                return { domNodes: [container] };
            }
        });

        calendar.render();
    }

    // Load kalender kosong saat halaman pertama kali dibuka
    initCalendar([]);

    function loadAbsensi(userId) {
        if (userId) {
            fetch(`/absensi/datapimpinan?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    initCalendar(data);
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        } else {
            initCalendar([]);
        }
    }

    userSelect.addEventListener('change', function () {
        loadAbsensi(this.value);
        updateURL(this.value);
    });

    // Fungsi untuk memperbarui URL dengan user yang dipilih
    function updateURL(userId) {
        const url = new URL(window.location);
        url.searchParams.set('selected_user', userId);
        window.history.replaceState({}, '', url);
    }

    // Ambil selected_user dari URL untuk mempertahankan pilihan setelah redirect
    const urlParams = new URLSearchParams(window.location.search);
    const selectedUser = urlParams.get('selected_user');

    if (selectedUser) {
        userSelect.value = selectedUser; // Set dropdown ke user yang sebelumnya dipilih
        loadAbsensi(selectedUser);
    }
});
</script>

@endsection
