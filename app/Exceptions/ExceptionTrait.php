<?php
namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait{

		public function apiException($request,$re)
		{
			#if($re instanceof ModelNotFoundException)
			if($this->isModel($re))
	        {
	        	return $this->ModelResponse($re);
	            /*return response()->json([
	                'error' => 'Model Not Found'
	                ],Response::HTTP_NOT_FOUND);*/
	        }

	        #if($re instanceof NotFoundHttpException)
	        if($this->isHttp($re))
	        {
	        	return	$this->HttpResponse($re);
	            /* return response()->json([
	                    'error' => 'Incorect Route'
	                    ],Response::HTTP_NOT_FOUND);*/
	        }

	        return parent::render($request, $exception);
		}

		protected  function isModel($re)
		{
			return $re instanceof ModelNotFoundException;
		}
		protected  function isHttp($re)
		{
			return $re instanceof NotFoundHttpException;
		}

		protected  function ModelResponse($re)
		{
			return response()->json([
	                'error' => 'Model Not Found'
	                ],Response::HTTP_NOT_FOUND);
		}

		protected  function HttpResponse($re)
		{
			 return response()->json([
	                    'error' => 'Incorect Route'
	                    ],Response::HTTP_NOT_FOUND);
		}

}