<?php
namespace frontend\controllers;


use frontend\models\LoginForm;
use yii\web\Controller;
use yii\web\Request;
use frontend\models\SignatureHelper;

class LoginController extends Controller{
    public $enableCsrfValidation = false;
       //显示登录页面
    public function actionIndex(){
          //实列化Request
        $request=new Request();
        //实列化表单模型
        $model=new LoginForm();
        if ($request->isPost){
            $model->load($request->post(),"");//普通表单要填第二个参数
            if ($model->remember){
                $rm=$model->remember[0];
            }else{
                $rm=null;
            }
            if ($model->login($rm)){
                //登录成功提示成功信息
               // \Yii::$app->session->setFlash("success","登录成功");
                echo "登录成功";
                //跳转到首页
                return $this->redirect(["site/index"]);

            }


        }

        return $this->render("index");
    }

    /**
     * 注销
     */
    public function actionLogout(){
        \Yii::$app->user->logout();
        //echo '已注销';
        return $this->redirect(["site/index"]);
    }

    //测试发短信
    public function actionSms($phone){
         //验证电话号码是否正确
          //准备验证码
        $code=rand(1000,9999);

        $result=\Yii::$app->sms->send($phone,["code"=>$code]);
        if ($result->Code=="OK"){
            //发送成功将验证码保存到redis中
            $redis=new \Redis();
            $redis->connect("127.0.0.1");
            $redis->set("code_".$phone,$code,3600*6);
          //  return 'ture';
        }/*else{
            return "短信发送失败";
        }*/
       /* $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIS7TjVKveEM8U";
        $accessKeySecret = "ZCHz5t6hmYYJbzxNP1V8Fzly6NQ0Al";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = "15708435241";

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "郑先生小厨";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_120130246";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => rand(1000,9999),
           // "product" => "阿里通信"
        );

        // fixme 可选: 设置发送短信流水号
      //  $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
       // $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        var_dump($content) ;*/

    }

}