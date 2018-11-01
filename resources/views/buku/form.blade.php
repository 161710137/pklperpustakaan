<div id="bukuModal" class="modal fade" role="dialog" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" id="buku_form" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('POST') }}
                  <div class="modal-header" style="background-color: lightblue;">
                     <button type="button" class="close" data-dismiss="modal" >&times;</button>
                     <h4 class="modal-title" >Add Data</h4>
                  </div>
                  <div class="modal-body">                     
                     <span id="form_output"></span>
                     <input type="hidden" name="id" id="id">
                     <div class="form-group {{ $errors->has('id_jb') ? 'has-error' : '' }}">

                     <label>Jenis Buku</label>
                     <select class="form-control select-dua" name="id_jb" id="id_jb" style="width: 468px">
                        <option disabled selected>Pilih Jenis Buku</option>
                        @foreach($buku as $data)
                        <option value="{{$data->id}}">{{$data->jenis}}</option>
                        @endforeach
                     </select>
                     <span class="help-block has-error jenis_error">
                  </div>
                     <div class="form-group">
                        <label>Judul Buku :</label>
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Nama Judul Buku" />
                        <span class="help-block has-error judul_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Pengarang :</label>
                        <input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Masukan Nama Pengarang Buku" />
                        <span class="help-block has-error pengarang_error"></span>
                     </div>
                     <div class="form-group">
                        <label>ISBN :</label>
                        <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukan ISBN Buku" />
                        <span class="help-block has-error isbn_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Tahun Terbit  :</label>
                        <input type="text" name="thn_terbit" id="thn_terbit" class="form-control" placeholder="Masukan Tahun Terbit Buku" />
                        <span class="help-block has-error thn_terbit_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Penerbit :</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control" placeholder="Masukan Penerbit Buku" />
                        <span class="help-block has-error penerbit_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Tersedia :</label>
                        <input type="text" name="tersedia" id="tersedia" class="form-control" placeholder="Masukan Ke-Tersedian Buku" />
                        <span class="help-block has-error tersedia_error"></span>
                     </div>
                  <div class="modal-footer">
                    <input type="hidden" name="buku_id" id="buku_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  </div>
               </form>
            </div>
         </div>
      </div>