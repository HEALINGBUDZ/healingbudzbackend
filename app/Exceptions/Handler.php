<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
//        return parent::render($request, $exception); 
        $segment = \Illuminate\Support\Facades\Request::segment(1);

        if ($segment == 'api') {
            $message = $exception->getMessage();
//            return sendError($message, 499);
            return Response::json(array('status' => 'error', 'errorMessage' => 'Something Went Wrong', 'exception' => $message), 499);
//            return Response::json(array('status' => 'error', 'errorMessage' => $message, 'exception' => $message));
        } 
        else if($this->isHttpException($exception)){
            switch ($exception->getStatusCode()) {
                case 404:
                    return response(view('404-page'), 404);
                    break;

                case 405:
                    return response(view('404-page'), 404);
                    break;
            }
        }
        else {
//             echo 'asss';exit;
//            print_r($exception->getMessage());exit;
            if($exception->getMessage() == 'Trying to get property of non-object'){
               
                return response(view('404-page'), 404);
            }
            if($exception->getMessage() == 'The given data failed to pass validation.'){
                return parent::render($request, $exception);
            }
//            Session::flash('error', $exception->getMessage());
//        return Redirect::to(Url::previous());
            return response(view('404-page'), 404);
        }
//         return response(view('404-page'), 404);
//        if($segment == 'api'){
//            $message = $exception->getMessage(); 
//            $code=  $exception->getCode();
//
//        if($code == 0 && !$message){
//            $message = 'Sorry Invalid Url Or Bad Method'; 
//        }
//        return sendError($message, 410);
//        //return Response::json(array('status' => 'error', 'errorMessage' => $message,'exception'=>$message));
//        }else{
//            return parent::render($request, $exception);
//        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect('/');
    }

}
