function validateForm() {
    var barang = document.forms["myForm"]["barang"].value;
    var stok = document.forms["myForm"]["stok"].value;
    var harga_beli = document.forms["myForm"]["harga_beli"].value;
    var harga_jual = document.forms["myForm"]["harga_jual"].value;

    if (barang == "") {
        validasi('Nama Barang wajib di isi!', 'warning');
        return false;
    } else if (stok == '') {
        validasi('Stok wajib di isi!', 'warning');
        return false;
    } else if (harga_beli == '') {
        validasi('harga beli Barang wajib di isi!', 'warning');
        return false;
    } else if (harga_jual == '') {
        validasi('harga jual Barang wajib di isi!', 'warning');
        return false;
    }

}


function validasi(judul, status) {
    swal.fire({
        title: judul,
        icon: status,
        confirmButtonColor: '#4e73df',
    });
}


function fileIsValid(fileName) {
    var ext = fileName.match(/\.([^\.]+)$/)[1];
    ext = ext.toLowerCase();
    var isValid = true;
    switch (ext) {
        case 'png':
        case 'jpg':


            break;
        default:
            this.value = '';
            isValid = false;
    }
    return isValid;
}

function VerifyFileNameAndFileSize() {
    var file = document.getElementById('GetFile').files[0];


    if (file != null) {
        var fileName = file.name;
        if (fileIsValid(fileName) == false) {
            validasi('Format bukan gambar!', 'warning');
            document.getElementById('GetFile').value = null;
            return false;
        }
        var content;
        var size = file.size;
        if ((size != null) && ((size / (100 * 100)) > 3)) {
            validasi('Ukuran maximum 100kb', 'warning');
            document.getElementById('GetFile').value = null;
            return false;
        }

        var ext = fileName.match(/\.([^\.]+)$/)[1];
        ext = ext.toLowerCase();
        $(".custom-file-label").addClass("selected").html(file.name);
        document.getElementById('outputImg').src = window.URL.createObjectURL(file);
        return true;

    } else
        return false;
}