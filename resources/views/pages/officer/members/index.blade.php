@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <h2>Daftar Anggota</h2>
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="datatable1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>
                                        No Anggota
                                    </th>
                                    <th>
                                        Nama Lengkap
                                    </th>
                                    <th>
                                        Pekerjaan
                                    </th>
                                    <th>
                                        No Handphone
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>
                                            {{ $item->code }}
                                        </td>
                                        <td>
                                            {{ $item->fullname }}
                                        </td>
                                        <td>
                                            {{ $item->job_dept }}
                                        </td>
                                        <td>
                                            {{ $item->phone }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
