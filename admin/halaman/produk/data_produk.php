<main>
    <div class="recent">
    <div class="projects">
    <div class="card" style="background-color: white;">
					<div class="card-header">
                        <h3><i class="fa fa-plus"></i> Tambah Produk</h3>
					</div>
                    <div class="card-body">
                        <input type="hidden" id="id_produk">
                        <label for="nama_kategori"> Nama Kategori </label>
                        <select id="id_kategori" class="form-control">
                            <option value="">- Pilih -</option>
                        </select>
                        <br><br>

                        <label for="nama"> Nama Produk </label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Produk" autocomplete="off">
                        <br><br>

                        <label for="nama_kategori"> Harga </label>
                        <input type="text" class="form-control" id="harga" placeholder="Masukkan Harga Produk" autocomplete="off">
                        <br><br>

                        <label for="nama_kategori"> Deskripsi </label>
                        <input type="text" class="form-control" id="deskripsi" placeholder="Masukkan Deskripsi" autocomplete="off">
                        <br><br>

                        <label for="nama_kategori"> Gambar </label>
                        <input type="file" class="form-control" id="gambar" placeholder="Masukkan Gambar">
                        <br><br>
                        <button class="btn-primary" id="btn" onclick="insert()">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <button class="btn-primary" id="btn_update" onclick="update()" hidden>
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
				</div>
			</div>
    </div>
    <br>

			<div class="recent" >
				<div class="projects">
					<div class="card">
						<div class="card-header">
							<h3><i class="fa fa-bars"></i> Data Produk</h3>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								
								<table width="100%" id="data">
									<thead>
										<tr>
											<td width="10%">No.</td>
                                            <td width="30%">Nama Produk</td>
                                            <td>Harga</td>
                                            <td>Gambar</td>
											<td width="100%" style="padding-left: 120px;">Aksi</td>
										</tr>
									</thead>
									<tbody>
                                    
                                    </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>				
			</div>

		</main>

        <script>
    load();

    function load() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "http://localhost/Bearbucks_Coffee/admin/halaman/produk/fileAjax.php?request=1", true);

        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText);
                let empTable = document.getElementById("data").getElementsByTagName("tbody")[0];

                empTable.innerHTML = "";

                for (let key in response) {
                    if (response.hasOwnProperty(key)) {
                        let val = response[key];

                        let NewRow = empTable.insertRow(-1);
                        let nomer = NewRow.insertCell(0); 
                        let nama = NewRow.insertCell(1);
                        let harga = NewRow.insertCell(2);
                        let gambar = NewRow.insertCell(3);
                        let aksi_cell = NewRow.insertCell(4);

                        nomer.innerHTML = val['no'];
                        nama.innerHTML = val['nama'];
                        harga.innerHTML = val['harga'];
                        gambar.innerHTML = val['foto'];
                        aksi_cell.innerHTML = '<div style="padding-left: 50px;"> <button class="btn-warning" onclick="edit('+ val['id_produk'] +')" id="btn_edit"><i class="fa fa-pencil"></i> Edit</button>  <button class="btn-danger" onclick="hapus('+ val['id_produk'] +')"><i class="fa fa-trash-o"></i> Hapus</button> </div>'; 
                        
                    }
                } 

            }
        };

        xhttp.send();

        
    }

    function tampil_kategori() {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText);

                response.forEach(function(element) {
                    document.getElementById("id_kategori").innerHTML += "<option value="+element.id_kategori+">"+element.nama_kategori+"</option>";
                });
            }
        };
        xhttp.open("GET", "http://localhost/Bearbucks_Coffee/admin/halaman/kategori/fileAjax.php?request=1", true);
        xhttp.send();

    }

    tampil_kategori();

    function insert() {

        let id_kategori  = document.getElementById('id_kategori').value;
        let nama = document.getElementById('nama').value;
        let harga = document.getElementById('harga').value;
        let deskripsi = document.getElementById('deskripsi').value;

        if(nama != ''){

            let data = { id_kategori : id_kategori, nama : nama, harga : harga, deskripsi : deskripsi };
            let xhttp = new XMLHttpRequest();
            xhttp.open("POST", "http://localhost/Bearbucks_Coffee/admin/halaman/produk/fileAjax.php?request=2", true);

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    let response = this.responseText;
                    if(response == 1){
                        alert("Insert successfully.");

                        load();

                        document.getElementById("id_kategori").value = "";
                        document.getElementById("nama").value="";
                        document.getElementById("harga").value="";
                        document.getElementById("deskripsi").value="";
                    }
                }
            };

        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.send(JSON.stringify(data));
        }

    }

    function edit(id_produk) {
        let nama = document.getElementById('nama');
        let harga = document.getElementById('harga');
        let deskripsi = document.getElementById('deskripsi');
        let id_kategori = document.getElementById('id_kategori');
        let btn = document.getElementById('btn');
        let btn_edit = document.getElementById('btn_edit');
        let btn_update = document.getElementById('btn_update');
        
        btn.hidden = true;
        btn_update.hidden = false;

        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "http://localhost/Bearbucks_Coffee/admin/halaman/produk/fileAjax.php?request=4&id_produk="+id_produk, true);

        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText);

                for (let key in response) {
                    if (response.hasOwnProperty(key)) {
                        let val = response[key];

                        id_kategori.value = val['id_kategori'];
                        nama.value = val['nama'];
                        harga.value = val['harga'];
                        deskripsi.value = val['deskripsi'];
                        document.getElementById("id_produk").value = val['id_produk'];

                    }
                } 

            }
        };

        xhttp.send();
    }

    function hapus(id_produk) {
        let xhttp = new XMLHttpRequest();
        let konfirmasi = confirm("Yakin ? Mau di Hapus ?");

        if (konfirmasi) {
            xhttp.open("GET", "http://localhost/Bearbucks_Coffee/admin/halaman/produk/fileAjax.php?request=3&id_produk="+id_produk, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    let response = this.responseText;
                    if(response == 1){
                        alert("Delete successfully.");

                        load();
                    }

                }
            };

            xhttp.send();
        }
    }

    function update() {

        let id_produk = document.getElementById('id_produk').value;
        let id_kategori = document.getElementById('id_kategori').value;
        let nama = document.getElementById('nama').value;
        let harga = document.getElementById('harga').value;
        let deskripsi = document.getElementById('deskripsi').value;
        
        let btn = document.getElementById('btn');
        let btn_edit = document.getElementById('btn_edit');
        let btn_update = document.getElementById('btn_update');

        if(id_produk != ''){

        let data = { id_produk : id_produk, id_kategori : id_kategori, nama : nama, harga : harga, deskripsi : deskripsi };
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "http://localhost/Bearbucks_Coffee/admin/halaman/produk/fileAjax.php?request=5", true);

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = this.responseText;
                if(response == 1){
                    alert("Update successfully.");

                    load();

                    document.getElementById("id_kategori").value = "";
                    document.getElementById("nama").value = "";
                    document.getElementById("harga").value = "";
                    document.getElementById("deskripsi").value = "";

                    btn.hidden = false;
                    btn_update.hidden = true;
                }
            }
        };

        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.send(JSON.stringify(data));
        }
    }

    
</script>