<?php


	declare(strict_types=1);

	spl_autoload_register(function ($class){

		require __DIR__ ."/src/$class.php";
	});

	//set_exception_handler("ErrorHandler::handle_exception");

	header("content-type:application/json; charset=UTF-8");

	$page_parts = explode("/",$_SERVER['REQUEST_URI']);

	if($page_parts[1]!='products'){
		http_response_code(404);
		exit();
	}

	$id =$page_parts[2] ?? null;

	$database = new Database("localhost","product_db","root","");

	$database->getConnection();

	$product = new Products($database);

	$product->get_all_products();

	$controller  = new ProductController($product);

	$controller->process_request($_SERVER['REQUEST_METHOD'],$id);
