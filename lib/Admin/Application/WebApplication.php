<?php
namespace Admin\Application;

use Silex;
use Admin\Provider\DynamoDBServiceWrapperProvider;

abstract class WebApplication
{
    protected $app;
    public function __construct(Silex\Application $app)
    {
        $this->app = $app;
    }
    public function execute()
    {
        try {
            $this->apiExecute();
            $this->app->run();
        } catch (\Exception $e) {
            print_r($e);
            $responseData = array(
                'status' => 'ng',
                'error' => 'エラー'
            );
            $response = $this->app->json($responseData, 200, array(
                'X-Status-Code' => 200
            ));
            $response->send();
        }
    }
    abstract protected function apiExecute();
}
