<div id="pinModal" class="modal fade" role="dialog" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" id="pin_form" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('POST') }}
                  <div class="modal-header" style="background-color: lightblue;">
                     <button type="button" class="close" data-dismiss="modal" >&times;</button>
                     <h4 class="modal-title" >Tambah Data</h4>
                  </div>
                  <div class="modal-body">                     
                     <span id="form_output"></span>
                     <input type="hidden" name="id" id="id">
                     <div class="form-group">
                        <label>No Pinjam Kembali  :</label>
                        <input type="text" name="nopjkb" id="nopjkb" class="form-control" placeholder="Masukan No Pinjam Kembali" />
                        <span class="help-block has-error nopjkb_error"></span>
                     </div>
                     <div class="form-group {{ $errors->has('id_agt') ? 'has-error' : '' }}">
                        <label>Nama Anggota :</label>
                        <select class="form-control select-dua" name="id_agt" id="id_agt" style="width: 468px">
                           <option disabled selected>Pilih Nama Anggota</option>
                           @foreach($anggota as $data)
                           <option value="{{$data->id}}">{{$data->nama_agt}}</option>
                           @endforeach
                        </select>
                        <span class="help-block has-error nama_agt_error">
                  </div>
                     <div class="form-group {{ $errors->has('id_buku') ? 'has-error' : '' }}">

                     <label>Judul Buku :</label>
                     <select class="form-control select-dua" name="id_buku" id="id_buku" style="width: 468px">
                        <option disabled selected>Pilih Judul Buku</option>
                        @foreach($buku as $data)
                        <option value="{{$data->id}}">{{$data->judul}}</option>
                        @endforeach
                     </select>
                     <span class="help-block has-error judul_error">
                  </div>
                     <div class="form-group">
                        <label>Tanggal Pinjam Buku :</label>
                        <input type="date" name="tgl_pjm" id="tgl_pjm" class="form-control"  value="{{ carbon\carbon::today()->toDateString() }}" readonly placeholder="Masukan Nama Pengarang Buku" />
                        <span class="help-block has-error tgl_pjm_error"></span>
                     </div>
                     <div class="form-group">                       
                            <label>Tanggal harus kembali</label>
                            <input type="date" name="tgl_hrs_kbl" id="tgl_hrs_kbl" class="form-control" value="{{ carbon\carbon::now()->addDays(2)->toDateString() }}" readonly/>
                            <span class="help-block has-error tgl_hrs_kbl_error"></span>
                     </div>
                  <div class="modal-footer">
                    <input type="hidden" name="pin_id" id="pin_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  </div>
               </form>
            </div>
         </div>
      </div>