<div id="agtModal" class="modal fade" role="dialog" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" id="agt_form" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('POST') }}
                  <div class="modal-header" style="background-color: lightblue;">
                     <button type="button" class="close" data-dismiss="modal" >&times;</button>
                     <h4 class="modal-title" >Add Data</h4>
                  </div>
                  <div class="modal-body">                     
                     <span id="form_output"></span>
                     <input type="hidden" name="id" id="id">
                     <div class="form-group">
                        <label>No Anggota :</label>
                        <input type="text" name="no_agt" id="no_agt" class="form-control" placeholder="Masukan Nomor Anggota" />
                        <span class="help-block has-error no_agt_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Nama Anggota :</label>
                        <input type="text" name="nama_agt" id="nama_agt" class="form-control" placeholder="Masukan Nama Anggota" />
                        <span class="help-block has-error nama_agt_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan data alamat"></textarea>
                        <span class="help-block has-error alamat_error "></span>
                     </div>
                     <div class="form-group">
                        <label>Kota :</label>
                        <input type="text" name="kota" id="kota" class="form-control" placeholder="Masukan Kota" />
                        <span class="help-block has-error kota_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Telepon :</label>
                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Masukan Nomor Telepon" />
                        <span class="help-block has-error telp_error"></span>
                     </div>
                  <div class="modal-footer">
                    <input type="hidden" name="agt_id" id="agt_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  </div>
               </form>
            </div>
         </div>
      </div>