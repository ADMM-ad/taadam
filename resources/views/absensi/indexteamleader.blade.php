@extends('masterlayout')


@section('content')
<div class="container mt-3">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>  <!-- Ikon untuk sukses -->
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-warning collapsed-card mt-2">
    <div class="card-header">
    <h3 class="card-title">
    <i class="bi bi-megaphone-fill"></i>
    Instructions
</h3>
        <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
    </div>
    <div class="card-body">
        The body of the card
    </div>
</div>
    <div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
        <div class="card-header ">
            <h4>Laporan Absensi Team</h4>
        </div>
        <div class="card-body">
            <!-- Dropdown untuk memilih karyawan -->
            <div class="form-group">
    <label for="userSelect">Pilih Karyawan:</label>
    <select id="userSelect" class="form-control">
        <option value="">-- Pilih Karyawan --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <div id="calendar"></div>
    </div>
    </div>
</div>
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
            buttonText: {
        today: 'Today' // Mengubah "today" menjadi "Today"
    },
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
