<div class="card">
<div class="kepalacard">Registrasi Anggota</div>
<div class="isicard" style="text-align:center;">
<form name="form1" method="get" action="" enctype="multipart/form-data">
	<div class="dh12">
		<input type="hidden" name="p" value="<?php echo "$_GET[p]"; ?>" />
		<input type="hidden" name="idag" value="<?php echo "$_GET[idag]"; ?>" />
		<input type="text" name="noorder" placeholder="Masukkan No Order (Tanpa #)" value="<?php echo "$_GET[noorder]"; ?>"/>	
		<br><input type="submit" value="Cari No. Order" /></div>
</form>
<?php 
$sqlo = mysqli_query($kon, "select * from orders where noorder='$_GET[noorder]'");
$ro = mysqli_fetch_array($sqlo);
$sqlag = mysqli_query($kon, "select * from anggota where idanggota='$ro[idanggota]'");
$rag = mysqli_fetch_array($sqlag);
$total = number_format($ro["total"]);
?>
<form id="form2" name="form2" method="post" action="" enctype="multipart/form-data">
  <input name="idorder" type="hidden" value="<?php echo "$ro[idorder]"; ?>"> 
  <input name="tglorder" type="text" value="<?php echo "Tanggal Order : $ro[tglorder] WIB"; ?>">  
  <input name="nama" type="text" value="<?php echo "Atas nama : $rag[nama]"; ?>">  
  <input name="total" type="text" value="<?php echo "Sebesar : IDR $total"; ?>">  <p>
  <h2>Dari Rekening</h2>
  <input name="namabankpengirim" type="text" id="namabankpengirim" placeholder="Nama Bank Pengirim">
  <input name="namapengirim" type="text" id="namapengirim" placeholder="Nama Pengirim">
  <input name="jumlahtransfer" type="text" id="jumlahtransfer" placeholder="Jumlah Transfer">
  <input name="tgltransfer" type="date" id="tgltransfer" placeholder="Tanggal Transfer ex : 0000-00-00"><p>
  <h2>Ke Rekening</h2>
  <input name="namabankpenerima" type="text" id="namabankpenerima" placeholder="Nama Bank Penerima">
  <h2>Bukti Transfer</h2>
  <input name="bukti" type="file" placeholder="Nama Bank Penerima">
  <input type="submit" name="konfirmasi" value="KONFIRMASI PEMBAYARAN">
</form>
<?php
if($_POST["konfirmasi"]){
  $nmbukti  = $_FILES['bukti']['name'];
  $lokbukti = $_FILES['bukti']['tmp_name'];
  if(!empty($lokbukti)){	
    move_uploaded_file($lokbukti, "buktibayar/$nmbukti");
  }
  
  $sqlb = mysqli_query($kon, "insert into pembayaran (idorder, namabankpengirim, namapengirim, jumlahtransfer, tgltransfer, namabankpenerima, bukti) values ('$_POST[idorder]', '$_POST[namabankpengirim]', '$_POST[namapengirim]', '$_POST[jumlahtransfer]', '$_POST[tgltransfer]', '$_POST[namabankpenerima]', '$nmbukti')");
  
  if($sqlb){
  	echo "Konfirmasi Pembayaran Berhasil";
  }else{
    echo "Konfirmasi Gagal";
  }
  echo "<META HTTP-EQUIV='Refresh' Content='1; URL=?p=beranda'>";
}
?>
</div>
</div>
