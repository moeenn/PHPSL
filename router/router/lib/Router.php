<?php

declare(strict_types=1);

namespace SOL5;

use \Exception;

class Router
{
  private string $m_currentURI;
  private string $m_method;
  private array $m_handlers = [];
  private array $m_middlewares = [];
  private array $m_applied_headers = [
    'Content-type:application/json; charset=UTF-8',
    'Accept:application/json',
    'X-Frame-Options: DENY',
    'X-XSS-Protection: 1; mode=block',
    'X-Content-Type-Options: nosniff',
  ];

  function __construct()
  {
    $this->m_currentURI = $this->parseCurrentURI();
    $this->m_method = $_SERVER['REQUEST_METHOD'];
  }

  private function parseCurrentURI(): string
  {
    $uri = $_SERVER['PATH_INFO'];
    if (!isset($uri)) return '/';
    return $uri;
  }

  /**
   *  add a router to known routes
   * 
   */
  private function register(RequestHandler $handler): void
  {
    foreach ($this->m_handlers as $registered_handler) {
      if ($registered_handler->URL() === $handler->URL()) {
        throw new Exception("A request handler has already been registered for route: {$handler->URL()}");
      }
    }

    array_push($this->m_handlers, $handler);
  }

  /**
   *  set all the headers before sending request to the client
   * 
   */
  private function setHeaders(): void
  {
    foreach ($this->m_applied_headers as &$header) {
      header($header);
    }
  }

  /**
   *  add new headers to be sent with all requests
   * 
   */
  public function addHeaders(array $headers): void
  {
    array_push($this->m_applied_headers, ...$headers);
  }

  /**
   *  send the final response to the client
   * 
   */
  private function returnResponse($data, int $httpStatus = 200): void
  {
    $this->setHeaders();
    http_response_code($httpStatus);
    echo json_encode($data);
  }

  /**
   *  return response in case of an \Exception
   * 
   */
  private function errorResponse(Exception $error): void
  {
    $this->returnResponse([
      'message' => $error->getMessage(),
      'trace'   => $error->getTraceAsString(),
    ], 500);
  }

  /**
   *  add middleware to list of applied middlewares
   *  response from endpoints will pass through all middlewares
   *  in the order they were registered
   * 
   */
  public function registerMiddleware($middleware): void
  {
    if (!in_array($middleware, $this->m_middlewares)) {
      array_push($this->m_middlewares, $middleware);
    }
  }

  /**
   *  pass response data through all the registered middlewares
   * 
   */
  private function applyMiddlewares($data)
  {
    $currentData = $data;

    foreach ($this->m_middlewares as &$middleware) {
      $currentData = $middleware::process($currentData);
    }

    return $currentData;
  }

  /**
   *  match the incoming request and execute the apporpriate 
   *  request handler callback
   * 
   */
  public function run(): void
  {
    foreach ($this->m_handlers as $handler) {
      if (
        $this->m_currentURI === $handler->URL() &&
        $this->m_method === $handler->method()
      ) {
        $result = $handler->dispatch();
        $result = $this->applyMiddlewares($result);
        $this->returnResponse($result);
        return;
      }

      http_response_code(404);
    }
  }

  /**
   *  register a new route with the HTTP method of GET
   */
  public function get(string $url, $callback): void
  {
    $handler = new RequestHandler('GET', $url, $callback);
    try {
      $this->register($handler);
    } catch (Exception $e) {
      $this->errorResponse($e);
      exit();
    }
  }
}
