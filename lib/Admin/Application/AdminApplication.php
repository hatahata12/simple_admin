<?php
namespace Admin\Application;

use Silex;
use Silex\ServiceProviderInterface;
use Admin\Application\WebApplication;

class AdminApplication extends WebApplication
{
    protected function apiExecute()
    {

        $this->app->get('/', "controller.admin:handling");
        $this->app->get('/{function}/', "controller.admin:handling");
        $this->app->post('/{function}/{action}', "controller.admin:handling");
        $this->app->register(new \Admin\Model\Provider\AdminContainerProvider());
    }
}
