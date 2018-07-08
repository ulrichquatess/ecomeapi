<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ExceptionTrait
{
	public function apiException($request,$e)
	{
//Returns Model Not Found Exception		
		if ($this->isModel($e)) {

			return response()->json([

				'errors' => 'Product Model Not Found'

			],Response::HTTP_NOT_FOUND);
		}

// return http problem(of Not Found)
		if ($this->isHttp($e)) {
			
			return response()->json([
			  'errors' => 'Incorrect Route'
			],Response::HTTP_NOT_FOUND);
		}

//Here is in the case where by neither a model or 
//an Htpp exception Occurs it returns the normal exception
		 return parent::render($request, $e);
	}

	public function isModel($e)
	{
		return $e instanceof ModelNotFoundException;
	}

	public function isHttp($e)
	{
		return $e instanceof NotFoundHttpException;
	}
}