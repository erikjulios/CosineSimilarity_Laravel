
@extends('template')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<!-- Default box -->
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
            ajax: "{{ url('data/datatables') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'judul', name: 'judul' },
                { data: 'abstraksi', name: 'abstraksi' },
                { data: 'persentase_judul', 
                  name: 'persentase_judul',
                  render: function(data, type, full, meta) {
                    var link = '<a href="{{ url('detail_persentases_judul') }}/' + full.id + '">' + data + ' %</a>';
                        return link;
                } 
                },
                { data: 'persentase_abstraksi', 
                  name: 'persentase_abstraksi',
                  render: function(data, type, full, meta) {
                    var link = '<a href="{{ url('detail_persentases_abstrak') }}/' + full.id + '">' + data + ' %</a>';
                        return link;
                } 
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return data;
                    }
                }
            ]
        });
    });
</script>


@endsection

  