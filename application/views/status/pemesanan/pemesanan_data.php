<section class="content-header">
      <h1>pemesanan
        <small>Pelanggan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">pemesanan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data pemesanan</h3>
                <div class="pull-right">
                    <a href="<?=site_url('pemesanan/add')?>" class="btn btn-primary btn-flat">
                        <i class="fa fa-plus"></i>Tambah
                    </a>
                </div>
            </div>
            <div class="box-body table responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {?>
                    <tr>
                            <td><?=$no++?></td>
                            <td><?=$data->name?></td>
                            <td class="text-center" width="160px"> 
                                <a href="<?=site_url('pemesanan/edit/'.$data->pemesanan_id)?>" class="btn btn-primary btn-xs">
                                   <i class="fa fa-pencil"></i>Edit
                                </a>
                                <a href="<?=site_url('pemesanan/del/'.$data->pemesanan_id)?>" onclick="return confirm('apakah anda yakin ?')" class="btn btn-danger btn-xs">
                                   <i class="fa fa-trash"></i>Hapus
                                </a>

                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>