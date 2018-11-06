@extends('temp')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Tables</h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Tables</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header" style="margin-bottom: 15px">
              <h1 class="card-title">Data Table</h1>
              <button type="button" name="add" id="Tambah" class="btn btn-primary pull-right" style="margin-left: 830px; margin-top: 10px; margin-bottom: 10px">Tambah Data</button>
            </div>
              <div class="panel panel-body">
                 <table id="buku_table" class="table table-bordered" style="width:100%">
                    <thead>
                          <tr>
                          <th>Jenis Buku</th>
                          <th>Judul Buku</th>
                          <th>Pengarang</th>
                          <th>ISBN</th>
                          <th>Tahun Terbit</th>
                          <th>Penerbit</th>
                          <th>Tersedia</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                 </table>
              </div>
            </div>
        </div>
      </div>
    </section>
  </div>
  @endsection
  @push('scripts')

    @include('buku.form')
    <script type="text/javascript">
      $(document).ready(function() {
          //get ke dataTable
          $('#buku_table').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":'{{route('buku')}}',
              "columns":[
                  { "data": "jebu" },
                  { "data": "judul"},
                  { "data": "pengarang"},
                  { "data": "isbn"},
                  { "data": "thn_terbit"},
                  { "data": "penerbit"},
                  { "data": "tersedia"},
                  { "data": "action"}
              ]
          });
           $('#Tambah').click(function(){
              $('#bukuModal').modal('show');
              $('#buku_form')[0].reset();
              $('#action').val('Tambah');
              $('.modal-title').text('Tambah Data');
              state = "insert";
            });
         
         $('.select').select2();
         $('#bukuModal').on('hidden.bs.modal', function(e){
          $(this).find('#buku_form')[0].reset();
          $('span.has-error').text('')
          $('.form-group.has-error').removeClass('has-error');
         });
         
           $('#buku_form').submit(function(e){
             $.ajaxSetup({
                 header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             e.preventDefault();
             if (state == 'insert'){
             $.ajax({
               type: "POST",
               url: "{{url ('bukus')}}",
               // data: $('#buku_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#bukuModal').modal('hide');
                 $('#action').val('Tambah');
                 $('#buku_table').DataTable().ajax.reload();
                    swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
               },
               error: function (data){
                $('input').on('keydown keypress keyup click change', function(){
                  $(this).parent().removeClass('has-error');
                  $(this).next('.help-block').hide()
                });
                var coba = new Array();
                console.log(data.responseJSON.errors);
                $.each(data.responseJSON.errors,function(name, value){
                  console.log(name);
                  coba.push(name);
                  $('input[name='+name+']').parent().addClass('has-error');
                  $('input[name='+name+']').next('.help-block').show().text(value);
                });
                $('input[name='+coba[0]+']').focus();
               }
             }); 
           }else {
            //edit
            $.ajax({
               type: "POST",
               url: "{{url ('/buku/edit')}}"+ '/' + $('#id').val(),
               // data: $('#buku_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#bukuModal').modal('hide');
                 $('#buku_table').DataTable().ajax.reload();
                 swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
               },
               error: function (data){
                $('input').on('keydown keypress keyup click change', function(){
                  $(this).parent().removeClass('has-error');
                  $(this).next('.help-block').hide()
                });
                var coba = new Array();
                console.log(data.responseJSON.errors);
                $.each(data.responseJSON.errors,function(name, value){
                  console.log(name);
                  coba.push(name);
                  $('input[name='+name+']').parent().addClass('has-error');
                  $('input[name='+name+']').next('.help-block').show().text(value);
                });
                $('input[name='+coba[0]+']').focus();
               }
             }); 
           }
        });
          //delete
           $(document).on('click', '.delete', function(){
         var dele = $(this).attr('id');
         if(confirm("Apakah Anda Yakin Menghapus Data Ini?"))
         {
            $.ajax({
                url:"{{route('hapus')}}",
                method:"get",
                data:{id:dele},
                success:function(data)
                {
                  $('#buku_table').DataTable().ajax.reload();
                    swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
         
                }
            })
         }
         else
         {
          swal({
            title: 'Batal',
            text: 'Data tidak jadi dihapus',
            type: 'error'
          })
            return false;
         }
         });
         $(document).on('click', '.edit', function(){
         var edit = $(this).data('id');
         $('#form_output').html('');
         $.ajax({
            url:"{{url('/buku/getedit')}}" + '/' + edit,
            method:'get',
            data:{id:edit},
            dataType:'json',
            success:function(data)
            {
              console.log(data);
                state = "update";
                $('#id').val(data.id);
                $('#judul').val(data.judul);
                $('#pengarang').val(data.pengarang);
                $('#isbn').val(data.isbn);
                $('#thn_terbit').val(data.thn_terbit);
                $('#penerbit').val(data.penerbit);
                $('#tersedia').val(data.tersedia)
                $('.select').select2();
                $('#buku_id').val(edit);
                $('#bukuModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
            },
         })
      });
       });
    </script>
    @endpush