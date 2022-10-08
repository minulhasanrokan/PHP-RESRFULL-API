<?php

	class Products
	{
		private PDO $con;

		public function __construct(Database $database){

			$this->con=$database->getConnection();
		}

		public function get_all_products(){

			$sql = "select * from product";

			$all_products = $this->con->query($sql);

			$data = array();

			while ($row= $all_products->fetch(PDO::FETCH_ASSOC)) {
				
				$data[] = $row;
			}

			return $data;
		}

		public function create_product(array $data){

			$sql = "INSERT INTO product (name, size, is_available) VALUES (:name,:size,:is_available)";

			$all_products = $this->con->prepare($sql);

			$all_products->bindValue(":name",$data["name"],PDO::PARAM_STR);
			$all_products->bindValue(":size",$data["size"]?? 0,PDO::PARAM_INT);
			$all_products->bindValue(":is_available",(bool)$data["is_available"] ?? flase,PDO::PARAM_BOOL);

			$all_products->execute();

			return $this->con->lastInsertId();

		}

		public function get_product(string $id) : array | false {

			$sql = "select * from product where id=:id";

			$product = $this->con->prepare($sql);

			$product->bindValue(":id",$id,PDO::PARAM_INT);

			$data = $product->fetch(PDO::FETCH_ASSOC);

			return $data;

		}

		public function update_product(array $current, array $new){

			$sql = "update product set name=:name, size=;size, $is_available=:is_available where is=:id";

			$update = $this->con->prepare($sql);

			$update->bindValue(":name",$new['name'] ?? $current['name'],PDO::PARAM_STR);
			$update->bindValue(":size",$new['size'] ?? $current['size'],PDO::PARAM_INT);
			$update->bindValue(":is_available",$new['is_available'] ?? $current['is_available'],PDO::PARAM_BOOL);

			$update->bindValue(":id",$current['id'],PDO::PARAM_INT);

			return $update->execute();
		}
	}