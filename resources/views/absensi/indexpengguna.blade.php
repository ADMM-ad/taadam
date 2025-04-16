@extends('masterlayout')

@section('title', 'Absensi Kalender')

@section('content')
<div class="container mt-3">
<div class="card card-warning collapsed-card mt-2">
    <div class="card-header" style="background-color: #31beb4;">
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
    <div class="card-body" style="background-color: #ffffff;">
    Halaman ini digunakan untuk mengelola dan menampilkan laporan absensi anda.<br><br>

Warna pada kalender memiliki arti sebagai berikut:<br><br>

<span style="color: green; font-weight: bold;">-Hijau</span>: Karyawan dinyatakan hadir, yaitu telah melakukan absen datang dan absen pulang.<br>
<span style="color: blue; font-weight: bold;">-Biru</span>: Karyawan hanya melakukan absen datang, namun belum melakukan absen pulang.<br>
<span style="color: orange; font-weight: bold;">-Oranye</span>: Karyawan mengajukan izin dan telah disetujui.<br>
<span style="color: yellow; font-weight: bold;">-Kuning</span>: Karyawan mengajukan sakit dan telah disetujui.<br>
<span style="color: gray; font-weight: bold;">-Abu-abu</span>: Permintaan izin masih dalam proses, belum disetujui ataupun ditolak.<br>
<span style="color: red; font-weight: bold;">-Merah</span>: Permintaan izin telah ditolak.<br>
<span style="color: black; font-weight: bold;">-Hitam</span>: Tidak terdapat aktivitas absensi pada hari tersebut, bisa disebabkan oleh hari libur atau karyawan tidak masuk tanpa keterangan.
    </div>
</div>
<div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
    <div class="card-header ">
        <h4 class="card-title"><i class="fas fa-calendar-check mr-1" style="color: #31beb4;"></i>Laporan Absensi Saya</h4>
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
