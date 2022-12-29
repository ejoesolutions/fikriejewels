total semua : <?= $all['total'] ?>
<br>
total dijual : <?= $sold['total'] ?>
<br>
total stok : <?= $aval['total'] ?>
<br>
total keluar : <?= $test2['total'] ?>
<br>
total deposit : <?= $test3['total'] ?>
<br>
total test4 : <?= $test4['total'] ?>
<br>
total t.kedai : <?= $test5['total'] ?>
<br>
total t.baru : <?= $test6['total'] ?>
<br>
total t.baiki : <?= $test7['total'] ?>
<br>
total t.kedai.siap : <?= $test8['total'] ?>
<br>
total t.baru.siap : <?= $test9['total'] ?>
<br>
total t.baiki.siap : <?= $test10['total'] ?>
<br>
total refund : <?= $test99['total'] ?>



<br>

<ol>
  
<?php foreach ($get_test7_list as $key) {
  echo '<li>'.$key['repair_no'].' ['.$key['v_sn'].']</li>';
} ?>

</ol>
