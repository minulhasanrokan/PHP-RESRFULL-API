<?php

	
	class ProductController
	{

		public function __construct(private Products $product){


		}
		
		public function process_request(string $method, ? string $id)
		{

			if($id)
			{
				$this->process_request_method($method, $id);
			}
			else
			{
				$this->process_request_collection_method($method);
			}

		}

		private function process_request_method(string $method, string $id)
		{
			$product = $this->product->get_product($id);

			if(!$product){
				http_response_code(404);
				echo json_encode(["message"=>"Product Not Found"]);
				return;
			}

			echo json_encode($product);
		}

		private function process_request_collection_method(string $method)
		{
			switch ($method) {
				case 'GET':
					echo json_encode($this->product->get_all_products());
					break;

				case 'POST':
					$data = (array)json_decode(file_get_contents("php://input"),true);
					
					http_response_code(201);
					$id = $this->product->create_product($data);
					echo json_encode([
						"message"=>"product created",
						"id"=>$id
					]);
					break;

				case 'PATCH':
					$data = (array)json_decode(file_get_contents("php://input"),true);
					
					http_response_code(201);
					$id = $this->product->update_product($data);
					echo json_encode([
						"message"=>"product ".$id." Updated",
						"rows"=>$rows
					]);
					break;
				
				default:
					// code...
					break;
			}
		}
	}