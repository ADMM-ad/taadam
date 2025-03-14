@extends('masterlayout')

@section('title', 'Absensi Kalender')

@section('content')
    <div id="calendar"></div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
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

            let container = document.createElement('div');
            container.appendChild(eventTitle);

            if (arg.event.extendedProps.status !== "disetujui" && arg.event.title !== "Hadir") {
                let button = document.createElement('button');
                button.innerText = "Ajukan Perizinan";
                button.classList.add("btn", "btn-warning", "btn-sm");
                button.onclick = function() {
                    let tanggal = arg.event.startStr;
                    window.location.href = "/absensi/perizinan?tanggal=" + tanggal;
                };
                container.appendChild(button);
            }

            return { domNodes: [container] };
        }
    });

    calendar.render();
});
</script>
@endsection
