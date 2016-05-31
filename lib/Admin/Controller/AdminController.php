<?php
namespace Admin\Controller;

use Silex;
use Admin\View\View;

class AdminController
{
    private $app;
    private $requestParam;
    private $service;
    private $logger;
    private $message;
    private $mailer;

    public function __construct(Silex\Application $app, $service, $logger, $message)
    {
        $this->app = $app;
        $config['debug'] = $app['debug'];
        $this->request = $app['request'];
        $this->requestParam = $app['request']->request->all();
        $this->service = $service;
        $this->logger = $logger;
        $this->message = $message;
    }

    /**
     * リクエスト処理をハンドリングする
     *
     * @param string $function
     * @param string $action
     */
    public function handling($function='', $action='')
    {
        // ファンクションがなければルートページ表示
        if (! $function) {
            return $this->renderRoot();
        }
        // アクションがない場合はインデックスページ
        if (! $action) {
            $action = 'index';
        }
        // バリデーション
        $validPrefix = 'validator.admin.' . $function;
        if (isset($this->app[$validPrefix])) {
            $this->app[$validPrefix]($this->requestParam, $action);
            $errors = $this->app['validation.error'];
            if (count($errors) > 0) {
                $result = $this->service->execute($this->requestParam, $this->app['logic.admin.' . $function], 'index');
                $this->logger->addError('バリデーションエラー  : '. print_r($errors, true));
                return $this->render($result, $function, 'index', $errors);
            }
        }

        // 専用のロジッククラスを取得して
        // サービスを実行する
        if (isset($this->app['logic.admin.'.$function])) {
            try {
                // サービスの実行
                $result = $this->service->execute($this->requestParam, $this->app['logic.admin.' . $function], $action);
                // JSON返却の場合
                if (isset($result['response_type']) && $result['response_type'] === 'json') {
                    return json_encode($result['response']);
                }
                // エラーの場合
                if (isset($result['error']) && $result['error']) {
                    return $this->render($result, $function, 'index', $result['error']);
                }
            } catch (\Exception $e) {
                return $this->renderLogicErrorPage($e);
            }
            // レイアウト指定されている場合
            if (isset($result['layout'])) {
                $action = $result['layout'];
                unset($result['layout']);
            }
            // レンダリング
            return $this->render($result, $function, $action);
        } else {
            // エラーページ
            return $this->renderErrorPage(404);
        }
    }

    /**
     * レンダリング
     *
     * @param unknown $values
     * @param unknown $function
     * @param unknown $action
     */
    public function render($values = array(), $function, $action, $error=array())
    {
        $defaults = array(
            'request' => $this->requestParam
        );

        $path = $function . '/' . $action;

        $view = $this->app['view.admin']($defaults);

        return $view->render($values, $path, 'layout', $error);
    }

    /**
     * ルートページのレンダリング
     */
    public function renderRoot()
    {
        $defaults = array(
        );
        $view = $this->app['view.admin']($defaults);
        return $view->render(array(), 'root', 'layout');
    }

    /**
     * エラーページ（例外発生時）のレンダリング
     *
     * @param unknown $code
     */
    public function renderLogicErrorPage($e)
    {

        /*
         * 管理画面専用の例外の場合
         */
        if ($e instanceof AdminException) {
            $code = $e->getMessage();
            $param = $e->getParam();
        } else {
            $code = $e->getMessage();
            $param = array();
        }

        if (isset($this->message[$code])) {
            $this->logger->addDebug('エラーコード('.$code.')');
            $this->logger->addError($this->message[$code] . ' エラー内容 : ' . print_r($param, true));
        } else {
            $this->logger->addError($this->message['ERROR_1'] . ' エラー内容 : ' . $code);
        }
        $defaults = array(
            'request' => $this->requestParam,
            'errorMessage' => $errorMessage
        );
        $view = $this->app['view.admin']($defaults);
        return $view->render(array(), 'error_logic', 'layout');
    }

    /**
     * エラーページのレンダリング
     * @param unknown $code
     */
    public function renderErrorPage($code)
    {
        $defaults = array(
            'request' => $this->requestParam,
            'error' => $code
        );
        $view = $this->app['view.admin']($defaults);
        return $view->render(array(), 'error', 'layout');
    }
}