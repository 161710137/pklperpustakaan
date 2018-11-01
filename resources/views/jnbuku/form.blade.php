<div id="jenModal" class="modal fade" role="dialog" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" id="jen_form" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('POST') }}
                  <div class="modal-header" style="background-color: lightblue;">
                     <button type="button" class="close" data-dismiss="modal" >&times;</button>
                     <h4 class="modal-title" >Add Data</h4>
                  </div>
                  <div class="modal-body">                     
                     <span id="form_output"></span>
                     <input type="hidden" name="id" id="id">
                     <div class="form-group">
                        <label>Jenis Buku:</label>
                        <input type="text" name="jenis" id="jenis" class="form-control" placeholder="Masukan Nama Jenis Buku" />
                        <span class="help-block has-error jenis_error"></span>
                     </div>
                  <div class="modal-footer">
                    <input type="hidden" name="jen_id" id="jen_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  </div>
               </form>
            </div>
         </div>
      </div>