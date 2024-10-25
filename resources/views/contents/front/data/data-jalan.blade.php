@extends('layouts.frontend.home.home')
@php
    $plugins = ['select2'];
@endphp


@section('contents')
    <!-- Hero Start -->
    <section class="bg-home bg-primary d-flex align-items-center"
        style="background: url('{{ asset('img/hero-background.png') }}') center; height: auto; height: 30vh; background-repeat: no-repeat; opacity: 2.2;"
        id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center mt-0 pt-0">
                    <div class="title-heading">
                        <h2 class="title text-white title-dark m-0 p-0 text-uppercase">
                           {{ $title}}
                        </h2>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

            <div class="position-breadcrumb">
                <nav aria-label="breadcrumb" class="d-inline-block">
                    <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">Beranda</a></li>
                        <!-- <li class="breadcrumb-item"><a href="#">Menu</a></li> -->
                        <li class="breadcrumb-item active" aria-current="page">Data Jalan</li>
                    </ul>
                </nav>
            </div>
        </div>
        <!--end container-->
    </section>
    <!--end section-->

    <div class="position-relative">
        <div class="shape overflow-hidden text-color-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="col-6">

                <div class="row p-2">
                    <div class="col-4 form-group">
                        <label for="filter-kec">Kecamatan</label>
                        <select class="form-control" id="filter-kec">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($ref_kec as $row)
                                <option value="{{ $row->id_kecamatan }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="filter-kel">Kelurahan</label>
                        <select class="form-control" id="filter-kel"></select>
                    </div>

                </div>

            </div>
            <table id="table-data" class="table table-striped table-bordered" style="width: 100%">
                <thead>
                    <tr>
                        <th style="border-top-left-radius: 8px">No</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Nama Jalan</th>
                        <th>Kategori</th>
                        <th>Jenis perk</th>
                        <th style="border-top-right-radius: 8px">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.ref_kec = @json($ref_kec);
        window.ref_kel = @json($ref_kel);
    </script>
    <script>
        let table;

        $(document).ready(function() {

            table = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('data-jalan.data') }}',
                    type: "get",
                    dataType: "json",
                    data: function(d) {
                        d.kode_kec = $('#filter-kec').val();
                        d.kode_kel = $('#filter-kel').val();
                    },
                },
                ordering: false,
                columnDefs: [{
                    targets: [0, 2],
                    searchable: false,
                    orderable: false,
                }, ],
                columns: [{
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'kec.nama'
                    },
                    {
                        data: 'kel.nama'
                    },
                    {
                        data: 'Nama_Jalan'
                    },
                    {
                        data: 'Kategori'
                    },
                    {
                        data: 'Jenis_Perk'
                    },
                    {
                        data: 'id',
                        render: (data, type, row) => {
                            const buttonDetail = $('<a>', {
                                class: 'btn btn-info btn-detail',
                                'data-id': data,
                                title: 'Detail',
                                'data-placement': 'top',
                                'data-toggle': 'tooltip',   
                                href: '{{ url('detail-jalan') }}/' + data,
                                role: 'button',
                                html: '<i class="bx bx-eye"></i> Detail'
                            });

                            return $('<div>', {
                                class: 'd-flex justify-content-center align-items-center', // Bootstrap classes for centering
                                style: 'height: 100%;', // Specify a fixed height to keep the button size constant
                                html: buttonDetail
                            }).prop('outerHTML');
                        }
                    }
                ]
            });

            $(() => {
                $('#filter-kec').trigger('change');
            });

            $('#filter-kec').on('change', (e) => {
                let kel = ref_kel.filter(o => {
                    return o.id_kecamatan == e.target.value;
                });
                let select_kel = $('#filter-kel');
                select_kel.empty();
                select_kel.append(new Option('Semua Kelurahan', ''));
                for (const i of kel) {
                    select_kel.append(new Option(i.nama, i.id_kelurahan));
                }
                select_kel.trigger('change');
                return;
            });

            $('#filter-kel').on('change', (e) => {
                if (typeof table != 'undefined') table.draw();
                else load_table();
                return;
            });
        });
    </script>
@endpush
