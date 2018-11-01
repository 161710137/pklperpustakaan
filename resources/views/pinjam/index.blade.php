<!DOCTYPE html>
<html>
  <head>
    <title>Datatables</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  </head>
  <body>
    <div class="container">
      <br />
      <h3 align="center">Datatables Peminjaman Kembali</h3>
      <br />
      <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Tambah</button>
      </div>
      <table id="pinjam_table" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>No Anggota</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam Buku</th>
            <th>Tanggal Harus Kembali</th>
            <th>Denda</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
    @include('pinjam.form')
    <script type="text/javascript">
      $(document).ready(function() {
          //get ke dataTable
          $('#pinjam_table').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":'{{route('pinjam')}}',
              "columns":[
                  { "data":"id"},
                  { "data": "nopjkb"},
                  { "data": "id_agt" },
                  { "data": "id_buku"},
                  { "data": "tgl_pjm"},
                  { "data": "tgl_hrs_kbl"},
                  { "data": "denda"},
                  { "data": "action"}
              ]
          });
           $('#add_data').click(function(){
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
                 $('#pinjam').DataTable().ajax.reload();
                    swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '3500'
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
                 $('#pinjam').DataTable().ajax.reload();
                 swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '3500'
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
                url:"{{route('delete')}}",
                method:"get",
                data:{id:dele},
                success:function(data)
                {
                  $('#pinjam').DataTable().ajax.reload();
                    swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '3500'
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
                $('#tgl_pjm').val(data.tgl_pjm);
                $('#tgl_hrs_kbl').val(data.tgl_hrs_kbl);
                $('#denda').val(data.denda);
                $('.select').select2();
                $('#pin_id').val(edit);
                $('#pinModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
            },
         })
      });
    </script>
  </body>
</html>