<style>
    th { font-size: 12px; }
    td { font-size: 12px; }
</style>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= $title ?></h5><hr>
        <!-- Log Activity -->
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered m-t-10">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>By</th>
                        <th>From</th>
                        <th>On</th>
                        <th>Stereotype</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function date_compare($element1, $element2) {
                        $datetime1 = strtotime($element1['on']);
                        $datetime2 = strtotime($element2['on']);
                        return $datetime1 - $datetime2;
                    }
                    // Sort the array
                    $audit_trail = json_decode( $log->audit_trails, true );
                    usort($audit_trail, 'date_compare');
                    if ( $audit_trail ) {
                        foreach ( $audit_trail as $key => $value) {
                            $on = date("d-m-Y H:i:s",strtotime($value['on']));
                            echo '
                                <tr>
                                    <td>' . $value['act'] . '</td>
                                    <td>' . $value['username'] . ' ( ' . $value['user_id'] . ' )</td>
                                    <td>' . $value['ip'] . '</td>
                                    <td>' . $on . '</td>
                                    <td>' . $value['column_data']['stereotype'] . '</td>
                                    <td>' . $on . '</td>
                                </tr>
                            ';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>