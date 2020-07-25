<?php
namespace addons\NsLksms\data\extend\linksms;

class LinkSms
{
    // 账号 string
    private $corpId; 
    // 密码 string
    private $password;
    // 手机号 string
    private $mobile;
    // 调用结果
    private $response;
    // 发送内容
    private $content;
    // 签名
    private $signature;
    
    /**
     * 发送短信
     */
    public function send(){
        $url = "http://sdk2.028lk.com:9880/utf8/BatchSend2.aspx";
        $data = [
            'CorpID' => $this->corpId,
            'Pwd' => $this->password,
            'Mobile' => $this->mobile,
            'Content' => $this->content.'【' . $this->signature . '】'
        ];
        $this->sendRequest($url, $data);
        return $this->getResponse();
    }
    
    /**
     * 设置账号
     * @param unknown $corpId
     */
    public function setCorpID($corpId){
        $this->corpId = $corpId;
    }
    
    /**
     * 设置密码
     * @param unknown $password
     */
    public function setPassword($password){
        $this->password = $password;
    }
    
    /**
     * 设置签名
     * @param unknown $signature
     */
    public function setSignature($signature){
        $this->signature = $signature;
    }
    
    /**
     * 获取签名
     */
    public function getSignature(){
        return $this->signature;
    }
    
    /**
     * 设置手机号
     * @param unknown $mobile
     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    
    /**
     * 设置发送内容
     * @param unknown $content
     */
    public function setContent($content){
        $this->content = $content;
    }
    
    /**
     * 获取错误描述
     * @param unknown $code
     * @return string
     */
    private function getErrorMsg($code){
        $error_msg_arr = [
            1 => '短信配置错误',
            2 => '其他错误',
            3 => '短信配置错误',
            5 => '余额不足，请充值',
            6 => '定时发送时间不是有效的时间格式',
            7 => '提交信息末尾未签名，请添加中文的企业签名【 】',
            8 => '发送内容需在1到300字之间',
            9 => '发送号码为空',
            10 => '定时时间不能小于系统当前时间',
            100 => 'IP黑名单',
            102 => '账号黑名单',
            103 => 'IP未导白',
        ];
        if (isset($error_msg_arr[$code])) {
            return $error_msg_arr[$code];            
        } else {
            return '未知错误';
        }
    }
    
    /**
     * 发送短信
     * @param unknown $data
     */
    private function sendRequest($url, $data = []){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $url);                                      // 需要获取的 URL 地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                           // TRUE 将curl_exec()获取的信息以字符串返回
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);          // 在HTTP请求中包含一个"User-Agent: "头的字符串。
        curl_setopt($ch, CURLOPT_POST, true);                                     // TRUE 时会发送 POST 请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                              // 发送的文件
        curl_setopt($ch, CURLOPT_TIMEOUT,5);                                      // 允许 cURL 函数执行的最长秒数
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                          // false禁止对证书的验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                          // false禁止对证书状态的验证
        $this->response = curl_exec($ch);
    }
    
    /**
     * 获取响应信息
     */
    public function getResponse(){
        if ($this->response > -1) {
            return ['code' => 0, 'message' => '发送成功'];
        } else {
            return ['code' => $this->response, 'message' => $this->getErrorMsg(abs($this->response))];
        }
    }
    
}