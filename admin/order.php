<a href="<?php echo "?p=order&st=Semua"; ?>"><button type="button" class='btn btn-add'>TRANSAKSI SEMUA</button></a>
Status Order : 
<a href="<?php echo "?p=order&st=Baru"; ?>"><button type="button" class='btn btn-add'>Baru</button> </a>
<a href="<?php echo "?p=order&st=Lunas"; ?>"><button type="button" class='btn btn-add'>Lunas</button></a>
<a href="<?php echo "?p=order&st=Dikirim"; ?>"><button type="button" class='btn btn-add'>Dikirim</button></a>
<a href="<?php echo "?p=order&st=Diterima"; ?>"><button type="button" class='btn btn-add'>Diterima</button></a>
<br>
<?php  
$batas =  2;
$halaman = $_GET['pg'];
if(empty($halaman)){
	$posisi = 0;
	$halaman = 1;
}else{
	$posisi = ($halaman - 1) * $batas;
}

if($_GET["st"] == "Semua"){
  $status = "";
}else{
  $status = "where statusorder='$_GET[st]'";
}
  $sqlo = mysqli_query($kon, "select * from orders $status order by tglorder desc");
  $no = 1;
  while($ro = mysqli_fetch_array($sqlo)){
    if($ro['statusorder'] == "Baru"){
	  $pilb = " selected";	$pill = "";	$pilk = ""; $pilt = "";
	}
	if($ro['statusorder'] == "Lunas"){
	  $pilb = "";	$pill = " selected";	$pilk = ""; $pilt = "";
	}
	if($ro['statusorder'] == "Dikirim"){
	  $pilb = "";	$pill = "";	$pilk = " selected"; $pilt = "";
	}
	if($ro['statusorder'] == "Diterima"){
	  $pilb = "";	$pill = "";	$pilk = ""; $pilt = " selected";
	}	
 	$sqlod = mysqli_query($kon, "select * from orders where idorder='$ro[idorder]'");
	$rod = mysqli_fetch_array($sqlod);
	$sqlag = mysqli_query($kon, "select * from anggota where idanggota='$rod[idanggota]'");
	$rag = mysqli_fetch_array($sqlag);
  	echo "<div class='dh12'>";
	echo "<div class='card'>";
	echo "<div class='kepalacard'>";
	echo "#$ro[noorder]";
	echo "</div>";
	echo "<div class='isicard'>";
	echo "<br>Dipesan oleh : <b>$rag[nama]</b><br>";
	echo "Handphone &nbsp; &nbsp;: <b>$rag[nohp]</b><br>";
	echo "Alamat Email : <b>$rag[email]</b><br>";
  	echo "Dipesan pada : <b>$ro[tglorder] WIB</b><br>";
	echo "Dikirim ke : <br><b>$ro[alamatkirim]</b><br>";
	echo "<table border='0' cellpadding='3px'>";
	$sqlordt = mysqli_query($kon, "select * from orderdetail where idorder='$ro[idorder]'");
	while($rordt = mysqli_fetch_array($sqlordt)){
	  $sqlpr = mysqli_query($kon, "select * from produk where idproduk='$rordt[idproduk]'");
	  $rpr = mysqli_fetch_array($sqlpr);
	  $sqlj = mysqli_query($kon, "select * from jasakirim where idjasa='$rordt[idjasa]'");	  
	  $rj = mysqli_fetch_array($sqlj);
  	  $hrg = number_format($rpr["harga"]);
      $disk = ($rpr["harga"] * $rpr["diskon"]) / 100;
      $hargabaru = $rpr["harga"] - $disk;
      $hrgbr = number_format($hargabaru);	
      $brt = $rordt["jumlahbeli"] * $rpr["berat"];
      $berat = $berat + $brt;  
      if($rp["diskon"] > 0){
	    $diskon = "<font color='red'>-$rp[diskon]%</font>";
	    $hargalama = "<font style='text-decoration:line-through'>IDR $hrg</font>";
      }else{
	    $diskon = "";
	    $hargalama = "";
      }
	  echo "<tr valign='top'><td width='50px'><img src='../fotoproduk/$rpr[foto1]' height='50px;'></td>
	  <td><b>$rpr[nama]</b><br>$rordt[jumlahbeli] * IDR $hrgbr <br>$brt Kg * $rj[tarif] (<b>$rj[nama]</b>)</td></tr>";
	}
	echo "</table>";	
	echo "<form method='post' action='?p=orderstatus' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='idorder' value='$ro[idorder]'>";
	echo "<input type='hidden' name='st' value='$_GET[st]'>";
	echo "<select name='statusorder'>
	<option value='Baru' $pilb>Baru</option>
	<option value='Lunas' $pill>Lunas</option>
	<option value='Dikirim' $pilk>Dikirim</option>
	<option value='Diterima' $pilt>Diterima</option>
	</select>
	<input type='submit' value='Ubah Status Pesanan'>";
	echo "</form><br>";
	$total = number_format($ro["total"]);
	echo "</div>";
	echo "<div class='kepalacard'>Total : IDR $total</div>";
	echo "</div><br>";
	echo "</div>";
  }
  
echo "<div class='dh12' align='right'>";

echo "Halaman ";
		
$sqlhal = mysqli_query($kon, "select * from orders $status");
$jmldata = mysqli_num_rows($sqlhal);
$jmlhal = ceil($jmldata/$batas);

for($i=1;$i<=$jmlhal;$i++){
  if ($i == $halaman){
	echo "<span class='kotak'><b>$i</b></span> ";
  }
}

if($halaman > 1){
	$previous=$halaman-1;
	echo "<span class='kotak'><a href=?p=order&pg=$previous&st=$_GET[st]>&laquo; Prev</a></span> ";
}
else
{ 
	echo "<span class='kotak'>&laquo; Prev</span> ";
}

if($halaman < $jmlhal){
	$next=$halaman+1;
	echo "<span class='kotak'><a href=?p=order&pg=$next&st=$_GET[st]>Next &raquo;</a></span>";
}
else{ 
	echo "<span class='kotak'>Next &raquo;</span>";
}

echo " Transaksi $_GET[st] <span class='kotak'><b>$jmldata</b></span>";
echo "<p></div>";
echo "<p>&nbsp;</p>";
  ?>

