<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-3">
                <h1 class="h3 mb-0 text-gray-800 mt-3"><?= $title?></h1>
            </div>
            <div class="">
                <a href="#modalAdd" data-toggle="modal" class="btn btn-success btn-sm mb-3 btnModal"><i class="fa fa-plus"></i> Tambah Kelas</a>
                <a onclick="reload_table()" data-toggle="modal" class="btn btn-sm btn-info mb-3 text-light"><i class="fa fa-sync"></i> Reload</a>
            </div>
            <div class="notification">
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="msgKelas">
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4" style="max-width: 1000px">
                <div class="card-body">
                    <div id="reload">
                        <table id="dataTable" class="table table-sm cus-font">
                            <thead>
                                <tr>
                                    <th style="width: 3%">No</th>
                                    <th style="width: 6%">Status</th>
                                    <th style="width: 10%">Tgl. Mulai</th>
                                    <th>Nama Kelas</th>
                                    <th>Pengajar</th>
                                    <th style="width: 10%"><center>Program</center></th>
                                    <th style="width: 5%">Peserta</th>
                                    <th style="width: 5%">Detail</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal kelas -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDetail">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#" class='nav-link active' id="btn-form-1"><i class="fas fa-book"></i></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class='nav-link' id="btn-form-2"><i class="fas fa-users"></i></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class='nav-link' id="btn-form-3"><i class="fas fa-database"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body cus-font">
                        <div class="card" id="form-1">
                            <div class="card-header text-primary">
                                <strong>Data Kelas</strong>
                            </div>
                            <div class="card-body">
                                <div class="msgEditKelas"></div>
                                <form action="kelas/edit_kelas" method="post" id="formEditKelas">
                                    <input type="hidden" name="id_kelas">
                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Kelas</label>
                                        <input type="text" name="nama_kelas" id="nama_kelas_edit" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="program">Program</label>
                                        <select name="program" id="program_edit" class="form-control form-control-sm">
                                            <option value="">Pilih Program</option>
                                            <?php foreach ($program as $data) :?>
                                                <option value="<?= $data?>"><?= $data?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_civitas">Pengajar</label>
                                        <select name="id_civitas" id="id_civitas_edit" class="form-control form-control-sm">
                                            <option value="0">Pilih Pengajar</option>
                                            <?php foreach ($civitas as $data) :?>
                                                <option value="<?= $data['id_civitas']?>"><?= $data['nama_civitas']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_mulai">Tgl. Mulai</label>
                                        <input type="date" name="tgl_mulai" id="tgl_mulai_edit" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_selesai">Tgl. Selesai</label>
                                        <input type="date" name="tgl_selesai" id="tgl_selesai_edit" class="form-control form-control-sm">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <input type="submit" value="Ubah Data" class="btn btn-sm btn-success" id="btnEdit">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card" id="form-2">
                            <div class="card-header text-primary">
                                <strong>List Peserta <span class="badge badge-info" id="jumPeserta">0</span></strong>
                            </div>
                            <div class="card-body">
                                <div class="msgHapusPeserta"></div>
                                <form action="kelas/delete_peserta" method="post" id="formDeletePeserta">
                                    <input type="hidden" name="id_kelas">
                                    <ul class="list-group">
                                        <div id="list-peserta"></div>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-danger mt-3" id="btnPeserta">Hapus Peserta (<span id="select1">0</span>)</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card" id="form-3">
                            <div class="card-header text-primary">
                                <strong>List Pertemuan</strong>
                            </div>
                            <div class="card-body">
                                <div class="msgListPertemuan"></div>
                                <form action="kelas/list_pertemuan" method="post" id="formListPertemuan">
                                    <input type="hidden" name="id_kelas">
                                    <ul class="list-group">
                                        <div id="list-pertemuan"></div>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <input type='submit' value='Simpan Data' class='btn btn-sm btn-primary mt-3' id='btnList'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<!-- modal kelas -->

<!-- modal add kelas -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTitle">Tambah Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body cus-font" id="modal-add">
                <div class="msg-add-data"></div>
                <form action="kelas/add_kelas" method="post" id="formAdd">
                    <div class="form-group">
                        <label for="tgl_mulai">Tgl. Mulai</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai_add" class="form-control form-control-sm" value="<?= date('Y-m-d')?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai">Tgl. Selesai</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai_add" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas_add" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="program">Program</label>
                        <select name="program" id="program_add" class="form-control form-control-sm" required>
                            <option value="">Pilih Program</option>
                            <?php foreach ($program as $data) :?>
                                <option value="<?= $data?>"><?= $data?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <input type="submit" value="Tambah Kelas" class="btn btn-sm btn-primary" id="btnModalAdd">
                    </div>
                </form>
            </div>
          </div>
      </div>
    </div>
<!-- modal add kelas -->
<script>
    $("#sidebarKelas").addClass("active");
    
    $(".btnModal").click(function(){
        delete_msg();
    })

    // peserta
    let a = [];

    // pertemuan
    let b = [];

    $(".btnModal").click(function(){
        delete_msg();
    })
                                    
    table = $('#dataTable').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url()?>kelas/ajax_list",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [0, 6, 7], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    });
    
    $("#formAdd").submit(function(){
        if(confirm("Yakin akan menambahkan kelas baru?")){
            var tgl_mulai = $("#tgl_mulai_add").val();
            var tgl_selesai = $("#tgl_selesai_add").val();
            var nama_kelas = $("#nama_kelas_add").val();
            var program = $("#program_add").val();
            $.ajax({
                type : "POST",
                url : "<?= base_url()?>kelas/add_kelas",
                dataType : "JSON",
                data : {tgl_mulai : tgl_mulai,tgl_selesai : tgl_selesai,nama_kelas : nama_kelas,program : program},
                success : function(data){
                    $("#formAdd").trigger("reset");
                    var msg = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle text-success mr-1"></i> Berhasil menambahkan kelas baru<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                    $('.msg-add-data').html(msg);
                    $("#modal-add").scrollTop(0);
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    var msg = `
                        <span class="fas icon-msg fa-times-circle"></span>
                        <span class="msg">Gagal menambahkan kelas baru</span>
                        <span class="close-msg">
                            <span class="fas fa-times"></span>
                        </span>`;
                    $('.notification').html(msg);
                    $('.notification').addClass("show");
                    $('.notification').addClass("danger");
                    $('.notification').removeClass("hide");
                    $('.notification').addClass("showAlert");
                    setTimeout(function(){
                        $('.notification').removeClass("show");
                        $('.notification').addClass("hide");
                    },5000);
                }
            })
        }
        return false;
    })

    $("#formEditKelas").submit(function(){
        if(confirm("Yakin akan merubah data kelas ini?")){
            var id = $("input[name='id_kelas']").val()
            var nama_kelas = $("#nama_kelas_edit").val();
            var program = $("#program_edit").val();
            var tgl_mulai = $("#tgl_mulai_edit").val();
            var tgl_selesai = $("#tgl_selesai_edit").val();
            var id_civitas = $("#id_civitas_edit").val();
            $.ajax({
                type : "POST",
                url : "<?= base_url()?>kelas/edit_kelas",
                dataType : "JSON",
                data : {id_kelas : id,nama_kelas : nama_kelas,program : program,tgl_mulai : tgl_mulai,tgl_selesai : tgl_selesai,id_civitas : id_civitas},
                success : function(data){
                    // $("#modalEditTitle").html(nama)
                    var msg = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle text-success mr-1"></i> Berhasil merubah data kelas<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                    $('.msgEditKelas').html(msg);
                    $("#modalDetail").scrollTop(0);
                    detail(id);
                    reload_table();
                }
            })
        }
        return false;
    })
    
    $("#dataTable").on("click", ".detail", function(){
        a = [];
        $("#select1").html(0);
        const id = $(this).data('id');
        detail(id)
        btn_1();
        delete_msg();
    })
    
    $("#dataTable").on("click", ".peserta", function(){
        a = [];
        $("#select1").html(0);
        const id = $(this).data('id');
        detail(id)
        btn_2();
        delete_msg();
    })

    $("#dataTable").on("click", "#btnStatusKelas", function(){
        let data = $(this).data("id");
        data = data.split("|");
        let id = data[0];
        let nama = data[1];
        let status = data[2]

        if(confirm("Yakin akan "+status+" kelas "+nama+"?")){
            $.ajax({
                url: "<?= base_url()?>kelas/edit_status_kelas",
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function(data){
                    reload_table();
                    $(".msgKelas").html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle text-success mr-1"></i> berhasil mengganti status kelas
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`)
                }
            })
        }
    })
    
    $("#formDeletePeserta").submit(function(){
        if(confirm("Yakin akan menghapus peserta dari kelas ini?")){
            if((a === undefined || a.length == 0)){
                var msg = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Untuk menghapus peserta silahkan menandai checkbox terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                $('.msgHapusPeserta').html(msg);
                $("#modalDetail").scrollTop(0);
            }
            var id = $("input[name='id_kelas']").val()
            $.ajax({
                type : "POST",
                url : "<?= base_url()?>kelas/delete_peserta",
                dataType : "JSON",
                data : {peserta:a, id_kelas:id},
                success : function(data){
                    var msg = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle text-success mr-1"></i> Berhasil menghapus peserta dari kelas ini<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                    $('.msgHapusPeserta').html(msg);
                    $("#modalDetail").scrollTop(0);
                    detail(id);
                    btn_2();
                    reload_table();
                    $("#select1").html(0);
                }
            })
        }   
        return false;
    })

    $('#formDeletePeserta').on('click', 'input[type="checkbox"][name="peserta[]"]', function(){
        if($(this).prop("checked") == true){
            a.push($(this).val());
            $("#select1").html(a.length);
        }
        else if($(this).prop("checked") == false){
            let no = a.indexOf($(this).val());
            a.splice(no, 1);
            $("#select1").html(a.length);
        }
    });
    
    $('#formListPertemuan').on('click', 'input[type="checkbox"][name="pertemuan[]"]', function(){
        if($(this).prop("checked") == true){
            b.push($(this).val());
        }
        else if($(this).prop("checked") == false){
            let no = b.indexOf($(this).val());
            b.splice(no, 1);
        }
    });
    
    $("#formListPertemuan").submit(function(){
        if(confirm("Yakin akan merubah data pertemuan?")){
            var id = $("input[name='id_kelas']").val()
            $.ajax({
                type : "POST",
                url : "<?= base_url()?>kelas/list_pertemuan",
                dataType : "JSON",
                data : {pertemuan:b, id_kelas:id},
                success : function(data){
                    b = [];
                    var msg = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle text-success mr-1"></i> Berhasil merubah data pertemuan<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                    $('.msgListPertemuan').html(msg);
                    $("#modalDetail").scrollTop(0);
                    detail(id);
                    reload_table();
                }
            })
        }   
        return false;
    })
    
    // detail
        $("#btn-form-1").click(function(){
            btn_1();
            delete_msg();
        })
        
        $("#btn-form-2").click(function(){
            btn_2();
            delete_msg();
        })
        
        $("#btn-form-3").click(function(){
            btn_3();
            delete_msg();
        })
    // detail

    // function 
        function reload_table(){
            table.ajax.reload(null,false); //reload datatable ajax 
        }

        function btn_1(){
            $("#btn-form-1").addClass('active');
            $("#btn-form-2").removeClass('active');
            $("#btn-form-3").removeClass('active');
            
            $("#form-1").show();
            $("#form-2").hide();
            $("#form-3").hide();
        }

        function btn_2(){ 
            $("#btn-form-1").removeClass('active');
            $("#btn-form-2").addClass('active');
            $("#btn-form-3").removeClass('active');
            
            $("#form-1").hide();
            $("#form-2").show();
            $("#form-3").hide();
        }
        
        function btn_3(){
            $("#id_kelas_add").val("");
            $("#btn-form-1").removeClass('active');
            $("#btn-form-2").removeClass('active');
            $("#btn-form-3").addClass('active');
            
            $("#form-1").hide();
            $("#form-2").hide();
            $("#form-3").show();
        }

        function delete_msg(){
            $('.msgHapusPeserta').html("");
            $('.msgEditKelas').html("");
            $('.msg-add-data').html("");
            $('.msgListPertemuan').html("");
            $('.msgKelas').html("");
        }

        function detail(id){
            $.ajax({
                url : "<?=base_url()?>kelas/get_detail_kelas",
                method : "POST",
                data : {id : id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $("#modalEditTitle").html(data.nama_kelas);
                    $("input[name='id_kelas']").val(data.id_kelas);
                    $("#nama_kelas_edit").val(data.nama_kelas);
                    $("#program_edit").val(data.program);
                    $("#tgl_mulai_edit").val(data.tgl_mulai)
                    $("#tgl_selesai_edit").val(data.tgl_selesai)
                    $("#id_civitas_edit").val(data.id_civitas)
                    
                    pert = [];
                    data.pertemuan.forEach((materi, i) => {
                        pert[i] = materi.materi;
                    });
                    
                    let html = "";
                    let check = "";

                    for (let i = 1; i < 26; i++) {
                        if(pert.includes("Pertemuan "+i)){
                            check = "checked";
                            b.push("Pertemuan "+i);
                        } else {
                            check = "";
                        }

                        html += `<li class="list-group-item"><input type="checkbox" name="pertemuan[]" value="Pertemuan `+i+`" id="per`+i+`" class="mr-3" `+check+`><label for="per`+i+`">Pertemuan `+i+`</label></li>`;
                    }

                    $("#list-pertemuan").html(html);

                    html = "";

                    // let peserta = data.peserta;
                    if(data.peserta){
                        $("#jumPeserta").html(data.peserta.length)
                        data.peserta.forEach((element, i) => {
                            html += `<li class="list-group-item"><input type="checkbox" name="peserta[]" value="`+element.id_user+`" id="peserta`+element.id_user+`" class="mr-3"><label for="peserta`+element.id_user+`">`+element.nama+`</label></li>`;
                        });
                        $("#list-peserta").html(html);
                        $("#btnPeserta").show();
                    } else {
                        $("#jumPeserta").html(0)
                        $("#list-peserta").html(`<div class="alert alert-warning"><i class="fa fa-exclamation-circle mr-1 text-warning"></i> List peserta kosong</div>`);
                        $("#btnPeserta").hide();
                    }
                }
            })
        }
    // function 
</script>
