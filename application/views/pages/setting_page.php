<?= $this->session->flashdata('upload'); ?>

<main role="main" class="main-content ml-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 page-title">Tetapan</h2>
        <div class="my-4">
          <ul class="nav nav-tabs mb-4" id="myTabContent" role="tablist">
            <li class="nav-item">
              <a class="nav-link <?php if (!$this->uri->segment(3)){ echo "active";} ?>" id="home-tab" data-toggle="tab"
                href="#home" role="tab" aria-controls="home" aria-selected="false">Logo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "maklumat"){ echo "active";} ?>" id="contact-tab" data-toggle="tab" href="#email" role="tab" aria-controls="menu"
                aria-selected="false">Maklumat</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "komisen"){ echo "active";} ?>" id="contact-tab"
                data-toggle="tab" href="#komisen" role="tab" aria-controls="komisen" aria-selected="false">Komisen</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "pesanan"){ echo "active";} ?>" id="profile-tab"
                data-toggle="tab" href="#pesanan" role="tab" aria-controls="pesanan" aria-selected="false">Terma &
                Syarat Pesanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "belian"){ echo "active";} ?>" id="contact-tab"
                data-toggle="tab" href="#footer" role="tab" aria-controls="footer" aria-selected="false">Terma & Syarat
                Belian</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "tempahan"){ echo "active";} ?>" id="contact-tab"
                data-toggle="tab" href="#menu" role="tab" aria-controls="menu" aria-selected="false">Terma & Syarat
                Tempahan</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php if ($this->uri->segment(3) == "backup"){ echo "active";} ?>" id="contact-tab"
                data-toggle="tab" href="#backup" role="tab" aria-controls="menu" aria-selected="false">Backup Data</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">

            <!-- Logo Tab -->
            <div class="tab-pane fade <?php if (!$this->uri->segment(3)){ echo "show active";} ?>" id="home"
              role="tabpanel" aria-labelledby="home-tab">
              <div class="card border-0 bg-transparent">
                <?= form_open_multipart('admin/store_logo', array('id' => 'addLogo')); ?>

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="card border-0 bg-transparent">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new img-responsive">
                        <img src="<?= base_url().'logo/'.$logo['image_file'] ?>" alt="" style="max-height:300px">
                      </div>

                      <div class="fileinput-preview fileinput-exists img-responsive"></div>

                      <div>
                        <span class="btn default btn-file pl-0">
                          <span class="fileinput-new btn btn-info"><i class="fe fe-camera fe-16"></i>
                            <?php echo lang('form_button_image') ?></span>
                          <input type="file" name="userfile" id="userfile" required>
                        </span>
                      </div>

                      <a href="javascript:;" class="btn btn-danger fileinput-exists mb-2" data-dismiss="fileinput">
                        <?php echo lang('form_button_image_delete') ?> </a>

                      <div class="clearfix margin-top-10">
                        <small><span class="text-danger">NOTE!</span>
                          <?php echo lang('form_button_upload_note') ?></small>
                        <?php if (isset($error_image)): ?>
                        <?php echo '<p><small class="text-danger">'. $error_image .'</small></p>'; ?>
                        <?php endif; ?>
                      </div>
                      <?php
                        echo form_hidden('logo_id',$logo['logo_id']);
                        echo form_hidden('temp_logo',$logo['image_file']);
                      ?>
                      <input type="submit" name="btnWeightCost" id="btnAddLogo" value="Simpan" class="btn btn-primary mt-3">

                    </div>
                  </div>
                </div>

                <?php echo form_close(); ?>

              </div>
              <!-- .card -->
            </div>
            <!-- ./Logo Tab -->

            <!-- Emel Tab -->
            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "maklumat"){ echo "show active";} ?>" id="email" role="tabpanel" aria-labelledby="email-tab">
              <!-- modal edit cawangan -->
              <div class="modal fade" id="editCawanganModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="defaultModalLabel">Kemaskini Maklumat</h5>
                    </div>
                    <div class="modal-body">
                    <?= form_open('admin/update_cawangan', array('id' => 'updDetail')); ?>
                      <div class="container">
                        <div class="row">
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-12 pl-0">
                              <h6>Nama :</h6>
                              <input type="text" class="form-control" name="nama" id="getName" required>
                            </div>
                            <!-- <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Kod :</h6>
                              <input type="text" class="form-control" name="code" id="getCode">
                            </div> -->
                          </div>
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Nama Tambahan :</h6>
                              <input type="text" class="form-control" name="n_tambahan" id="getTambahan">
                            </div>
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>No Pendaftaran :</h6>
                              <input type="text" class="form-control" name="pendaftaran" id="getPendaftaran">
                            </div>
                          </div>
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Alamat :</h6> 
                              <input type="text" class="form-control" name="alamat" id="getAlamat" required>
                            </div>
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Poskod :</h6>
                              <input type="text" class="form-control" name="poskod" id="getPoskod" required>
                            </div>
                          </div>
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Bandar :</h6> 
                              <input type="text" class="form-control" name="bandar" id="getBandar" required>
                            </div>
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Negeri :</h6>
                              <select class="form-control" name="negeri" id="selectNegeri">
                                <option value="">---Pilih---</option>
                                <?php foreach ($state as $row) {
                                  echo '<option value="'.$row['state_id'].'">'.$row['state'].'</option>';
                                } ?>
                              </select> 
                            </div>
                          </div>
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Telefon :</h6> 
                              <input type="text" class="form-control" name="telefon" id="getTelefon">
                            </div>
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>H/P (1):</h6>
                              <input type="text" class="form-control" name="hp1" id="getHp1">
                            </div>
                          </div>
                          <div class="form-row col-md-12 margin-top-20">
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>H/P (2):</h6>
                              <input type="text" class="form-control" name="hp2" id="getHp2">
                            </div>
                            <div class="form-group mb-3 col-md-6 pl-0">
                              <h6>Nama Tag :</h6>
                              <input type="text" class="form-control" name="tag" id="getTag" required>
                            </div>
                          </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="cawangan_id" id="getId">
                        <button type="button" class="btn mb-2 btn-outline-dark" data-dismiss="modal">Tutup</button>
                        <button type="submit" id="btnUpdDetail" class="btn btn-primary float-right mr-2">Kemaskini</button>
                      </div>
                    <?= form_close(); ?>
                  </div>
                </div>
              </div>
              <!-- modal cawangan -->
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4>Maklumat</h4>
                  <table class="table table-hover text-dark">
                    <thead>
                      <tr>
                        <th width="40%" class="text-center">Nama</th>
                        <th width="30%" class="text-center">Nama Tag</th>
                        <th width="30%" class="text-center">No Pendaftaran</th>
                        <th width="20%" class="text-center">#</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($cawangan as $row) { ?>
                      <tr>
                        <!-- <td class="text-center"><?= $i++ ?></td> -->
                        <td class="text-center"><?= $row['name'] ?></td>
                        <td class="text-center"><?= $row['tag'] ?></td>
                        <td class="text-center"><?= $row['pendaftaran'] ?></td>
                        <td class="text-center">
                          <a href="" data-toggle="modal" data-role="editCawanganModal" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-code="<?= $row['cawangan_code'] ?>"
                          data-tambahan="<?= $row['nama_tambahan'] ?>" data-pendaftaran="<?= $row['pendaftaran'] ?>" data-alamat="<?= $row['alamat'] ?>" data-poskod="<?= $row['poskod'] ?>"
                          data-bandar="<?= $row['bandar'] ?>" data-negeri="<?= $row['negeri'] ?>" data-telefon="<?= $row['telefon'] ?>" data-hp1="<?= $row['hp1'] ?>"
                          data-hp2="<?= $row['hp2'] ?>" data-tag="<?= $row['tag'] ?>"
                          data-target="#editCawanganModal">
                            <span class="fe fe-20 fe-edit"></span>
                          </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <hr>
                  <br>
                  <h4>Tetapan</h4>
                  <?= form_open('admin/store_detail', ''); ?>
                    <div class="form-row col-md-12 mt-3">
                      <!-- <div class="form-group mb-3 col-md-4 pl-0">
                        <h6>Komisen (RM) :</h6> 
                        <input type="text" class="form-control" name="komisen" value="<?= $maklumat['komisen'] ?>" required>
                      </div> -->
                      <div class="form-group mb-3 col-md-6 pl-0">
                        <h6>Margin Upah (%) :</h6> 
                        <input type="text" class="form-control" name="margin_upah" value="<?= $maklumat['margin_upah'] ?>" required>
                      </div>
                      <div class="form-group mb-3 col-md-4 pl-5">
                        <h6>Default Jenis Pesanan :</h6> 
                        <div class="custom-control custom-radio">
                          <input type="radio" id="pesananRadio1" value="1" name="jenis_pesanan" class="custom-control-input" <?php if ($maklumat['pesanan']==1) {echo "checked"; } ?>>
                          <label class="custom-control-label" for="pesananRadio1">Ikat Harga</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="pesananRadio2" value="2" name="jenis_pesanan" class="custom-control-input" <?php if ($maklumat['pesanan']==2) {echo "checked"; } ?>>
                          <label class="custom-control-label" for="pesananRadio2">Harga Semasa</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mr-2">Kemaskini</button>
                  <?= form_close(); ?>  
                </div>
              </div>
            </div>
            <!-- ./Emel Tab -->

            <!-- Komisen Tab -->
            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "komisen"){ echo "show active";} ?>"
              id="komisen" role="tabpanel" aria-labelledby="komisen-tab">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 margin-top-20">
                      <h4>Komisen <button type="button" class="btn mb-2 btn-primary ml-1" data-toggle="modal"
                          data-target="#komisenModal">+</button></h4>

                      <!-- Modal -->
                      <div class="modal fade <?php if ($this->uri->segment(3) == "komisen"){ echo "show active";} ?>"
                        id="komisenModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_komisen', array('id' => 'addComm')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Tambah Komisen</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group"> 
                                <label for="">Minimun ( RM )</label>
                                  <input type="text" class="form-control" name="min_komisen" required>
                              </div>
                              <div class="form-group">
                                <label for="">Komisen ( RM )</label>
                                <input type="text" class="form-control" name="komisen_komisen" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddComm" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="40%" class="text-center">Minimun ( RM )</th>
                              <th width="30%" class="text-center">Komisen ( RM )</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($komisen)):

                            $i=1;

                            foreach ($komisen as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td class="text-center"><?= $row['min'] ?></td>
                              <td class="text-center"><?= $row['komisen'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editKomisenModal"
                                  data-min="<?= $row['min'] ?>" data-komisen="<?= $row['komisen'] ?>" data-target="#editKomisenModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_komisen"
                                  href="<?php echo base_url('admin/delete_komisen/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit komisen -->
                        <div class="modal fade" id="editKomisenModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?= form_open('admin/edit_komisen', array('id' => 'updComm')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Kemaskini Komisen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group"> 
                                  <label for="">Minimun ( RM )</label>
                                    <input type="text" id="min_komisen" class="form-control" name="min_komisen" required>
                                    <input type="hidden" id="id_komisen" name="id_komisen">
                                </div>
                                <div class="form-group">
                                  <label for="">Komisen ( RM )</label>
                                  <input type="text" id="komisen_komisen" class="form-control" name="komisen_komisen" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnUpdComm" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?= form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal komisen -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Terma & Syarat Pesanan Tab -->
            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "pesanan"){ echo "show active";} ?>"
              id="pesanan" role="tabpanel" aria-labelledby="profile-tab">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 margin-top-20">
                      <h4>Ikat Harga <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                        data-target="#ikatModal">+ Terma & Syarat</button></h4>

                      <!-- Button trigger modal -->

                      <!-- Modal -->
                      <div class="modal fade <?php if ($this->uri->segment(3) == "pesanan"){ echo "show active";} ?>"
                        id="ikatModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_ikat', array('id' => 'addIkat')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Ikat Harga</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Tambah Terma & Syarat</label>
                                <input type="text" class="form-control" name="syarat" required>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnAddIkat" class="btn mb-2 btn-primary">Tambah</button>
                              </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_ikat)):

                            $i=1;

                            foreach ($syarat_ikat as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editIkatModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editIkatModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_pesanan_ikat"
                                  href="<?php echo base_url('admin/delete_syarat_ikat/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>

                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editIkatModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_ikat', array('id' => 'editIkat')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Ikat Harga</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat" class="form-control" name="syarat" required>
                                <input type="hidden" id="id" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditIkat" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->

                      <h4>Harga Semasa <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                          data-target="#semasaModal">+ Terma & Syarat</button></h4>

                      <!-- Button trigger modal -->

                      <!-- Modal -->
                      <div class="modal fade" id="semasaModal" tabindex="-1" role="dialog"
                        aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_semasa', array('id' => 'addSemasa')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Harga Semasa</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddSemasa" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_semasa)):

                            $i=1;

                            foreach ($syarat_semasa as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editSemasaModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editSemasaModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_pesanan_semasa"
                                  href="<?php echo base_url('admin/delete_syarat_semasa/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editSemasaModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_semasa', array('id' => 'editSemasa')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Harga Semasa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat_semasa" class="form-control" name="syarat" required>
                                <input type="hidden" id="id_semasa" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditSemasa" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Terma & Syarat Belian Tab -->
            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "belian"){ echo "show active";} ?>"
              id="footer" role="tabpanel" aria-labelledby="footer-tab">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 margin-top-20">
                      <h4>Belian <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                          data-target="#belianModal">+ Terma & Syarat</button></h4>

                      <!-- Modal -->
                      <div class="modal fade <?php if ($this->uri->segment(3) == "belian"){ echo "show active";} ?>"
                        id="belianModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_belian', array('id' => 'addBelian')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Belian</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddBelian" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_belian)):

                            $i=1;

                            foreach ($syarat_belian as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editBelianModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editBelianModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_belian"
                                  href="<?php echo base_url('admin/delete_syarat_belian/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editBelianModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_belian', array('id' => 'editBelian')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Belian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat_belian" class="form-control" name="syarat" required>
                                <input type="hidden" id="id_belian" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditBelian" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Menu Tab -->
            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "tempahan"){ echo "show active";} ?>"
              id="menu" role="tabpanel" aria-labelledby="menu-tab">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 margin-top-20">
                      <h4>Keluar <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                        data-target="#keluarModal">+ Terma & Syarat</button></h4>

                      <!-- Modal -->
                      <div class="modal fade <?php if ($this->uri->segment(3) == "tempahan"){ echo "show active";} ?>"
                        id="keluarModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_keluar', array('id' => 'addKeluar')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Keluar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddKeluar" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_keluar)):

                            $i=1;

                            foreach ($syarat_keluar as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editKeluarModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editKeluarModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_keluar"
                                  href="<?php echo base_url('admin/delete_syarat_keluar/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editKeluarModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_keluar', array('id' => 'editKeluar')); ?>
                                <div class="modal-header">
                                  <h5 class="modal-title" id="defaultModalLabel">Belian</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <label for="">Kemaskini Terma & Syarat</label>
                                  <input type="text" id="syarat_keluar" class="form-control" name="syarat" required>
                                  <input type="hidden" id="id_keluar" name="id">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn mb-2 btn-outline-dark"
                                    data-dismiss="modal">Tutup</button>
                                  <button type="submit" id="btnEditKeluar" class="btn mb-2 btn-primary">Kemaskini</button>
                                </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->


                      <!-- kedai -->
                      <h4>Kedai <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                          data-target="#kedaiModal">+ Terma & Syarat</button></h4>

                      <!-- Modal -->
                      <div class="modal fade" id="kedaiModal" tabindex="-1" role="dialog"
                        aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_kedai', array('id' => 'addKedai')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Kedai</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddKedai" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_kedai)):

                            $i=1;

                            foreach ($syarat_kedai as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editKedaiModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editKedaiModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_kedai"
                                  href="<?php echo base_url('admin/delete_syarat_kedai/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editKedaiModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_kedai', array('id' => 'editKedai')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Kedai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat_kedai" class="form-control" name="syarat" required>
                                <input type="hidden" id="id_kedai" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditKedai" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->

                      <!-- Baru -->
                      <h4>Baru <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                        data-target="#baruModal">+ Terma & Syarat</button></h4>

                      <!-- Modal -->
                      <div class="modal fade" id="baruModal" tabindex="-1" role="dialog"
                        aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?= form_open('admin/store_syarat_baru', array('id' => 'addBaru')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Baru</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddBaru" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?= form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_baru)):

                            $i=1;

                            foreach ($syarat_baru as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editBaruModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editBaruModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_baru"
                                  href="<?php echo base_url('admin/delete_syarat_baru/'.$row['id']) ?>"><span
                                    class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editBaruModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_baru', array('id' => 'editBaru')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Kedai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat_baru" class="form-control" name="syarat" required>
                                <input type="hidden" id="id_baru" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditBaru" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->

                      <!-- Baiki -->
                      <h4>Baiki <button type="button" class="btn mb-2 btn-primary ml-2" data-toggle="modal"
                          data-target="#baikiModal">+ Terma & Syarat</button></h4>

                      <!-- Modal -->
                      <div class="modal fade" id="baikiModal" tabindex="-1" role="dialog"
                        aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <?php echo form_open('admin/store_syarat_baiki', array('id' => 'addBaiki')); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="defaultModalLabel">Baiki</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <label for="">Tambah Terma & Syarat</label>
                              <input type="text" class="form-control" name="syarat" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn mb-2 btn-outline-dark"
                                data-dismiss="modal">Tutup</button>
                              <button type="submit" id="btnAddBaiki" class="btn mb-2 btn-primary">Tambah</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>

                      <!-- simple table -->
                      <div class="my-4">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th width="10%" class="text-center">Bil</th>
                              <th width="70%" class="text-center">Terma & Syarat</th>
                              <th width="20%" class="text-center">#</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if(!empty($syarat_baiki)):

                            $i=1;

                            foreach ($syarat_baiki as $row) { ?>

                            <tr>
                              <td class="text-center"><?= $i++ ?></td>
                              <td><?= $row['text'] ?></td>
                              <td class="text-center">
                                <a href="" data-toggle="modal" data-id="<?= $row['id'] ?>" data-role="editBaikiModal"
                                  data-text="<?= $row['text'] ?>" data-target="#editBaikiModal">
                                  <span class="fe fe-20 fe-edit"></span>
                                </a>
                                |
                                <a class="text-danger delete_baiki"
                                  href="<?php echo base_url('admin/delete_syarat_baiki/'.$row['id']) ?>">
                                  <span class="fe fe-20 fe-trash"></span></a>
                              </td>
                            </tr>

                            <?php } 

                            endif; ?>
                          </tbody>
                        </table>
                        <!-- modal edit syarat -->
                        <div class="modal fade" id="editBaikiModal" tabindex="-1" role="dialog"
                          aria-labelledby="defaultModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <?php echo form_open('admin/edit_syarat_baiki', array('id' => 'editBaiki')); ?>
                              <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Kedai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Kemaskini Terma & Syarat</label>
                                <input type="text" id="syarat_baiki" class="form-control" name="syarat" required>
                                <input type="hidden" id="id_baiki" name="id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn mb-2 btn-outline-dark"
                                  data-dismiss="modal">Tutup</button>
                                <button type="submit" id="btnEditBaiki" class="btn mb-2 btn-primary">Kemaskini</button>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                        <!-- modal edit syarat -->
                      </div> <!-- simple table -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ./Menu Tab -->

            <div class="tab-pane fade <?php if ($this->uri->segment(3) == "tempahan"){ echo "show active";} ?>"
              id="backup" role="tabpanel" aria-labelledby="menu-tab">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 margin-top-20">
                      <a href="<?= base_url('admin/backup') ?>" >
                        <div class="card-body file text-center">
                          <div class="circle circle-lg bg-light my-4">
                            <span class="fe fe-database fe-24 text-secondary"></span>
                          </div>
                          <div class="file-info">
                            <span class="badge badge-pill badge-light text-muted">SQL</span>
                          </div>
                        </div> <!-- .card-body -->
                        <div class="card-footer bg-transparent border-0 fname text-center">
                          <strong>Download Backup Data</strong>
                        </div> <!-- .card-footer -->
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div> <!-- /.tab 1a -->
        </div> <!-- /.col-12 -->
      </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main> <!-- main -->

<script>

  $(document).on('click','a[data-role=editCawanganModal]', function(){

    const cawangan_id = $(this).data('id');
    const name = $(this).data('name');
    const code = $(this).data('code');
    const tambahan = $(this).data('tambahan');
    const pendaftaran = $(this).data('pendaftaran');
    const alamat = $(this).data('alamat');
    const poskod = $(this).data('poskod');
    const bandar = $(this).data('bandar');
    const negeri = $(this).data('negeri');
    const telefon = $(this).data('telefon');
    const hp1 = $(this).data('hp1');
    const hp2 = $(this).data('hp2');
    const tag = $(this).data('tag');

    $('#getId').val(cawangan_id);
    $('#getName').val(name);
    $('#getCode').val(code);
    $('#getTambahan').val(tambahan);
    $('#getPendaftaran').val(pendaftaran);
    $('#getAlamat').val(alamat);
    $('#getPoskod').val(poskod);
    $('#getBandar').val(bandar);
    $('#getTelefon').val(telefon);
    $('#getHp1').val(hp1);
    $('#getHp2').val(hp2);
    $('#getTag').val(tag);

    $('#selectNegeri').val(negeri).trigger("change");

  });

  $(document).on('click', 'a[data-role=editIkatModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat').val(text);
    $('#id').val(id);

  });

  $(document).on('click', 'a[data-role=editSemasaModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_semasa').val(text);
    $('#id_semasa').val(id);

  });

  $(document).on('click', 'a[data-role=editBelianModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_belian').val(text);
    $('#id_belian').val(id);

  });

  $(document).on('click', 'a[data-role=editKomisenModal]', function () {

    var min = $(this).data('min');
    var komisen = $(this).data('komisen');
    var id = $(this).data('id');

    $('#min_komisen').val(min);
    $('#komisen_komisen').val(komisen);
    $('#id_komisen').val(id);

  });

  $(document).on('click', 'a[data-role=editKeluarModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_keluar').val(text);
    $('#id_keluar').val(id);

  });

  $(document).on('click', 'a[data-role=editKedaiModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_kedai').val(text);
    $('#id_kedai').val(id);

  });

  $(document).on('click', 'a[data-role=editBaruModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_baru').val(text);
    $('#id_baru').val(id);

  });

  $(document).on('click', 'a[data-role=editBaikiModal]', function () {

    var text = $(this).data('text');
    var id = $(this).data('id');

    $('#syarat_baiki').val(text);
    $('#id_baiki').val(id);

  });

  //delete ikat button confirmation
  $('.delete_pesanan_ikat').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete semasa button confirmation
  $('.delete_pesanan_semasa').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete belian button confirmation
  $('.delete_belian').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete keluar button confirmation
  $('.delete_keluar').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete kedai button confirmation
  $('.delete_kedai').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete baru button confirmation
  $('.delete_baru').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete baiki button confirmation
  $('.delete_baiki').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Terma & Syarat?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  //delete baiki button confirmation
  $('.delete_komisen').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Komisen?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  $('#addLogo').one('submit', function() {
    document.getElementById("btnAddLogo").disabled = true;
  });

  $('#updDetail').one('submit', function() {
    $('#btnUpdDetail').attr('disabled','disabled');
    $("#btnUpdDetail").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#addComm').one('submit', function() {
    document.getElementById("btnAddComm").disabled = true;
  });

  $('#updComm').one('submit', function() {
    document.getElementById("btnUpdComm").disabled = true;
  });

  $('#addIkat').one('submit', function() {
    document.getElementById("btnAddIkat").disabled = true;
  });

  $('#editIkat').one('submit', function() {
    document.getElementById("btnEditIkat").disabled = true;
  });

  $('#addSemasa').one('submit', function() {
    document.getElementById("btnAddSemasa").disabled = true;
  });

  $('#editSemasa').one('submit', function() {
    document.getElementById("btnEditSemasa").disabled = true;
  });

  $('#addBelian').one('submit', function() {
    document.getElementById("btnAddBelian").disabled = true;
  });

  $('#editBelian').one('submit', function() {
    document.getElementById("btnEditBelian").disabled = true;
  });

  $('#addKeluar').one('submit', function() {
    document.getElementById("btnAddKeluar").disabled = true;
  });

  $('#editKeluar').one('submit', function() {
    document.getElementById("btnEditKeluar").disabled = true;
  });

  $('#addKedai').one('submit', function() {
    document.getElementById("btnAddKedai").disabled = true;
  });

  $('#editKedai').one('submit', function() {
    document.getElementById("btnEditKedai").disabled = true;
  });

  $('#addBaru').one('submit', function() {
    document.getElementById("btnAddBaru").disabled = true;
  });

  $('#editBaru').one('submit', function() {
    document.getElementById("btnEditBaru").disabled = true;
  });

  $('#addBaiki').one('submit', function() {
    document.getElementById("btnAddBaiki").disabled = true;
  });

  $('#editBaiki').one('submit', function() {
    document.getElementById("btnEditBaiki").disabled = true;
  });
</script>