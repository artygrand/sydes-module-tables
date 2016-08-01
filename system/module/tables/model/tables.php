<?php
/**
 * @package SyDES
 *
 * @copyright 2011-2015, ArtyGrand <artygrand.ru>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class TablesModel extends Model{
	public function create($title){
		$stmt = $this->db->prepare("INSERT INTO tables (title, content) VALUES (:title, '[]')");
		$stmt->execute(array('title' => $title));

		return $this->db->lastInsertId();
	}

	public function read($id){
		$stmt = $this->db->prepare("SELECT * FROM tables WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	public function update($data){
		$stmt = $this->db->prepare("UPDATE tables SET title = :title, content = :content, status = :status WHERE id = :id");
		$stmt->execute($data);
	}

	public function delete($id){
		$stmt = $this->db->prepare("DELETE FROM tables WHERE id = :id");
		$stmt->execute(array('id' => $id));
	}

	public function getList(){
		$stmt = $this->db->query("SELECT * FROM tables");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
