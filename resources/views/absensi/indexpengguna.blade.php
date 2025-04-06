@extends('masterlayout')

@section('title', 'Absensi Kalender')

@section('content')
<div class="container mt-3">

<div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
    <div class="card-header ">
        <h4>Laporan Absensi Saya</h4>
    </div>
    <div class="card-body">
        

<div id="calendar"></div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        buttonText: {
        today: 'Today' // Mengubah "today" menjadi "Today"
    },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('/absensi/data')
                .then(response => response.json())
                .then(data => {
                    console.log("Data Absensi:", data); // Debugging
                    successCallback(data);
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                    failureCallback(error);
                });
        },
        eventContent: function(arg) {
            let eventTitle = document.createElement('div');
            eventTitle.innerText = arg.event.title;
            eventTitle.style.fontWeight = "bold"; // Menonjolkan teks status
    eventTitle.style.display = "block"; // Memastikan berada dalam satu baris terpisah
    eventTitle.style.cursor = "pointer"; // Mengubah kursor menjadi pointer untuk interaksi
    eventTitle.style.padding = "5px"; // Menambahkan padding agar lebih mudah diklik
    eventTitle.style.borderRadius = "5px"; // Membuat tampilan lebih bagus
            let container = document.createElement('div');
            container.appendChild(eventTitle);

            if (arg.event.extendedProps.status !== "disetujui" && arg.event.title !== "Hadir") {
        eventTitle.onclick = function() {
            let tanggal = arg.event.startStr;
            window.location.href = "/absensi/perizinan?tanggal=" + tanggal;
        };
    }

            return { domNodes: [container] };
        }
    });

    calendar.render();
});
</script>
@endsection
