@extends('../../../../templates/layouts')

@section('contents')
  <h2>Simpanan Anda</h2>
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title"> Simpanan Wajib</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table tablesorter " id="datatable1">
              <thead class=" text-primary">
                <tr>
                  <th>
                    Nama
                  </th>
                  <th>
                    Jumlah
                  </th>
                  <th>
                    Deskripsi
                  </th>
                  <th>
                    Status
                  </th>
                  <th>
                    Tanggal
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($savings_wajib as $item)
                  <tr>
                    <td>
                      {{$item->user->name}}
                    </td>
                    <td>
                      Rp. {{number_format($item->amount, 2)}}
                    </td>
                    <td>
                      {{$item->description ?? '-'}}
                    </td>
                    <td>
                      {{$item->status}}
                    </td>
                    <td>
                      {{$item->created_at}}
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
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title"> Simpanan Pokok</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table tablesorter " id="datatable2">
              <thead class=" text-primary">
                <tr>
                  <th>
                    Nama
                  </th>
                  <th>
                    Jumlah
                  </th>
                  <th>
                    Deskripsi
                  </th>
                  <th>
                    Status
                  </th>
                  <th>
                    Tanggal
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($savings_pokok as $item)
                  <tr>
                    <td>
                      {{$item->user->name}}
                    </td>
                    <td>
                      Rp. {{number_format($item->amount, 2)}}
                    </td>
                    <td>
                      {{$item->description ?? '-'}}
                    </td>
                    <td>
                      {{$item->status}}
                    </td>
                    <td>
                      {{$item->created_at}}
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
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title"> Simpanan Sukarela</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table tablesorter " id="datatable3">
              <thead class=" text-primary">
                <tr>
                  <th>
                    Nama
                  </th>
                  <th>
                    Jumlah
                  </th>
                  <th>
                    Deskripsi
                  </th>
                  <th>
                    Status
                  </th>
                  <th>
                    Tanggal
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($savings_sukarela as $item)
                  <tr>
                    <td>
                      {{$item->user->name}}
                    </td>
                    <td>
                      Rp. {{number_format($item->amount, 2)}}
                    </td>
                    <td>
                      {{$item->description ?? '-'}}
                    </td>
                    <td>
                      {{$item->status}}
                    </td>
                    <td>
                      {{$item->created_at}}
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