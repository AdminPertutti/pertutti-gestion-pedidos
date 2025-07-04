<?php

/**
* 
*/
class Mpersona extends CI_Model
{
	
	public function getPersona(){
		$this->db->select('nombre, appaterno, apmaterno');
		$this->db->from('persona');
		$query = $this->db->get();
					
		return $query;
	}

	public function getPersonas(){
		$this->db->select('nombre,edad');
		$this->db->from('persona');
		$query = $this->db->get();
					
		return $query->result();
	}
}