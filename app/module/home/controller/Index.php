<?php
/*
 |------------------------------------------------------------------
 | linger.iliubang.cn
 |------------------------------------------------------------------
 | @author    : liubang 
 | @date      : 16/3/23 下午9:02
 | @copyright : (c) iliubang.cn
 | @license   : MIT (http://opensource.org/licenses/MIT)
 |------------------------------------------------------------------
 */

namespace home\controller;

use Linger\Core\Controller;
use model\UserModel;
use Linger\Linger;
use library\tool\ApiClient;

class IndexController extends Controller
{
    /**
     * @var \model\UserModel
     */
    private $userModel = null;

    public function _init()
    {
        parent::_init();
        $this->userModel = new UserModel();
    }

    public function indexAction()
    {

        //trigger_error('elsakg', E_USER_NOTICE);die;
        throw new \Exception('this is a exception!');
        die;

//        $str = <<<HTML
//            <foreach name='aaa' item='bbb'>
//                <h1>sagdsag</h1>
//                <ul>
//                    <foreach name="bbb" item="cccd">
//
//                    </foreach>
//                </ul>
//            </foreach>
//HTML;
//        $preg = '#<(?:foreach|foreach\s+(.*))>(.*)</foreach>#isU';
//        preg_match_all($preg, $str, $info, PREG_SET_ORDER);
//        print_r($info);die;
        if (IS_GET) {
            //print_r($this->get());
            //print_r($this->userModel->getUserInfoById(1034285));
        }
        //echo 'this is Home module index controller index action';
        //echo strtolower(preg_replace('/Controller/', '', trim(strrchr(__CLASS__, '\\'),  '\\')));
        $arr = [
            ['userId' => 1034285, 'userName' => 'zhanghai'],
            ['userId' => 201502, 'userName' => '张海']
        ];
        $this->assign('title', 'template test');
        $this->assign('aaa', 'hello world');
        $this->assign('arr', $arr);
        $this->assign('flag', true);
        $this->assign('time', time());
        $this->display();
    }


    public function listAction()
    {
        $this->assign('id', $_GET['id']);
        $this->display();
    }

    public function testAction()
    {
        $_SESSION['userId'] = 1034285;
        $userModel = Linger::M('user');
        $result = $userModel->fields(array('id', 'user_name', 'reg_date'))->where(array('id' => '2'))->getRow();
        print_r($result);

        $data = array('user_name' => 'zhanghai', 'reg_date' => time());
        echo $userModel->add($data);

        $data = array('user_name' => '张海');
        echo $userModel->where(array('id' => 3))->update($data);
        print_r($_SESSION);
    }

    /**
     * 测试angularjs请求后端
     */
    public function searchAction()
    {
        if (IS_POST) {
            $name = $this->post('name');
            if ('error' !== $name && !empty($name)) {
                $result = ['status' => 1, 'data' => ['name' => $name, 'id' => 1034285], 'message' => 'ok'];
            } else {
                $result = ['status' => 0, 'data' => [], 'message' => 'test error'];
            }
            echo json_encode($result);
        }
    }

    /**
     * 测试信誉系统接口
     */
    public function getItemReviewInfoAction()
    {
        $arr = [
            'tradeType'       => 'auction',
            'appraiserId'     => '5256107',
            'appraisedUserId' => '5256121',
            'appraiserType'   => 'buyer',
            'itemId'          => '20214105'
        ];
        $apiClient = new ApiClient('http://neibuxinyu.kongfz.com/interface/api/tousu');
        $rs = $apiClient->getItemReviewInfo($arr);

        var_dump($rs);
        exit;
    }
}