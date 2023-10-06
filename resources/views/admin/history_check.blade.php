
@extends('templateAdmin')
@section('content')
<!-- Default box -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Judul</th>
            <th>Abstraksi</th>
            <th>Persentase Judul</th>
            <th>Persentase Abstraksi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('data/datatables-admin') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'judul', name: 'judul' },
                { data: 'abstraksi', name: 'abstraksi' },
                { data: 'persentase_judul', 
                  name: 'persentase_judul',
                  render: function(data, type, full, meta) {
                    return data + " %";
                } 
                
                },
                { data: 'persentase_abstraksi', 
                  name: 'persentase_abstraksi',
                  render: function(data, type, full, meta) {
                    return data + " %";
                } 
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: true,
                    render: function(data, type, full, meta) {
                        return data;
                    }
                }
            ]
        });
    });
</script>


@endsection

  