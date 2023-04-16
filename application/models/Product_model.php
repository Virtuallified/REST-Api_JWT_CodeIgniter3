<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    public function list() {
        $query = $this->db->get("products")->result();
        return $query;
    }

	public function show($id = 0)
	{
        $query = $this->db->get_where("products", ['id' => $id])->row_array();
        return $query;
	}
      

    public function insert($data)
    {
        $this->db->insert('products',$data);
        return $this->db->insert_id(); 
    } 
     
    public function update($data, $id)
    {
        $data = $this->db->update('products', $data, array('id'=>$id));
        //echo $this->db->last_query();
		return $this->db->affected_rows();
    }
     
    public function delete($id)
    {
        $this->db->delete('products', array('id'=>$id));
        return $this->db->affected_rows();
    }
}
