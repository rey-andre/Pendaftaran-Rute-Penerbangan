<?php

	$berkas = "data/data.json";
	$dataJson = file_get_contents($berkas);
	$rutePenerbanganAll = json_decode($dataJson, true);

	//Array Daftar Bandara dan Pajak
	$asalPenerbangan = array ("Soekarno-Hatta (CGK)", "Husein Sastranegara (BDO)", "Abdul Rachman Saleh (MLG)", "Juanda (SUB)");									//Array bandara asal penerbangan
	$tujuanPenerbangan = array ("Ngurah Rai (DPS)", "Hasanuddin (UPG)", "Inanwatan (INX)", "Sultan Iskandarmuda (BTJ)"); 											//Aray bandara tujuan penerbangan 
	$pajakAsalPenerbangan = array ("Soekarno-Hatta (CGK)"=>50000, "Husein Sastranegara (BDO)"=>30000, "Abdul Rachman Saleh (MLG)"=>40000, "Juanda (SUB)"=>40000);	//Array pajak dari bandara asal
	$pajakTujuanPenerbangan = array ("Ngurah Rai (DPS)"=>80000, "Hasanuddin (UPG)"=>70000, "Inanwatan (INX)"=>90000, "Sultan Iskandarmuda (BTJ)"=>70000);			//Aray pajak dari bandara tujuan


	//Fungsi Menghitung Total Pajak Bandara
	/**
		Fungsi ini berguna untuk menghitung total pajak bandara yang harus dibayarkan
		-- Argumen pertama berisi pajak dari bandara asal penerbangan
		-- Argumen kedua berisi pajak dari bandara tujuan penerbangan
		-- Balikan dari Fungsi ini adalah Total Pajak yang harus dibayarkan
		Author : nama
		Tanggal : 19 Oktober 2020
	**/
	function totalPajak($pajakAsal, $pajakTujuan){
		global $pajakAsalPenerbangan, $pajakTujuanPenerbangan;											//Variabel Global

		foreach ($pajakAsalPenerbangan as $pajak1 =>$pajak1_value) {									//Mengambil biaya pajak dari bandara asal yang dipilih
			if($pajakAsal == $pajak1){
				$nilaiPajakA = $pajak1_value;
			}
		}

		foreach ($pajakTujuanPenerbangan as $pajak2 =>$pajak2_value) {									//Mengambil biaya pajak dari bandara tujuan yang dipilih
			if($pajakTujuan == $pajak2){
				$nilaiPajakB = $pajak2_value;
			}
		}

		return $nilaiPajakA + $nilaiPajakB;
	}

	/**
		Fungsi ini berguna untuk menghitung total biaya penerbangan sebuah maskapai
		-- Argumen pertama berisi total pajak dari Bandara
		-- Argumen kedua berisi harga tiket maskapai yang di input oleh user
		-- Balikan dari Fungsi ini adalah Total Biaya penerbangan
	**/
	function totalHarga($totalPajak, $hargaTiket){
		return $totalPajak + $hargaTiket;
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jadwal Penerbangan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  </head>
  <body class="bg-dark">
    <div class="container mb-5">
      <div class="row align-items-start">
        <div class="col-sm-0 col-2 bg-black"></div>
        <div class="col-8 bg-white border pb-5">
          <div class="text-center">
            <img src="img/pesawat.jpeg" class="img-fluid mt-3 pt-3" width="500" alt="pesawat" />
            <h1 class="mt-5">Pendaftaran Rute Penerbangan</h1>
          </div>

          <form class="ms-5 me-5 mt-5" action="index.php" method="post">
            <div class="row mb-3">
              <label for="maskapai" class="col-sm-3 col-form-label">Maskapai</label>
              <div class="col-sm-9">
                <input type="text" class="form-control shadow-sm" id="maskapai" name="maskapai" placeholder="Nama Maskapai" required />
              </div>
            </div>
            <div class="row mb-3">
              <label for="ruteasal" class="col-sm-3 col-form-label">Asal Bandara</label>
              <div class="col-sm-9">
                <select class="form-select shadow-sm" id="ruteasal" name="ruteasal" required>
                  	<!-- Input Bandara Asal -->
                  <!-- Perulangan untuk menampilkan Bandara Asal -->
                  <?php
                    foreach ($asalPenerbangan as $ap) {
                      echo "<option value='".$ap."'>".$ap."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="rutetujuan" class="col-sm-3 col-form-label">Bandara Tujuan</label>
              <div class="col-sm-9">
                <select class="form-select shadow-sm" id="rutetujuan" name="rutetujuan" required>
                  <!-- Perulangan untuk menampilkan Bandara Tujuan -->
                  <?php
                    foreach ($tujuanPenerbangan as $tp) {
                      echo "<option value='".$tp."'>".$tp."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="harga" class="col-sm-3 col-form-label">Harga Tiket</label>
              <div class="col-sm-9">
                <input type="number" class="form-control shadow-sm" id="harga" name="harga" placeholder="Harga Tiket" />
              </div>
            </div>
            <div class="text-center">
              <input type="submit" value="Submit" name="submit" class="btn btn-success ps-4 pe-4 pt-2 pb-2" />
            </div>
          </form>

          <!-- Menampung seluruh hasil inputan User -->
          <?php
            if(isset($_POST['submit'])){
              $maskapaiPenerbangan = $_POST['maskapai'];
              $ruteAsalPenerbangan = $_POST['ruteasal'];
              $ruteTujuanPenerbangan = $_POST['rutetujuan'];
              $hargaPenerbangan = $_POST['harga'];
              $totalPajakPenerbangan = totalPajak($ruteAsalPenerbangan, $ruteTujuanPenerbangan);
              $totalHargaPeberbangan = totalHarga($totalPajakPenerbangan, $hargaPenerbangan);

              
              $rutePenerbangan = [$maskapaiPenerbangan, $ruteAsalPenerbangan, $ruteTujuanPenerbangan, $hargaPenerbangan, $totalPajakPenerbangan, $totalHargaPeberbangan];		//Menampung inputan User kedalam Array sementara
              array_push($rutePenerbanganAll, $rutePenerbangan);																												//Memasukan Array baru kedalam Array Daftar Rute Penerbangan
              array_multisort($rutePenerbanganAll, SORT_ASC);																													//Mengurutkan Daftar Maskapai sesuai Abjad dari yang terkecil
              $dataJson = json_encode($rutePenerbanganAll, JSON_PRETTY_PRINT);
              file_put_contents($berkas, $dataJson);
            }

          ?>

          <hr />
          <!-- Tabel -->
          <div class="container mt-5">
            <div class="text-center">
              <h1>Daftar Rute Tersedia</h1>
            </div>
            <table class="table table-secondary table-responsive table-hover table-striped mt-4">
              <thead>
                <tr>
                  <th scope="col">Maskapai</th>
                  <th scope="col">Asal Penerbangan</th>
                  <th scope="col">Tujuan Penerbangan</th>
                  <th scope="col">Harga Tiket</th>
                  <th scope="col">Pajak</th>
                  <th scope="col">Total Harga Tiket</th>
                </tr>
              </thead>
              <tbody>
                <!-- Perulangan untuk menampilkan isi Array Daftar Maskapai beserta Rute Penerbangan -->
                <?php
                for($i=0; $i<count($rutePenerbanganAll); $i++){
                  
                ?>
                  <tr>
                    <td><?=$rutePenerbanganAll[$i][0]?></td>
                    <td><?=$rutePenerbanganAll[$i][1]?></td>
                    <td><?=$rutePenerbanganAll[$i][2]?></td>
                    <td><?=$rutePenerbanganAll[$i][3]?></td>
                    <td><?=$rutePenerbanganAll[$i][4]?></td>
                    <td><?=$rutePenerbanganAll[$i][5]?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-sm-0 col-2 bg-primary"></div>
      </div>
    </div>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
