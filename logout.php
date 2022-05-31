<?php
session_start();
session_destroy();
echo "<p><div align='center'>Anda sudah logout, akan kami tunggu kedatangan anda selanjutnya</div><p>";
echo "<META HTTP-EQUIV='Refresh' Content='1; URL=?p=beranda'>";
?>