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
                 <table id="pinjam_table" class="table table-bordered" style="width:100%">
                    <thead>
                            <th>Id</th>
                            <th>No Pinjam</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam Buku</th>
                            <th>Tanggal Harus Kembali</th>
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

    @include('pinjam.form')
    <script type="text/javascript">
      $(document).ready(function() {
          //get ke dataTable
          $('#pinjam_table').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":'{{route('pinjam')}}',
              "columns":[
                
            { data: 'id', name: 'id' },
            { data: 'nopjkb', name: 'nopjkb' },
            { data: 'anggota', name: 'anggota' },
            { data: 'buku', name: 'buku' },
            { data: 'tgl_pjm', name: 'tgl_pjm' },
            { data: 'tgl_hrs_kbl', name: 'tgl_hrs_kbl' },
            { data: 'action', orderable:false, searchable: false}
              ]
          });
           $('#Tambah').click(function(){
              $('#pinModal').modal('show');
              $('#pin_form')[0].reset();
              $('#action').val('Tambah');
              $('.modal-title').text('Tambah Data');
              state = "insert";
            });
         
         $('.select').select2();
         $('#pinModal').on('hidden.bs.modal', function(e){
          $(this).find('#pin_form')[0].reset();
          $('span.has-error').text('')
          $('.form-group.has-error').removeClass('has-error');
         });
         
           $('#pin_form').submit(function(e){
             $.ajaxSetup({
               header: {
                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
               }
             });
             e.preventDefault();
             if (state == 'insert'){
             $.ajax({
               type: "POST",
               url: "{{url ('pinjams')}}",
               // data: $('#pin_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#pinModal').modal('hide');
                 $('#action').val('Tambah');
                 $('#pinjam_table').DataTable().ajax.reload();
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
               url: "{{url ('/pinjam/edit')}}"+ '/' + $('#id').val(),
               // data: $('#pin_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#pinModal').modal('hide');
                 $('#pinjam_table').DataTable().ajax.reload();
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
         $(document).on('click', '.edit', function(){
         var edit = $(this).data('id');
         $('#form_output').html('');
         $.ajax({
            url:"{{url('pinjam/getedit')}}" + '/' + edit,
            method:'get',
            data:{id:edit},
            dataType:'json',
            success:function(data)
            {
              console.log(data);
                state = "update";
                $('#id').val(data.id);
                $('#nopjkb').val(data.nopjkb);
                $('#id_agt').val(data.id_agt);
                $('#id_buku').val(data.id_buku);
                // $('#tgl_pjm').val(data.tgl_pjm);
                // $('#tgl_hrs_kbl').val(data.tgl_hrs_kbl);
                $('.select').select2();
                $('#pin_id').val(edit);
                $('#pinModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
            },
          })
         });
       });
    </script>
@endpush  