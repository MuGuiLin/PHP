<?php
/**
 * 微信分享基类
 * 集成微信jssdk功能
 *
 * @version 2016-04-12
 * @author caozhong
 */
class WeixinJssdk {
	private $url;
	private $wxh;
	public function __construct($wxid = '', $url = '') {
		$this->getWeixinhao($wxid);
		$this->url = $url;
	}
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket();
		
		// 注意 URL 一定要动态获取
		$timestamp = time();
		$nonceStr = $this->createNonceStr();
		$url = urlencode($this->url);
		//$url = urldecode('http://wechat.smgtech.net/yaotv/huodong/yaoqianshu/yaoyiyao.html?fid=145');
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$this->url";//.self::url;
		$signature = sha1($string);
		
		$signPackage = array(
			'appId' => $this->wxh->appid,
			'nonceStr' => $nonceStr,
			'timestamp' => $timestamp,
			'url' => $this->url,
			'signature' => $signature,
			'rawString' => $string 
		);
		return $signPackage;
	}
	/**
	 * ajax获取signature
	 */
	private function createNonceStr($length = 16) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for($i = 0; $i < $length; $i++){
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
	/**
	 * 签名算法
	 */
	private function getJsApiTicket() {
		$cacheKey = 'weixin_jssdk_ticket_' . $this->wxh->appid;
		
		$redis = Helper::getRedis();
		$ticket = $redis->get($cacheKey);
		
		if(false === $ticket){
			$accessToken = $this->getAccessToken($this->wxh->wxid);
			// 如果是企业号用以下 URL 获取 ticket
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$accessToken;
			$res = json_decode($this->httpGet($url));
			$ticket = $res->ticket;
			if($ticket){
				$redis->set($cacheKey, $ticket);
				$redis->expire($cacheKey, 500);
			}
		}
		
		return $ticket;
	}
	/**
	 * 直接获取聚合平台接口服务器的AccessToken
	 * 当$sign的值为'refresh'时，重新获取
	 */
	public function getAccessToken($wxid, $sign = '') {
		$apiUrl = Yii::app()->params['systemApiUrl'] . 'api/AccessToken/get/appid/' . $wxid;

		if($sign == 'refresh'){
			$apiUrl = Yii::app()->params['systemApiUrl'] . 'api/AccessToken/get/appid/' . $wxid . '/type/1';
		}
		
		$data = json_decode($this->httpGet($apiUrl));
		$access_token = $data->data;
		
		return $access_token ? $access_token : false;
	}
	/**
	 * 根据微信原始id获取微信公众号信息
	 *
	 * @param unknown $appid        	
	 */
	private function getWeixinhao($wxid) {
		$wxuser = Weixinhao::model()->findByAttributes(array(
			'wxid' => $wxid 
		));
		
		if(null != $wxuser){
			$this->wxh = $wxuser;
		}
	}
	private function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		
		$res = curl_exec($curl);
		curl_close($curl);
		
		return $res;
	}
}

