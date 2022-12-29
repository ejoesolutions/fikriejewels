<div class="row">
    <div class="col-md-12">
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr class="uppercase">
                    <th nowrap class="text-center">Bil</th>
                    <th nowrap class="text-center">Invoice</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Tarikh Invoice</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>

            <tbody>

                <?php if(!empty($invoice_list)): ?>

                <?php

                $i=1;

                foreach ($invoice_list as $row) {

                ?>

                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td class="text-center">#<?php echo str_pad($row['id'],4,'0',STR_PAD_LEFT) ?></td>
                    <td class="text-center"><?php echo $row['full_name'] ?></td>
                    <td class="text-center"><?php echo $row['invoice_date'] ?></td>
                    <td class="text-center"><a href="<?php echo base_url('catalog/print_detail_order/'.$row['id']) ?>" title="Cipta Kod Bar" target="_blank"><span class="fe fe-24 fe-printer"></span></a></td>
                </tr>

                <?php
                }
                ?>

                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>