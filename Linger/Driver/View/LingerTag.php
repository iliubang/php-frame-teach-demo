<?php
/*
 |------------------------------------------------------------------
 | linger.iliubang.cn
 |------------------------------------------------------------------
 | @author    : liubang 
 | @date      : 2016/3/29 12:09
 | @copyright : (c) iliubang.cn
 | @license   : MIT (http://opensource.org/licenses/MIT)
 |------------------------------------------------------------------
 */

namespace Linger\Driver\View;

class LingerTag extends LingerTagAbstract
{
    protected $tag = [
        'foreach' => ['block' => 1, 'level' => 5],
        'list'    => ['block' => 1, 'level' => 5],
        'if'      => ['block' => 1, 'level' => 5],
        'elseif'  => ['block' => 0, 'level' => 0],
        'else'    => ['block' => 0, 'level' => 0],
        'js'      => ['block' => 0, 'level' => 0],
        'css'     => ['block' => 0, 'level' => 0],
        'include' => ['block' => 0, 'level' => 0],
    ];

    public function __initalize()
    {

    }

    public function _css($attr, $content)
    {
        return "<link type=\"text/javascript\" rel=\"stylesheet\" href=\"{$attr['file']}\" />";
    }

    public function _js($attr, $content)
    {
        return "<script type=\"text/javascript\" src=\"{$attr['file']}\"></script>";
    }

    public function _list($attr, $content)
    {

    }

    public function _foreach($attr, $content)
    {
        if (!empty($attr['key']) && !empty($arrt['value'])) {
            $php = "<?php foreach ({$attr['name']} as {$attr['key']} => {$attr['value']}) { ?>";
        } else if (!empty($attr['item'])) {
            $php = '<?php foreach (' . $attr['name'] . ' as ' . $attr['item'] . ') { ?>';
        }
        $php .= $content;
        $php .= '<?php } ?>';
        return $php;
    }

    public function _include($attr, $content)
    {
        if (isset($attr['file']) && !empty($attr['file'])) {
            $view = new LingerView();
            return $view->render($attr['file']);
        }
        return '';
    }

    public function _if($attr, $content)
    {
        return "<?php if ({$attr['condition']}) { ?> {$content} <?php }?>";
    }

    public function _elseif($attr, $content)
    {
        return "<?php } elseif ({$attr['condition']}) {?> {$content} <?php }?>";
    }

    public function _else($attr, $content)
    {
        return "<?php } else  {?>";
    }
}