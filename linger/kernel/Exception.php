<?php
/*
 |------------------------------------------------------------------
 | linger.iliubang.cn
 |------------------------------------------------------------------
 | @author    : liubang
 | @date      : 2016/3/30 15:15
 | @copyright : (c) iliubang.cn
 | @license   : MIT (http://opensource.org/licenses/MIT)
 |------------------------------------------------------------------
 */

namespace linger\kernel;

use linger\util\Log;

class Exception
{
        /**
         * @var null|self
         */
        private static $instance = null;


        /**
         * Exception constructor.
         */
        private function __construct()
        {
                // set custom exception handler
                \set_exception_handler([$this, 'appException']);

                // set custom error handler
                \set_error_handler([$this, 'appError'], E_ALL);
        }

        /**
         * @return Exception|null
         */
        public static function getInstance()
        {
                if (!self::$instance instanceof self) {
                        self::$instance = new self();
                }

                return self::$instance;
        }

        /**
         * handle error
         *
         * @param string $message
         * @param array  $trace
         * @param string $type
         */
        public static function error($message, $trace, $type = 'Exception')
        {
                $config = \app()->getConfig();
                if ($config->get('DEBUG')) {
                        $time = \microtime(TRUE) - App::$start;
                        include $config->get('TMPL_ACTION_ERROR');
                } else {
                        $m = $message . PHP_EOL . '----------------------' . PHP_EOL;
                        if (!empty($trace)) {
                                foreach ($trace as $val) {
                                        $m .= (isset($val['file']) ? $val['file'] : '') . (isset($val['line']) ? ('[' . $val['line'] . '] ') : '') . "\t" . (isset($val['class']) ? $val['class'] : '') . ':' . (isset($val['function']) ? $val['function'] : '') . PHP_EOL;
                                }
                        }
                        Log::writeLog('exception.log', $m, 3);
                }

                exit;
        }

        /**
         * auto handle app exception
         *
         * @param \Exception $e
         */
        public function appException($e)
        {
                $trace = $e->getTrace();

                $message = $e->getMessage();
                foreach ($trace as $k => &$v) {
                        if (!isset($v['file'])) {
                                $v['file'] = '';
                        }
                        if (!isset($v['line'])) {
                                $v['line'] = 0;
                        }
                        if (!isset($v['class'])) {
                                $v['class'] = '';
                        }
                        if (!isset($v['function'])) {
                                $v['function'] = '';
                        }
                }
                self::error($message, $trace, 'Exception');
        }

        /**
         * auto handle app error
         *
         * @param $errno
         * @param $errstr
         * @param $errfile
         * @param $errline
         */
        public function appError($errno, $errstr, $errfile, $errline)
        {
                $message = "[{$errno}] {$errstr} on {$errfile} [{$errline}]";
                switch ($errno) {
                        case E_NOTICE:
                                self::error($message, [], 'System Notice');
                                break;
                        case E_USER_NOTICE:
                                self::error($message, [], 'Custom Notice');
                                break;
                        case E_WARNING:
                        case E_COMPILE_WARNING:
                                self::error($message, [], 'System Warning');
                                break;
                        case E_USER_WARNING:
                                self::error($message, [], 'Custom Warning');
                                break;
                        case E_USER_ERROR:
                                self::error($message, [], 'Custom Error');
                                break;
                        case E_ERROR:
                        case E_COMPILE_ERROR:
                        default :
                                self::error($message, [], 'System Error');
                                break;
                }
        }
}
