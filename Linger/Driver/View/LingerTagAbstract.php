<?php
/*
 |------------------------------------------------------------------
 | linger.iliubang.cn
 |------------------------------------------------------------------
 | @author    : liubang 
 | @date      : 2016/3/29 12:11
 | @copyright : (c) iliubang.cn
 | @license   : MIT (http://opensource.org/licenses/MIT)
 |------------------------------------------------------------------
 */

namespace Linger\Driver\View;

use Linger\Linger;

abstract class LingerTagAbstract
{
    /**
     * @var string
     */
    protected $tagLeft;

    /**
     * @var string
     */
    protected $tagRight;

    /**
     * @var array
     */
    protected $condition = [
        'eq'    => '==',
        'neq'   => '<>',
        'gt'    => '>',
        'lt'    => '<',
        'egt'   => '>=',
        'elt'   => '<=',
    ];

    /**
     * @var array
     */
    protected $tag = [];

    public function __construct()
    {
        $this->tagLeft = Linger::C('TPL_TAG_LEFT');
        $this->tagRight = Linger::C('TPL_TAG_RIGHT');
        if (method_exists($this, '__initalize')) {
            $this->__initalize();
        }
    }

    public function parseTag($tag, &$viewContent)
    {
        if ($this->tag[$tag]['block']) {
            $preg = '#' . $this->tagLeft . $tag . '\s+(.*)' . $this->tagRight . '(.*)' . $this->tagLeft . '/' . $tag . $this->tagRight . '#isU';
        } else {
            $preg = '#' . $this->tagLeft . $tag . '\s+(.*)' . '/' . $this->tagRight . '#isU';
        }
        $status = preg_match_all($preg, $viewContent, $info, PREG_SET_ORDER);
        if ($status) {
            foreach ($info as $value) {
                if (empty($value[1])) {
                    $attr = [];
                } else {
                    $attr = $this->parseTagAttr($value[1]);
                }
                if (empty($value[2])) {
                    $value[2] = '';
                }
                $content = call_user_func_array(array($this, '_' . $tag), array($attr, $value[2], $value));
                $viewContent = str_replace($value[0], $content, $viewContent);
            }
            return true;
        } else {
            return false;
        }
    }

    public function parseTagAttr($attrStr)
    {
        $preg = '/([a-zA-Z_]+)\s*=\s*(["\'])(.*)\2/iU';
        $status = preg_match_all($preg, $attrStr, $info, PREG_SET_ORDER);
        if ($status) {
            $attr = [];
            foreach ($info as $value) {
                $attr[$value[1]] = $this->parseAttrValue($value[3]);
            }
            return $attr;
        } else {
            return false;
        }
    }

    public function parseAttrValue($attrVal)
    {
        foreach ($this->condition as $key => $val) {
            $attrVal = preg_replace("/\\s+$key\\s+/i", $val, $attrVal);
        }
        $const = get_defined_constants(true);
        foreach ($const['user'] as $name => $value) {
            if ('__' === substr($name, 0, 2)) {
                $attrVal = str_replace($name, $value, $attrVal);
            }
        }
        $preg = '/\$([a-zA-Z_\.]+)/i';
        $status = preg_match_all($preg, $attrVal, $info, PREG_SET_ORDER);
        if ($status) {
            foreach ($info as $key => $val) {
                $var = '';
                $data = explode('.', $val[1]);
                foreach ($data as $m => $n) {
                    if ($m == 0) {
                        $var .= $m;
                    } else {
                        $var .= '[\'' . $n . '\']';
                    }
                }
                $attrVal = str_replace($val[1], $var, $attrVal);
            }
        }
        return $attrVal;
    }

    public function getTags()
    {
        return $this->tag;
    }
}