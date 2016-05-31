<?php
namespace Admin\Model\Provider;

use Silex;
use Admin\Controller\AdminController;
use Admin\Model\Service\AdminService;
use Admin\Model\Db\Db;
use Admin\View\View;
use Silex\ServiceProviderInterface;
use Silex\Provider\ServiceControllerServiceProvider;

use Admin\Model\Log\AdminLogListener;
use Admin\Model\Validation\ScrapingProgressValidation;
use Admin\Model\Validation\ScrapingProgressValidator;
use Admin\Model\Logic\Admin\ScrapingProgressLogic;
use Admin\Model\Logic\Admin\ScrapingIdmapLogic;
use Admin\Model\Logic\Admin\ScrapingImagecheckLogic;
use Admin\Model\Logic\Admin\BrandCheckLogic;

class AdminContainerProvider implements ServiceProviderInterface
{
    public function register(Silex\Application $app)
    {
        // ConfigProviderの登録
        $app->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__ . "/../../../../config/conf.json"));
        $app->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__ . "/../../../../config/message.json"));

        // ロガーの設定
        $app->register(new Silex\Provider\MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__ . '/../../../../logs/admin_application.log',
            'monolog.name' => 'admin',
            'monolog.level' => 'DEBUG'
        ));
        // ログリスナーの再定義
        $app['monolog.listener'] = $app->share(function () use ($app) {
            return new AdminLogListener($app['logger']);
        });

        // ServiceControllerServiceProvider
        $app->register(new ServiceControllerServiceProvider());

        // コントローラーの設定
        $app['controller.admin'] = $app->share(function($app) {
            return new AdminController(
                $app,
                $app['service.admin'],
                $app['monolog'],
                $app['message']
            );
        });
        /*
         * 管理画面用クラス定義
         */

        $app['service.admin'] = $app->share(function($app) {
            return new AdminService(
                $app['message'],
                $app['monolog']
            );
        });

        $app['logic.admin.freehd'] = $app->share(function($app) {
            return new FreehdLogic(
                $app['message'],
                $app['monolog']
            );
        });

        $app['db'] = $app->share(function($app) {
            return new Db($app);
        });

        $app['view.admin'] = $app->protect(function ($values) use ($app) {
            return new View(__DIR__ . '/../../../../view/', $values, 'admin');
        });
    }

    public function boot(Silex\Application $app)
    {

    }
}
