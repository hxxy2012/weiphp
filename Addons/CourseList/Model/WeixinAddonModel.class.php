<?php

namespace Addons\CourseList\Model;

use Home\Model\WeixinModel;

/**
 * CourseList的微信模型
 */
class WeixinAddonModel extends WeixinModel {
	function reply() {
		$openid=get_openid();
        $user=M('user');
        //判断是否绑定
        $studentid=$user->where("openid=".'"'.$openid.'"')->getField('studentid');
        if($studentid==0){
        	$this->subscribe();
	        $openid=get_openid();
	        $url=addons_url ('Binding://Binding/login?openid='.$openid);
	        $dataArr[0]=array(
	                'Title' => '绑定',
	                'Description' => '点击图片完成账号绑定',
	                'PicUrl' => 'http://www.pp3.cn/uploads/allimg/120129/1-120129232444.jpg',
	                'Url' => $url
	            );
	        $dataArr[1]=array(
	                'Title' => '你还未绑定账号点击图片完成认证',	                
	            );
			$this->replyNews($dataArr);
        }else{
        	$data=$user->where("openid=".'"'.$openid.'"')->getField('course');

	        $url=addons_url ('CourseList://CourseList/course?openid='.$openid);
	        $url2=addons_url ('Kclass://Kclass/login');

	        $data=json_decode($data,true);                   
	        $arr=array();
	        $weekarray=array("日","一","二","三","四","五","六");
	        /*if($weekarray[date("w")]=="六"||$weekarray[date("w")]=="日"){
	            $title="今天是星期".$weekarray[date("w")];
	            $arr[0]['Title']=$title;
	            $arr[0]['PicUrl']="http://imgsrc.baidu.com/forum/w%3D580/sign=b14afd2e0cf41bd5da53e8fc61da81a0/5c6409d162d9f2d39b783eeaabec8a136227ccde.jpg";
	            $arr[0]['Url']=$url;
	            $arr[1]['Title']="点我可查看空教室\n点击图片可查看全部课表\n回复解绑可以导入新学期课表";
	            $arr[1]['Url']=$url2;
	        }else{*/
	        	$rs=curl_init();
		        $url1="http://my.hpu.edu.cn/userPasswordValidate.portal";
		        $post="Login.Token1=311309010130&Login.Token2=024361&goto=http%3A%2F%2Fmy.hpu.edu.cn%2FloginSuccess.portal&gotoOnFail=http%3A%2F%2Fmy.hpu.edu.cn%2FloginFailure.portal"; 
		        curl_setopt($rs,CURLOPT_URL,$url1);
		        //post数据来源
		        curl_setopt($rs,CURLOPT_REFERER,"http://my.hpu.edu.cn/login.portal");
		        curl_setopt($rs,CURLOPT_POST,1);
		        curl_setopt($rs,CURLOPT_POSTFIELDS,$post);  
		        curl_setopt($rs,CURLOPT_RETURNTRANSFER,1);
		        curl_setopt($rs,CURLOPT_FOLLOWLOCATION,1);
		        //跳转到数据页面
		        curl_exec($rs);
		        curl_setopt($rs,CURLOPT_URL,"http://my.hpu.edu.cn/viewschoolcalendar3.jsp");
		        curl_setopt($rs,CURLOPT_REFERER,"http://my.hpu.edu.cn/index.portal");
		        curl_setopt($rs,CURLOPT_RETURNTRANSFER,1);
		        $content=curl_exec($rs);
		        curl_close($rs);
		        $content=strip_tags($content)."<br>";
		        preg_match_all("/[0-9]+/", $content, $matches);
		        //print_r($matches);
		        $zhou=$matches[0][7];
	            $title="第".$zhou."周星期".$weekarray[date("w")]."的课表如下";
	            $arr[0]['Title']=$title;
	            $arr[0]['Url']=$url;
	            $arr[0]['PicUrl']="http://imgsrc.baidu.com/forum/w%3D580/sign=b14afd2e0cf41bd5da53e8fc61da81a0/5c6409d162d9f2d39b783eeaabec8a136227ccde.jpg";
	            $arr[1]['Title']="点我可查看空教室\n点击图片可查看本周全部课表\n回复【解绑】可以导入下学期课表";
	            $arr[1]['Url']=$url2;

	            $xingqi = date('w');
	            if(date('w')==0){
	            	$xingqi = 7;
	            }

	            foreach($data[$xingqi] as $v){
	                $arr[]['Title']=$v;
	            }
	            
	        //}

	        $this->replyNews($arr);
        }
        
		
	}
	
	// 关注公众号事件
	public function subscribe() {
		$user=M('user');
        $openid=get_openid();
        $data['openid']=$openid;
        $data['subscribe_time']=date("Y-m-d H:i",time());
        $is=$user->where("openid=".'"'.$openid.'"')->find();
        if(!$is){
            $user->add($data);
        }      
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}
}
        	
