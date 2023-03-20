<?php
class barang_model extends ci_model{

    function data()
    {
        $this->db->order_by('id_barang','DESC');
        return $query = $this->db->get('barang');
    }

    public function dataAll()
    {
      $this->db->select('*');
      $this->db->from('barang as b');
      $this->db->order_by('b.id_barang','DESC');
      return $query = $this->db->get();
    }

    public function detail_join($where)
    {
      $this->db->select('*');
      $this->db->from('barang as b');
      $this->db->where('b.id_barang', $where);
      $this->db->order_by('b.id_barang','DESC');
      return $query = $this->db->get();
    }

    public function ambilFoto($where)
    {
      $this->db->order_by('id_barang','DESC');
      $this->db->limit(1);
      $query = $this->db->get_where('barang', $where);   
      
      $data = $query->row();
      $foto= $data->foto;
      
      return $foto;
    }

    public function ambilId($table, $where)
   {
       return $this->db->get_where($table, $where);
    }

    public function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
         if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return false;

    }

    public function detail_data($where, $table)
    {
       return $this->db->get_where($table,$where);
    }

    public function tambah_data($data, $table)
    {
       $this->db->insert($table, $data);
    }

    public function ubah_data($where, $data, $table)
    {
       $this->db->where($where);
       $this->db->update($table, $data);

    }



}
