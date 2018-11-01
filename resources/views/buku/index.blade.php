<!DOCTYPE html>
<html>
  <head>
    <title>Datatables</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <h3 align="center">Datatables</h3>
      <br />
      <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Tambah</button>
      </div>
      <table id="buku_table" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
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
    @include('buku.form')
    <script type="text/javascript">
      $(document).ready(function() {
          //get ke dataTable
          $('#buku_table').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":'{{route('buku')}}',
              "columns":[
                  { "data":"id"},
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
           $('#add_data').click(function(){
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
              type: "POST",
                 headers: {
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
                  $('#buku_table').DataTable().ajax.reload();
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
         $(document).on('click', '.edit', function(){
         var edit = $(this).data('id');
         $('#form_output').html('');
         $.ajax({
            url:"{{url('buku/getedit')}}" + '/' + edit,
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
  </body>
</html>