@extends('layout.master')

@section('judul')
    Jadwal Booking
@endsection

@section('content')
    @php
        $resources = [];
        $events = [];
        foreach ($lapangan as $lapang) {
            array_push($resources, [
                'id' => 'lapangan-' . $lapang->id,
                'title' => $lapang->nama,
            ]);
        }
        foreach ($booking as $book) {
            array_push($events, [
                'id' => $book->id,
                'resourceId' => 'lapangan-' . $book->lapangan_id,
                'title' => $book->user->name . " ($book->jam jam)<br>{$book->lapangan->nama}",
                'start' => $book->time_from,
                'end' => $book->time_to,
            ]);
        }
    @endphp
    <style>
        .list-bullets {
            list-style: none;
        }

        .list-bullets li {
            display: flex;
            align-items: center;
        }

        .list-bullets li::before {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #5784d7;
            border: 2px solid #8fb3f5;
            display: block;
            margin-right: 1rem;
        }

        /* Unordered list with custom numbers style */
        ol.custom-numbers {
            list-style: none;
        }

        ol.custom-numbers li {
            counter-increment: my-awesome-counter;
        }

        ol.custom-numbers li::before {
            content: counter(my-awesome-counter) ". ";
            color: #2b90d9;
            font-weight: bold;
        }


        /*
                            *
                            * ==========================================
                            * FOR DEMO PURPOSES
                            * ==========================================
                            *
                            */

        li {
            font-style: italic;
        }
    </style>
    <center>
        <h1>Booking Futsal</h1>
        <span>Klik tanggal untuk booking</span>

    </center>
    <div id='calendar'></div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($data->status == 'Tidak Aktif')
                                <div class="modal-body">
                                    <h3>Lapangan Tutup</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="modal-body">
                        @if (auth()->user()->type == 'user')
                            <form action="{{ url('booking/create')}}" method="POST">
                        @endif
                            @if (auth()->user()->type == 'admin')
                                <form action="{{ url('bookingadmin/create')}}" method="POST">
                            @endif
                                @csrf
                                <div class="col-xxl">
                                    <div class="card mb-5">
                                        <div class="card-body">
                                            <h4 class="mb-4">Keterangan Harga</h4>
                                            <!-- List with bullets -->
                                            <p class='badge badge-warning'>Futsal</p>
                                            <ul class="list-bullets">
                                                <li class="mb-2"> Siang : @currency($data->harga)</li>
                                                <li class="mb-2"> Malam : @currency($data->harga + 40000)</li>

                                            </ul>
                                            <p class='badge badge-warning'>Bulu Tangkis</p>
                                            <ul class="list-bullets">
                                                <li class="mb-2"> Siang dan malam : @currency(30000)</li>


                                            </ul>


                                            <label for="lapangan_id">Lapangan</label>
                                            <select name="lapangan_id" id="lapangan_id" class="form-control">
                                                @foreach ($lapangan as $item)
                                                    <option data-value="{{$item}}" value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('lapangan_id')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-group mb-2">
                                                <label for="time_from">Jam Mulai</label>
                                                <input type="text" class="form-control datetimepicker" id="time_from" name="time_from"
                                                    value="{{ old('time_from') }}" />
                                                @error('time_from')
                                                    <div class="alert alert-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="time_to">Jam Berakir</label>
                                                <input type="text" class="form-control datetimepicker" id="time_to" name="time_to"
                                                    value="{{ old('time_to') }}" />
                                                @error('time_to')
                                                    <div class="alert alert-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <label for="total" id="total" class="">Total Bayar : <span
                                                    id="totalbayar">@currency($data->harga)</span></label>

                                            <div class="row p-2">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                @endif

    </div>
    </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/id.js"></script>
    <script>
        let textharga = {{$data->harga}};
        let lapanganNama = "{{$lapangan[0]->nama}}";
        console.log(lapanganNama);

        document.addEventListener('DOMContentLoaded', function () {

            $("#lapangan_id").on('change', function () {
                let selectedOption = $(this).find(":selected").data("value");
                console.log(selectedOption);
                let harga = selectedOption.harga;
                textharga = harga;
                lapanganNama = selectedOption.nama;
                $('#totalbayar').html(`Rp. ${harga.toLocaleString()}`);

            });



            if (@js($errors->any())) {
                $('#exampleModal').modal('show');
            }

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                // resources: @js($resources),
                events: @js($events),
                eventContent: function (arg) {
                    // Ambil data dari extendedProps
                    let detail = arg.event.extendedProps || {};
                    console.log(arg.event.jam);
                    // Format tanggal mulai
                    let startDate = new Date(arg.event.start);
                    let endDate = new Date(arg.event.end);

                    let formattedStart = startDate.toLocaleString("id-ID", {

                        hour: "2-digit",
                        minute: "2-digit"
                    });
                    let formattedEnd = endDate.toLocaleString("id-ID", {

                        hour: "2-digit",
                        minute: "2-digit"
                    });

                    // Format HTML dengan list
                    let content = `
                                    <div style="padding: 4px;">
                                        <ul style="padding-left: 16px; margin: 4px 0; list-style-type: disc;">
                                            <li>
                                                <strong>${arg.event.title}</strong> <!-- Nama User + Jam -->
                                                <p>${formattedStart} - ${formattedEnd}</p>

                                            </li>
                                        </ul>
                                    </div>
                                `;

                    return { html: content }; // Render sebagai HTML
                },
                eventTimeFormat: { // Format waktu menjadi 12 jam dengan AM/PM
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short' // Menampilkan AM/PM
                },
                dateClick: function (info) {
                    if ((new Date(info.dateStr)).getTime() <= (new Date()).setHours(0)) {
                        return;
                    }
                    $('#time_from').val(info.dateStr);
                    $('#time_to').val(info.dateStr);
                    $('#exampleModal').modal('toggle');
                }
            });

            calendar.render();
        });
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:00',
            locale: 'id',
            sideBySide: true,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
            },
            minDate: new Date,
            stepping: 10,
            disabledHours: [0, 1, 2, 3, 4, 5, 6]
        });
        $('.datetimepicker').on('dp.change', e => {
            const timefrom = moment($('#time_from').val());
            const timeto = moment($('#time_to').val());


            const start = +timefrom.format('H');
            const end = +timeto.format('H');

            const harga = textharga;

            let total = 0;
            for (let i = start; i < end; i++) {
                if (lapanganNama == 'Lapangan Futsal') {

                    if (i < 17) {
                        total += +harga;
                    } else {
                        total += (+harga + 40000);
                    }
                } else {
                    total += +harga;
                }
            }

            $('#totalbayar').text('Rp. ' + Intl.NumberFormat().format(total));
            $('#dp').text('Rp. ' + Intl.NumberFormat().format(total / 2));
        })
    </script>
@endsection