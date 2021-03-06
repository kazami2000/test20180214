Skip to content
 
Search or jump to…

Pull requests
Issues
Marketplace
Explore
 @kazami2000 Sign out
1
0 12 ninolin/LineBot_learning
 Code  Issues 0  Pull requests 0  Projects 0  Wiki  Insights
LineBot_learning/step7_flexmsg.php
1a5f019  15 hours ago
@ninolin ninolin change name
     
183 lines (179 sloc)  4.59 KB
<?php
  	$json_str = file_get_contents('php://input'); //接收request的body
  	$json_obj = json_decode($json_str); //轉成json格式
  
  	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
  	//fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
  	$sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  	$sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  	$sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  	$msg_json = '{
		"type": "bubble",
		"hero": {
		  "type": "image",
		  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png",
		  "size": "full",
		  "aspectRatio": "20:13",
		  "aspectMode": "cover",
		  "action": {
			"type": "uri",
			"uri": "http://linecorp.com/"
		  }
		},
		"body": {
		  "type": "box",
		  "layout": "vertical",
		  "contents": [
			{
			  "type": "text",
			  "text": "Brown Cafe",
			  "weight": "bold",
			  "size": "xl"
			},
			{
			  "type": "box",
			  "layout": "baseline",
			  "margin": "md",
			  "contents": [
				{
				  "type": "icon",
				  "size": "sm",
				  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
				},
				{
				  "type": "icon",
				  "size": "sm",
				  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
				},
				{
				  "type": "icon",
				  "size": "sm",
				  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
				},
				{
				  "type": "icon",
				  "size": "sm",
				  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
				},
				{
				  "type": "icon",
				  "size": "sm",
				  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
				},
				{
				  "type": "text",
				  "text": "4.0",
				  "size": "sm",
				  "color": "#999999",
				  "margin": "md",
				  "flex": 0
				}
			  ]
			},
			{
			  "type": "box",
			  "layout": "vertical",
			  "margin": "lg",
			  "spacing": "sm",
			  "contents": [
				{
				  "type": "box",
				  "layout": "baseline",
				  "spacing": "sm",
				  "contents": [
					{
					  "type": "text",
					  "text": "Place",
					  "color": "#aaaaaa",
					  "size": "sm",
					  "flex": 1
					},
					{
					  "type": "text",
					  "text": "Miraina Tower, 4-1-6 Shinjuku, Tokyo",
					  "wrap": true,
					  "color": "#666666",
					  "size": "sm",
					  "flex": 5
					}
				  ]
				},
				{
				  "type": "box",
				  "layout": "baseline",
				  "spacing": "sm",
				  "contents": [
					{
					  "type": "text",
					  "text": "Time",
					  "color": "#aaaaaa",
					  "size": "sm",
					  "flex": 1
					},
					{
					  "type": "text",
					  "text": "10:00 - 23:00",
					  "wrap": true,
					  "color": "#666666",
					  "size": "sm",
					  "flex": 5
					}
				  ]
				}
			  ]
			}
		  ]
		},
		"footer": {
		  "type": "box",
		  "layout": "vertical",
		  "spacing": "sm",
		  "contents": [
			{
			  "type": "button",
			  "style": "link",
			  "height": "sm",
			  "action": {
				"type": "uri",
				"label": "CALL",
				"uri": "https://linecorp.com"
			  }
			},
			{
			  "type": "button",
			  "style": "link",
			  "height": "sm",
			  "action": {
				"type": "uri",
				"label": "WEBSITE",
				"uri": "https://linecorp.com"
			  }
			},
			{
			  "type": "spacer",
			  "size": "sm"
			}
		  ],
		  "flex": 0
		}
	  }';
  	$response = array (
		"replyToken" => $sender_replyToken,
		"messages" => array (
			array (
				"type" => "flex",
				"altText" => "This is a Flex Message",
				"contents" => json_decode($msg_json)
			)
		)
  	);
			
  	fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  	$header[] = "Content-Type: application/json";
  	$header[] = "Authorization: Bearer 2Fr7fGxFkjf6saT1/p8q9pyE1TuiVOA8NrvlXJEVzFQLJ9EBioEQXiNgTpJIR0t0cX3QVdk3ACvmS8Dg5SWb83oFdUCJClt8fDVnNSbxzget4YcOimWO/5pL6ZboFzYlh0YPYEqPSNys6PR5Zqdo8QdB04t89/1O/w1cDnyilFU=";
  	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  	$result = curl_exec($ch);
  	curl_close($ch);
?>
© 2019 GitHub, Inc.
Terms
Privacy
Security
Status
Help
Contact GitHub
Pricing
API
Training
Blog
About
Press h to open a hovercard with more details.
