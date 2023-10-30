<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<style>
    th { font-size: 12px; }
    td { font-size: 12px; }
</style>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= $title ?> [<?php echo $namas->nama_art;?>]</h5><hr>
        <!-- Log Activity -->
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered zero-configuration" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id ART</th>
                        <th>By</th>
                        <th>Description</th>
                        <th>Stereotype</th>
                        <th>On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($log as $vlog) { $on = date("d-m-Y H:i:s",strtotime($vlog->created_on)); ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $vlog->detail_id; ?></td>
                            <td><?php echo $vlog->created_by; ?></td>
                            <td><?php echo $vlog->description; ?></td>                            
                            <td><?php echo $vlog->stereotype; ?></td>                            
                            <td><?php echo $on; ?></td>                            
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/dataTables.select.min.js"></script>

<script>
     $(document).ready(function() {
        $.noConflict();

        // zero configuration
        $('.zero-configuration').DataTable( {
            "ordering": false,
            "sScrollX": ($(window).width() - 100),
        });
     });
 </script>