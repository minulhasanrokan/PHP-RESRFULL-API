<?php

	class ErrorHandler
	{
		public static function handle_exception(Throwalbe $exception){

			http_response_code(500);

			echo json_encode([

				"code"=> $exception->getCode(),
				"message"=> $exception->getMessage(),
				"file"=> $exception->getFile(),
				"line"=> $exception->getLine(),

			]);

		}
	}