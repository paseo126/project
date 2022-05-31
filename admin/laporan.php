<button type="button" class='btn btn-dis'>KATEGORI</button> &raquo; 
<a href="javascript:window.print()"><button type="button" class='btn btn-add'>cetak laporan</button></a>
<br>

<?php 
include "koneksi.php";
?>
        <table style='background-color: #FFFFFF;' width='100%' border='1' cellpadding='4' cellspacing='0'>
          <tr>
            <th style='width: 2%;'>no</th>
            <th style='width: 10%;'>No Order</th>
            <th style='width: 15%;'>Nama Anggota</th>
            <th style='width: 25%;'>Alamat Kirim</th>
            <th style='width: 15%;'>total</th>
            <th style='width: 20%;'>tgl 0rder</th>
            <th style='width: 10%;'>Status</th>
          </tr>

<?php
	$query = mysqli_query($kon, "SELECT * from orders where idorder");
	$no = 1;
	while($rl = mysqli_fetch_array($query)){
		$id_anggota = $rl[idanggota];
		?>

		<tr>
			<td><?php echo "$no"; ?></td>
			<td><?php echo "$rl[noorder]"; ?></td>
			<td><?php 
		$anggota = mysqli_query($kon, "SELECT * from anggota where idanggota = '$id_anggota'");
		$ra = mysqli_fetch_array($anggota);
		 echo "$ra[nama]"; 
		 ?></td>
			<td><?php echo "$rl[alamatkirim]"; ?></td>
			<td><?php echo "Rp.$rl[total]"; ?></td>
			<td><?php echo "$rl[tglorder]"; ?></td>
			<td><?php echo "$rl[statusorder]"; ?></td>
		</tr>
<?php
	$no++;
	}
?>