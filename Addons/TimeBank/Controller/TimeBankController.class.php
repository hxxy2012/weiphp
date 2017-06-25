<?php

namespace Addons\TimeBank\Controller;

use Home\Controller\AddonsController;

class TimeBankController extends AddonsController {

    function _initialize() {
        parent::_initialize();
    }

    function show() {
        $param ['token'] = get_token();
        $param ['openid'] = get_openid();
        addWeixinLog('TimeBankController::show', $param);
        $map ['acount'] = 'XIXI';
        $map ['incommeExpense'] = 0;
        $data = M('time_bank')->where($map)->field("sum(amount) amount")->select();
        $in = intval($data [0] ['amount']);
        $map ['incommeExpense'] = 1;
        $data = M('time_bank')->where($map)->field("sum(amount) amount")->select();
        $out = intval($data [0] ['amount']);
        $balance = $in - $out;
        $this->assign('balance', $balance);
        $editFlg = "1";
        if ($param ['token'] == "gh_20576134fc23" &&
                ($param ['openid'] == "ogMEps6tWx4w0fsB03i4Y7vJTjao" ||
                $param ['openid'] == "ogMEps2awMek2ThngULwDOMLc-W4")) {
            $editFlg = "1";
        }
        $this->assign('editFlg', $editFlg);
        $this->display(SITE_PATH . '/Addons/TimeBank/View/default/Show.html');
    }

    function help() {
        $param ['token'] = get_token();
        $param ['openid'] = get_openid();
        addWeixinLog('TimeBankController::help', $param);
        $this->display(SITE_PATH . '/Addons/TimeBank/View/default/help.html');
    }

    function detail() {
        $param ['token'] = get_token();
        $param ['openid'] = get_openid();
        addWeixinLog('TimeBankController::detail', $param);
        $model = $this->getModel('time_bank');
        $map ['acount'] = 'XIXI';
        $data = M('time_bank')->where($map)->order('tradeDate desc')->select();
        foreach ($data as &$c) {
            $c['tradeDate'] = time_format($c['tradeDate'], 'Y-m-d');
            $c['incommeExpense'] = get_name_by_status($c['incommeExpense'], 'incommeExpense', $model['id']);
            $c['project'] = get_name_by_status($c['project'], 'project', $model['id']);
        }
        $this->assign('data', $data);
        $this->display(SITE_PATH . '/Addons/TimeBank/View/default/Detail.html');
    }

    function showAdd() {
        $param ['token'] = get_token();
        $param ['openid'] = get_openid();
        addWeixinLog('TimeBankController::showAdd', $param);
        $this->display(SITE_PATH . '/Addons/TimeBank/View/default/Add.html');
    }

    function addTime() {
        $param ['token'] = get_token();
        $param ['openid'] = get_openid();
        addWeixinLog('TimeBankController::addTime', $param);
        if ($_POST['tradeDate'] != 0) {
            $map ['acount'] = 'XIXI';
            $map ['tradeDate'] = strtotime($_POST['tradeDate']);
            $map ['incommeExpense'] = $_POST['incommeExpense'];
            $map ['project'] = $_POST['project'];
            $map ['amount'] = $_POST['amount'];
            $map ['memo'] = $_POST['memo'];
            if ($param ['token'] == "gh_20576134fc23" &&
                    $param ['openid'] == "ogMEps6tWx4w0fsB03i4Y7vJTjao") {
                $map ['handlerName'] = '爸爸';
            } else if ($param ['token'] == "gh_20576134fc23" &&
                    $param ['openid'] == "ogMEps2awMek2ThngULwDOMLc-W4") {
                $map ['handlerName'] = '妈妈';
            }
            $map ['ceateTime'] = time();
            addWeixinLog('TimeBankController::addTime', $map);
            M('time_bank')->add($map);
            unset($map);
        }
        redirect(addons_url('TimeBank://TimeBank/show', $param));
    }

    public function edit() {
        $model = $this->getModel('time_bank');
        $id = I('id');

        // 获取数据
        $data = M(get_table_name($model ['id']))->find($id);
        $data || $this->error('数据不存在！');

        if (IS_POST) {
            $Model = D(parse_name(get_table_name($model ['id']), 1));
            // 获取模型的字段信息
            $Model = $this->checkAttr($Model, $model ['id']);
            if ($Model->create() && $Model->save()) {
                $this->success('保存成功！', U('lists'));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($model ['id']);
            $this->assign('fields', $fields);
            $this->assign('data', $data);

            $this->display();
        }
    }

}
