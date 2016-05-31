<?php

namespace Admin\View;

/**
 * ビュークラス
 *
 * @author toshiki.iwai
 *
 */
class View
{
    protected $viewDir;
    protected $defaults;
    protected $layout_values = array();
    protected $prefix;

    public function __construct($viewDir, $defaults, $prefix)
    {
        $this->viewDir = $viewDir;
        $this->defaults = $defaults;
        $this->prefix = $prefix;

        $this->defaults['base_url'] =  $viewDir . $prefix . '/';
    }

    /**
     * ページ参照用の変数を設定
     *
     * @param unknown $name
     * @param unknown $value
     */
    public function setLayoutVal($name, $value) {
        $this->layout_values[$name] = $value;
    }

    /**
     * レンダリング処理を行う
     *
     * @param unknown $_values
     * @param unknown $_path
     * @param string $_layout
     * @return string
     */
    public function render($_values = array(), $_path, $_layout = false, $error=array())
    {
        $_file = $this->viewDir . $this->prefix . '/' . $_path . '.php';

        if ($error) {
            $_values['_error'] = $error;
        }

        extract(array_merge($this->defaults, $_values));

        ob_start();
        ob_implicit_flush(0);

        require $_file;

        $content = ob_get_clean();

        if ($_layout) {
            $content = $this->render(
                array_merge($this->layout_values, array(
                    '_content' => $content
                )),
                $_layout,
                false
            );
        }

        return $content;
    }

    /**
     * エスケープ処理
     *
     * @param unknown $string
     * @return string
     */
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
