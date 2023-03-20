<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->library('pagination');
	$this->load->helper('cookie');
	$this->load->model('barang_model');
  }
	
	public function index()
	{
		$data['title'] = 'Barang';
		$data['barang'] = $this->barang_model->dataAll()->result();

		$this->load->view('templates/header', $data);
		$this->load->view('barang/index');
		$this->load->view('templates/footer');
    }

    public function tambah()
	{
        $data['title'] = 'Barang';
        
		$this->load->view('templates/header', $data);
		$this->load->view('barang/form_tambah');
		$this->load->view('templates/footer');
    }
    
    public function ubah($id)
	{
        $data['title'] = 'Barang';

        //menampilkan data berdasarkan id
		$where = array('id_barang'=>$id);
        $data['data'] = $this->barang_model->detail_data($where, 'barang')->result();
        
		$this->load->view('templates/header', $data);
		$this->load->view('barang/form_ubah');
		$this->load->view('templates/footer');
	}

	public function proses_tambah()
	{
        $config['upload_path']   = './assets/upload/barang/';
		$config['allowed_types'] = 'png|jpg';
	
		$namaFile = $_FILES['photo']['name'];
		$error = $_FILES['photo']['error'];

        $this->load->library('upload', $config);
        
		$barang     =   $this->input->post('barang');
		$harga_jual = 	$this->input->post('harga_jual');
        $harga_beli = 	$this->input->post('harga_beli');
		$stok       = 	$this->input->post('stok');

        
        if ($namaFile == '') {
            $ganti = 'box.png';
        }else{
          if (! $this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            redirect('barang/tambah');
          }
          else{
  
            $data = array('photo' => $this->upload->data());
            $nama_file= $data['photo']['file_name'];
            $ganti = str_replace(" ", "_", $nama_file);

          }
      }

	  
		$data=array(
			'foto' => $ganti,
			'nama_barang'=> $barang,
			'harga_jual'=> $harga_jual,
            'harga_beli'=> $harga_beli,
			'stok'=> $stok,
		);

		$this->barang_model->tambah_data($data, 'barang');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil ditambahkan!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('barang');

	
	}

	public function proses_ubah()
	{
        $config['upload_path']   = './assets/upload/barang/';
		$config['allowed_types'] = 'png|jpg';
	
		$namaFile = $_FILES['photo']['name'];
		$error = $_FILES['photo']['error'];

        $this->load->library('upload', $config);
        
		$id         =   $this->input->post('idbarang');
		$barang     =   $this->input->post('barang');
		$harga_jual = 	$this->input->post('harga_jual');
        $harga_beli = 	$this->input->post('harga_beli');
		$stok 	    = 	$this->input->post('stok');
        $flama      = $this->input->post('fotoLama');

        if ($namaFile == '') {
            $ganti = $flama;
        }else{
          if (! $this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            redirect('barang/ubah/'.$id);
          }
          else{
  
            $data = array('photo' => $this->upload->data());
            $nama_file= $data['photo']['file_name'];
            $ganti = str_replace(" ", "_", $nama_file);
            if($flama == 'box.png'){

            }else{
              unlink('./assets/upload/barang/'.$flama.'');
            }
  
          }

      }
		
		$data=array(
			'nama_barang'=> $barang,
			'harga_jual'=> $harga_jual,
            'harga_beli'=> $harga_beli,
			'stok'=> $stok,
            'foto' => $ganti
		);

		$where = array(
			'id_barang'=>$id
		);

		$this->barang_model->ubah_data($where, $data, 'barang');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil diubah!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('barang');
	}

	public function proses_hapus($id)
	{
		$where = array('id_barang' => $id );
		$foto = $this->barang_model->ambilFoto($where);
		if($foto){
			if($foto == 'box.png'){

			}else{
				unlink('./assets/upload/barang/'.$foto.'');
			}
			
			$this->barang_model->hapus_data($where, 'barang');
		}

		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil dihapus!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
		redirect('barang');
	}

	public function getData()
	{
		$id = $this->input->post('id');
    	$where = array('id_barang' => $id );
    	$data = $this->barang_model->detail_data($where, 'barang')->result();
    	echo json_encode($data);
	}

}
