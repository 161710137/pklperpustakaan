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
      <h3 align="center">Datatables</h3>
      <br />
      <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Tambah</button>
      </div>
      <table id="agt_table" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>No Anggota</th>
            <th>Nama Anggota</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
    @include('anggota.form')
    <script type="text/javascript">
      $(document).ready(function() {
          //get ke dataTable
          $('#agt_table').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":'{{route('anggota')}}',
              "columns":[
                  { "data":"id"},
                  { "data": "no_agt" },
                  { "data": "nama_agt"},
                  { "data": "alamat"},
                  { "data": "kota"},
                  { "data": "telp"},
                  { "data": "action"}
              ]
          });
           $('#add_data').click(function(){
              $('#agtModal').modal('show');
              $('#agt_form')[0].reset();
              $('#action').val('Tambah');
              $('.modal-title').text('Tambah Data');
              $('summernote').summernote('reset');
              state = "insert";
            });
         
         $('.select').select2();
         $('#agtModal').on('hidden.bs.modal', function(e){
          $(this).find('#agt_form')[0].reset();
          $('span.has-error').text('')
          $('.form-group.has-error').removeClass('has-error');
         });
         
           $('#agt_form').submit(function(e){
             $.ajaxSetup({
               header: {
                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
               }
             });
             e.preventDefault();
             if (state == 'insert'){
             $.ajax({
               type: "POST",
               url: "{{url ('anggotas')}}",
               // data: $('#agt_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#agtModal').modal('hide');
                 $('#action').val('Tambah');
                 $('#agt_table').DataTable().ajax.reload();
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
               url: "{{url ('/anggota/edit')}}"+ '/' + $('#id').val(),
               // data: $('#agt_form').serialize(),
               data: new FormData(this),
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function (data){
                 console.log(data);
                 $('#agtModal').modal('hide');
                 $('#agt_table').DataTable().ajax.reload();
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
                  $('#agt_table').DataTable().ajax.reload();
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
            url:"{{url('anggota/getedit')}}" + '/' + edit,
            method:'get',
            data:{id:edit},
            dataType:'json',
            success:function(data)
            {
              console.log(data);
                state = "update";
                $('#id').val(data.id);
                $('#no_agt').val(data.no_agt);
                $('#nama_agt').val(data.nama_agt);
                $('#alamat').val(data.alamat);
                $('#kota').val(data.kota);
                $('#telp').val(data.telp);
                $('.select').select2();
                $('#agt_id').val(edit);
                $('#agtModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
            },
         })
      });
    </script>
  </body>
</html>