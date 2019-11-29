<?php
/**
 * 绿化达人报名前台页面
 * @author helei
 * @version 2016-4-12
 */
class IndexController extends AdminBase {
	public $layout = 'application.modules.greenbaoliao.views.layouts.main';
	private $appid;
	private $appsecret;
	private $wxh;
//	private $wxh = 'gh_93aea36b43bf';
// 	private $wxh = 'gh_c6859b3cf46d';
	
	public function beforeAction($action){
		$this->wxh = Yii::app()->params['wxh'];
		$this->getWeixin( $this->wxh );
		return true;
	}
	
	/**
	 * 绿化达人报名首页
	 */
	public function actionIndex() {
		$type = intval( Yii::app()->request->getParam( 'type', null ) );
		// 验证用户信息
		$openid = Yii::app()->request->getParam( 'openid', null );
// 		$openid = 'oTBm-w5KRT1AEo1J9THun_20ASlU';//测试
		if (null == $openid) {
			//$this->getWeixin( $this->wxh );
			$redirectUrl = urlencode( Yii::app()->createAbsoluteUrl( 'greenbaoliao/index/location/', array(
					'type' => $type 
			) ) );
			// 通过snsapi_base获取用户openid
			$curlUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . $redirectUrl . '&response_type=code&scope=snsapi_base#wechat_redirect';
			
			header( "Location: $curlUrl" );
			exit;
		} else {
			$userinfo = MediaMember::model()->findByAttributes( array(
					'openid' => $openid 
			) );
		}
		$subscribe = $this->getUserInfo($openid);
		if (null == $userinfo) {//用户未注册
			//Yii::app()->runController( '/wap/register/index/openid/'.$openid.'/id/'.$this->wxh );
			$cookieKey = 'Media_wx' . $_COOKIE[$this->wxh] . "_register";
			$coo = new CHttpCookie($cookieKey, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			Yii::app()->request->cookies[$cookieKey]=$coo;
			$this->redirect( Yii::app ()->createAbsoluteUrl ('/wap/register/index/openid/'.$openid.'/id/'.$this->wxh.'/isnew/1'));
			Yii::app()->end();
		}
		//判断用户是否已经报名
// 		$greenBaoliao=GreenBaoliao::model()->find("userid=$userinfo->id");
// 		$greenBaoliao = null;//测试
// 		if(null == $greenBaoliao){//还没有报名
// 			$redis = new redis();
// 			$redis->connect( Yii::app()->params['redis']['host'], Yii::app()->params['redis']['port'] );
			$systemKey = 'greenbaoliao_system';
			$data = null;
			$systemdata = Yii::app()->cache->get($systemKey);
			if(false != $systemdata){
				$result = json_decode($systemdata);
				$data['details'] = $result->details;
				$data['start_time'] = $result->start_time;
				$data['sponsor'] = $result->sponsor;
				$data['organizer'] = $result->organizer;
			}
			
			/**
			 设置微信js-jdk
			 */
			$wx = Wxuser::model ()->findByAttributes ( array (
				'wxid' => $this->wxh
			) );
			$accessToken = $this->getAccessTokenNew();
			$jsapiTicket = $this->getJsapi_ticket($accessToken);
			$nowtime = time();
			
			$wxsha1Str = sha1('jsapi_ticket='.$jsapiTicket.'&noncestr=Wm3WZYTPz0wzccnW&timestamp='.$nowtime.'&url='.Yii::app()->request->hostInfo.$_SERVER['REQUEST_URI']);
			
			
			
			$this->render( 'register', array(
					'openid' => $openid,
					'data' => $data,
					'subscribe'=>$subscribe,'jsapiTicket'=>$jsapiTicket, 'wxsha1Str'=>$wxsha1Str, 'appid'=>$wx->appid, 'nowtime'=>$nowtime
			) );
	}
	/**
	 * 绿化达人报名表单页面
	 */
	public function actionRegister(){
	    if(isset($_GET['from']) && !empty($_GET['from'])){
	        $this->redirect( Yii::app ()->createAbsoluteUrl ( 'greenbaoliao/index/index/' ));
	        Yii::app()->end();
	    }
		$openid = Yii::app()->request->getParam( 'openid', null );
		$userinfo = MediaMember::model()->findByAttributes( array(
				'openid' => $openid
		) );
		
		if(empty($userinfo)){
			$this->redirect(Yii::app()->createAbsoluteUrl('greenbaoliao/index/index/'));
			die();
		}else{
		    $greenBaoliao=GreenBaoliao::model()->find("userid=$userinfo->id");
		    if($greenBaoliao){//已经报名
    		    $this->redirect(Yii::app()->createUrl('greenguajiang/index/index',array('openid'=>$userinfo->openid)));die;
		    }
		}
		$this->render("do",array(
				'userinfo'=>$userinfo
		));
	}

	/**
	 * 绿化达人报名提交页面
	 */
	public function actionSubmit() {
		
// 		$model->type = intval( Yii::app()->request->getParam( 'type', null ) );
		$openid = addslashes( Yii::app()->request->getParam( 'uid', null ) );
		$userinfo = MediaMember::model()->findByAttributes( array(
				'openid' => $openid 
		) );
		if (null == $userinfo) {
			echo 400;//用户信息为空
			Yii::app()->end();
		}
		//判断用户之前是否已经报名
		$greenbaoliao = GreenBaoliao::model()->find("userid=$userinfo->id");
		if(null != $greenbaoliao){
			echo 402;die;//用户已经报名了
		}
		$model = new GreenBaoliao();
		$model->userid = $userinfo->id;
// 		$model->userid = 2;//测试用的
		$model->author = addslashes( Yii::app()->request->getParam( 'name', null ) );
		$model->mobile = addslashes( Yii::app()->request->getParam( 'phone', null ) );
		$model->content = addslashes( Yii::app()->request->getParam( 'content', null ) );
		$imgs = Yii::app()->request->getParam( 'picture', null );
		if (null != $imgs) {
			$model->images = json_encode( $imgs );
		}
		$files = Yii::app()->request->getParam( 'video', null );
		if (null != $files) {
			$model->files = json_encode( $files );
		}
		$model->dateline = time();
		if ($model->save()) {
			echo 200;//提交成功
// 			$this->refresh();
		} else {
			echo 401;//信息存储失败
		}
	}
	
	/**
	 * 微信回跳页面
	 */
	public function actionLocation() {
		header( 'Content-type: text/html; charset=utf-8' );
		$code = Yii::app()->request->getParam( 'code', null );
		$type = Yii::app()->request->getParam( 'type', null );
		
		$this->getWeixin( $this->wxh );
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code';
		$curlReturnData = $this->snsapiCurl( $url );
		$dejsonData = json_decode( $curlReturnData );
		
		$redirectUrl = Yii::app()->createAbsoluteUrl( 'greenbaoliao/index/index', array(
				'type' => $type,
				'openid' => $dejsonData->openid 
		) );
		
		header( "Location: $redirectUrl" );
	}
	/**
	 * CURL远程请求
	 */
	private function snsapiCurl($api) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $api );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		
		$json = curl_exec( $ch );
		curl_close( $ch );
		return $json;
	}
	/**
	 * 获取微信号信息
	 */
	private function getWeixin($id) {
		$wx = Wxuser::model()->findByAttributes( array(
				'wxid' => $id 
		) );
		if (null == $wx) {
			exit();
		} else {
			$this->appid = $wx->appid;
			$this->appsecret = $wx->appsecret;
		}
	}
	/**
	 * 用户是否关注
	 */
	private function getUserInfo($openid) {
		require_once "jssdk.php";
		$this->getWeixin( $this->wxh );
		//$jssdk = new JSSDK ( $this->appid, $this->appsecret, $_REQUEST ["url"] );
		$access_token = $this->getAccessTokenNew();
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
		$data = $this->snsapiCurl ( $url );
		$jsonData = json_decode ( $data );
		return $jsonData->subscribe;
	}
	
	public function getAccessTokenNew() {
    	$cacheKey = 'weixin_access_token_news';
    	$access_token = Yii::app ()->cache->get ( $cacheKey );
    	if (false == $access_token) {
    		$wxuser = Wxuser::model ()->findByAttributes ( array (
    			'wxid' => $this->wxh
    		) );
    		$apiUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->appsecret;
    
    		$data = json_decode ( $this->snsapiCurl ( $apiUrl ) );
    		$access_token = $data->access_token;
    		Yii::app ()->cache->set ( $cacheKey, $access_token, $data->expires_in );
    	}
    		
    	return $access_token ? $access_token : false;
    }
    /**
     * 从微信接口获取jsapi_ticket
     */
    public function getJsapi_ticket($accessToken){
    	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=jsapi";
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$r = curl_exec($ch);
    	$result = json_decode ($r ,true);
    	if($result){
    		return $result['ticket'];
    	}else{
    		return null;
    	}
    }
}