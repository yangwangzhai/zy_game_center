var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var schedule = require("node-schedule");
var crypto = require('crypto');
var http_server = require("http");

app.get('/',function(req,res){
	res.send('<h1>Welcome Realtime Server</h1>');
});

var ChannelID = 1;
var ActiveID = 13;
var RoomID = 3;
var sql_where = ' AND ChannelID = '+ChannelID+' AND ActiveID = '+ActiveID+' AND RoomID = '+RoomID;

//连接mysql
var mysql  = require('mysql'); 
var db_config = {
	host     : '192.168.1.138',  //'10.1.0.23'
	user     : 'root', //h5game
	password : 'abc',    //gxzy20160229
	port: '3306',                  
	database: 'zy_gamecenter' //zy_racedog
};
var connection;
var connectionCount = 0;
function handleDisconnect() {

	connection = mysql.createConnection(db_config);                                            
	connection.connect(function(err) {             
		if(err) {                                    
			console.log('进行断线重连：' + new Date() + err);
			meter1 = setTimeout(handleDisconnect, 2000);   //2秒重连一次
			connectionCount ++;
			if(connectionCount > 10) clearTimeout(meter1);
			return;
		}        
	
		console.log('连接成功'); 

	});                                                                          

	connection.on('error', function(err) {
		console.log('db error', err);
	
		if(err.code === 'PROTOCOL_CONNECTION_LOST') {
			handleDisconnect();                        
		} else {                                     
			throw err;                                
		}
	});

}

handleDisconnect();



//在线用户
var onlineUsers = {};
//当前在线人数
var onlineCount = 0;
var base_onlinecount = 0;

var hostStr = '192.168.1.178';//'h5game.gxtianhai.cn';

//PHP控制器那边的key
var openidkey = 'wx263e9fc25c21324f';
var ishasZG = false; //是否有资格当赛场主

var SCZwingold = 0;

var time = 0;
var socketGlobal = null;

var game_id = 0 ;//初始化游戏场次
var pre_game_id = 0;//上一句游戏ID

var the_first_get_speed = true;//是否是第一个请求速度的人
var dogspeeds = null;//狗狗的速度；

var speedsGlobal  = null;

//赛场主候选列表
var scz_list = [];

var sczOpenid = 'zyracedog20160418';
var curr_scz = {openid:sczOpenid};//当前赛场主
var SCZ_ZG_GOLD = 50000;

//获取系统时间
var dateNow = new Date();		
var year = dateNow.getFullYear();
var month = dateNow.getMonth();
var day = dateNow.getDate();		
var date = new Date(year,month,day,0,0,0).getTime()/1000;
console.log(date);
var gameTime = (Date.parse(dateNow)/1000-date)%50;

//查询最新的gameid
connection.query("SELECT id FROM zy_racedog_game WHERE 1 "+sql_where+" ORDER BY id DESC limit 1",function (err, result) {
	if(err){
		 console.log('[SELECT reckon_to_ ERROR] - ',err.message);
		return;
	}   
	if(result[0] != null)	game_id= result[0].id;
	
	//查询上一局的gameid
	connection.query("SELECT id FROM zy_racedog_game WHERE id < "+game_id+" "+sql_where+" ORDER BY id DESC limit 1",function (err1, result1) {
		if(err1){
			 console.log('[SELECT reckon_to_ ERROR] - ',err1.message);
			return;
		}   
		if(result1[0] != null)	pre_game_id= result1[0].id;
			 
			
	}); 
		
});

	

io.on('connection',function(socket){
	console.log('a user connectioned');
	socketGlobal = socket;
	//监听新用户加入
	socket.on('login',function(obj){
		//将新加入用户的唯一标识当作socket的名称
		socket.name = obj.openid;

		//检查在线列表，如果不在里面就加入
		if(!onlineUsers.hasOwnProperty(obj.openid)){
			onlineUsers[obj.openid] = obj.nickname;
			//在线人数+1
			onlineCount++;
		}	
		
		
		//查询当前狗狗下注的情况返回客户端
		var  userGetSql = "SELECT sum(gold) as sum_gold,dog FROM zy_racedog_bet_on where gameid="+game_id+" "+sql_where+" group by  dog ";//查
		var  xiazahu_array = {dog2:0,dog3:0,dog4:0,dog5:0};
		connection.query(userGetSql,function (err, result) {
			if(err){
			  console.log('[SELECT beton_again ERROR] - ',err.message);
			  return;
			}   
			if(result != null && result[0] != null){
				for(var key in result){
					if(result[key].dog == 2) xiazahu_array.dog2 = result[key].sum_gold
					if(result[key].dog == 3) xiazahu_array.dog3 = result[key].sum_gold
					if(result[key].dog == 4) xiazahu_array.dog4 = result[key].sum_gold
					if(result[key].dog == 5) xiazahu_array.dog5 = result[key].sum_gold
				}
				
			}
			 console.log('get_cur_xiazhu');
			 console.log(result);
			socket.emit('get_cur_xiazhu',{	xiazahu_array:xiazahu_array })	
		})
		
		
		//查询当前玩家狗狗下注的情况返回客户端
		var  myGetSql = "SELECT dog,sum(gold) as gold FROM zy_racedog_bet_on WHERE openid='"+  obj.openid +"' AND  gameid="+game_id+" "+sql_where+" group by  dog";//查
		var  my_xiazahu_array = {dog2:0,dog3:0,dog4:0,dog5:0};
		connection.query(myGetSql,function (err, result) {
			if(err){
			  console.log('[SELECT beton_again ERROR] - ',err.message);
			  return;
			}   
			if(result != null && result[0] != null){
				for(var key in result){
					if(result[key].dog == 2) my_xiazahu_array.dog2 = result[key].gold
					if(result[key].dog == 3) my_xiazahu_array.dog3 = result[key].gold
					if(result[key].dog == 4) my_xiazahu_array.dog4 = result[key].gold
					if(result[key].dog == 5) my_xiazahu_array.dog5 = result[key].gold
				}
				
			}
			 console.log('my_my_xiazhu');
			 console.log(result);
			socket.emit('get_my_xiazhu',{	xiazahu_array:my_xiazahu_array })	
		})
		
		
		
		var  total_gold = 0;
		var  userGetSql = "SELECT * FROM zy_racedog_player WHERE openid= '" + obj.openid +"' "+sql_where;//查
		connection.query(userGetSql,function (err, result) {
			if(err){
			  console.log('[SELECT beton_again ERROR] - ',err.message);
			  return;
			}   
			if(result != null && result[0] != null){
				total_gold = result[0].total_gold;
			}/*else{
				total_gold = 50000;
				var  sqldateNow = new Date();	
				var  timestamp=Date.parse(sqldateNow)/1000;
				var  userAddSql = 'INSERT INTO zy_racedog_player(nickname,openID,sex,head_img,total_gold,addtime) VALUES(?,?,?,?,?,?)';
				var  userAddSql_Params = [obj.nickname, obj.openid, obj.sex, obj.headimgurl,50000, timestamp];
				connection.query(userAddSql,userAddSql_Params,function (err, result) {
					if(err){	
						console.log('[INSERT ERROR] - ',err.message);	
						return;
					}   
					
					console.log('INSERT ID:',result.insertId); 
				});	
				
				
			}*/
			
		console.log(total_gold);				
		socket.emit('login',{seconds:gameTime,total_gold:total_gold});
		});		
	
		
		
		
		
		
		//查询数据库赛场主
		var getSCZsql = 'SELECT p.nickname,p.total_gold,p.openid,s.openid,s.id  FROM zy_racedog_player p,zy_racedog_scz s WHERE p.openid=s.openid AND p.ChannelID=s.ChannelID AND p.ActiveID=s.ActiveID AND p.RoomID=s.RoomID ORDER BY s.Issuper ASC,s.id ASC ';
		connection.query(getSCZsql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
				console.log(result);
				curr_scz = {openid:result[0].openid};
				io.emit('CurrSCZ',{SCZName:result[0].nickname,SCZOpenid:result[0].openid,SCZGold:result[0].total_gold});
		});	
		
			
		//删除	
		var delOnlinesql = "DELETE FROM zy_racedog_online  WHERE openid='"+obj.openid+"' "+sql_where;
			console.log(delOnlinesql);		
		connection.query(delOnlinesql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}  
		
		});
		
		//插入登录人的信息
		var  sqldateNow = new Date();	
		var  timestamp=Date.parse(sqldateNow)/1000;
		var  userAddSql = 'INSERT INTO zy_racedog_online(openid,addtime,ChannelID,ActiveID,RoomID) VALUES(?,?,?,?,?)';
		var  userAddSql_Params = [obj.openid, timestamp, ChannelID, ActiveID, RoomID];
		connection.query(userAddSql,userAddSql_Params,function (err, result) {
			if(err){	
				console.log('[INSERT ERROR] - ',err.message);	
				return;
			}   
			
			console.log('INSERT ID:',result.insertId); 
		});	
		
		
		//查询在线人数
		var getOnlinesql = 'SELECT count(*) as num FROM zy_racedog_online WHERE 1 '+sql_where;
		connection.query(getOnlinesql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
			
				//向所有客户端广播用户加入
				var  base_onlinecountGetSql = "SELECT * FROM zy_racedog_online_count WHERE 1 "+sql_where+" limit 1";//查寻在线人数基数
				connection.query(base_onlinecountGetSql,function (err, result2) {
					if(err){
					  console.log('[SELECT base_onlinecount ERROR] - ',err.message);
					  return;
					}   
					if(result2 != null && result2[0] != null){
						base_onlinecount = Number(result2[0].base_onlinecount);
					}
				});
				io.emit('onlineCount',{onlineCount:result[0].num+base_onlinecount});
		});	
		
	
			
		

	
		console.log(obj.nickname+'加入了');
	});
	
	
	
	
	
	//监听下注提交
	socket.on('beton',function(obj){
		//var userModSql = 'UPDATE userinfo SET UserName = ?,UserPass = ? WHERE Id = ?';
		//console.log('UPDATE affectedRows',result.affectedRows);
		console.log(obj);
		var bet_gold_sum = 0;
		for(var i in obj){
			if(obj[i].gold == 0) continue;
			//与PHP控制器那边以同样的格式加密，对比是否信息一致
			var key = md5(openidkey + obj[i].dog  + obj[i].gold + game_id);			
			if(key == obj[i].key) bet_gold_sum ++;
		
		}		
		if(bet_gold_sum ==  obj.length){
			console.log('下注成功！');
			io.emit('beton_return',obj);
		}
		//connection.end();	    
	});
	
	//监听重复下注
	socket.on('beton_again',function(obj){
		console.log( 'game_id:'+game_id );
		
		if(obj == null || obj == '') return;
		var bet_gold_sum = 0;//下注总数（用于扣减账户金币）
		var result = obj;
		for(var i in obj){
			if(obj[i].gold == 0) continue;
			//与PHP控制器那边以同样的格式加密，对比是否信息一致
			var key = md5(openidkey + obj[i].dog  + obj[i].gold + game_id);			
			if(key == obj[i].key) bet_gold_sum ++;
			
		
		}	
		
		
		
		console.log('openid:'+obj[0].openid);
		var obj_array = {dog2:null,dog3:null,dog4:null,dog5:null};
		var obj_array_return = [];
		var  old_game_id = Number(game_id) - 1;
		var  userGetSql = "SELECT dog,gold FROM zy_racedog_bet_on WHERE openid= '" + obj[0].openid + "' AND gameid="+ old_game_id +sql_where;//查
		connection.query(userGetSql,function (err, result) {
			if(err){
			  console.log('[SELECT beton_again ERROR] - ',err.message);
			  return;
			}   
			console.log( userGetSql );
			
			
			
		
		});
		
		if(obj[i].dog ==  '0'){		
				console.log('obj.lenght:'+ obj.lenght );		
		   		//io.emit('beton_return',obj_array_return);//广播给所有客户端
		   		io.emit('beton_again_return_'+obj[0].openid,obj_array);  //给该用户返回重复下注的结果
			
		}
		
		if(obj[i].dog ==  '-1'){		
				console.log('obj.lenght:'+ obj.lenght );	
				obj_array.dog2 = '-1';		   		
		   		io.emit('beton_again_return_'+obj[0].openid,obj_array);  //给该用户返回重复下注的结果
				return ;
			
		}
		
		for(var key in result){
				
				var dogNumber = Number(result[key].dog);
				switch(dogNumber){
					case 2:
						obj_array.dog2 = result[key].gold;
						obj_array_return[0] = {dog:2,gold:result[key].gold}
						break;
					case 3:
						obj_array.dog3 = result[key].gold;
						obj_array_return[1] = {dog:3,gold:result[key].gold}
						break;
					case 4:
						obj_array.dog4 = result[key].gold;
						obj_array_return[2] = {dog:4,gold:result[key].gold}
						break;
					case 5:
						obj_array.dog5 = result[key].gold;
						obj_array_return[3] = {dog:5,gold:result[key].gold}
						break;
				}
			    
				
	
				//result_array.push(obj_array);
			}
		
		
		   if(bet_gold_sum ==  obj.length){
				console.log('重复下注成功！');
			 	console.log( obj_array );  
		   		io.emit('beton_return',obj_array_return);//广播给所有客户端
		   		io.emit('beton_again_return_'+obj[0].openid,obj_array);  //给该用户返回重复下注的结果
				var new_gold = getYD(obj[0].openid);
			}
		
		
	});
	
	
	
	//查询重复下注信息
	socket.on('select_beton_again',function(obj){		
		if(obj == null || obj == ''){
			 socket.emit('re_select_beton_again',{status:-1});
			 return;
		}
		
		 connection.query("SELECT dog,gold FROM zy_racedog_bet_on WHERE  gameid="+ pre_game_id +"  AND openid='" +obj + "' "+sql_where+" order by dog" ,function (err2, result2) {
	  
		  if(result2[0] == null || result2[0].gold == '' ){ 
		 	socket.emit('re_select_beton_again',{status:-1});			
		  	return false;	
		   }		  		
		   socket.emit('re_select_beton_again',{status:0,result:result2}); 
		
	  });
		
	})

	
	/*
	//计算结果
	socket.on('reckon',function(obj){
	
	  connection.query("SELECT sum(last_gold) as last_gold,openid  FROM zy_bet_on WHERE  gameid="+ game_id +" AND openid='" +obj.openid + "'" ,function (err2, result2) {
	  
	   var new_gold = getYD(result2[0].openid);//获取烟豆接口，现在还没有接口所以还是只查询本系统数据库				
       io.emit('reckon_to_'+result2[0].openid,{gold:result2[0].last_gold,new_gold:new_gold}); 
		
	  });
	  //更新赛场主信息SCZwingold
	 connection.query("SELECT total_gold   FROM zy_player WHERE  openid='" +curr_scz.openid + "'" ,function (err, result) {	  
	 		  //返回赛场主
			 connection.query("SELECT sum(last_gold) as last_gold  FROM zy_bet_on WHERE  gameid=" + game_id ,function (err, result2) {	  
						
			        SCZwingold = result2[0].last_gold;
				
			  });
				
				
       io.emit('update_scz_yd',{gold:result[0].total_gold,SCZwingold:SCZwingold}); 
		
	  });
	  
	 
		
		
	});*/

	
	//计算结果
	socket.on('reckon',function(obj){
	
	  connection.query("SELECT *  FROM zy_racedog_bet_on WHERE  gameid="+ game_id +"  AND openid='" +obj.openid + "' "+sql_where+" order by dog" ,function (err2, result2) {
	  
	  if(result2[0] == null || result2[0].openid == '' ) return false;	
	   var new_gold = getYD(result2[0].openid);//获取烟豆接口，现在还没有接口所以还是只查询本系统数据库				
       io.emit('reckon_to_'+result2[0].openid,{result:result2}); 
		
	  });
	  //更新赛场主信息SCZwingold  " +curr_scz.openid + "
	 connection.query("SELECT total_gold   FROM zy_racedog_player WHERE  openid='" +curr_scz.openid + "' "+sql_where ,function (err, result) {	  
	 		  //返回赛场主
			 connection.query("SELECT sum(last_gold)as last_gold ,dog  FROM zy_racedog_bet_on WHERE  gameid="+ game_id +" "+sql_where+" GROUP BY dog",function (err, result2) {	  
						
			     SCZwingold = result2;
				 io.emit('update_scz_yd',{gold:result[0].total_gold,SCZwingold:SCZwingold}); 
			  });
				
				
      
		
	  });
	  
	 
		
		
	});
	
	
	//监听用户退出
	socket.on('disconnect',function(){
		//将退出的用户从在线列表中删除
		if(onlineUsers.hasOwnProperty(socket.name)){
			//退出用户信息
			var obj = {userid:socket.name,username:onlineUsers[socket.name]};
			//删除
			delete onlineUsers[socket.name];
			//在线人数-1
			onlineCount--;

			//向所有客户端广播用户退出
			io.emit('logout',{onlineUsers:onlineUsers,onlineCount:onlineCount,user:obj});
			console.log(obj.username+'退出了');
		}
		//如果退出的是赛场主，更新赛场主
		if(curr_scz.openid == socket.name){
			var delSCZsql = "DELETE FROM zy_racedog_scz  WHERE openid='"+curr_scz.openid+"' AND Issuper=0 "+sql_where;
			console.log(delSCZsql);		
			connection.query(delSCZsql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   			
				//查询数据库赛场主
				var getSCZsql = 'SELECT p.nickname,p.total_gold,p.openid,s.openid,s.id  FROM zy_racedog_player p,zy_racedog_scz s WHERE p.openid=s.openid AND p.ChannelID=s.ChannelID AND p.ActiveID=s.ActiveID AND p.RoomID=s.RoomID ORDER BY s.Issuper ASC,s.id ASC ';
				connection.query(getSCZsql,function (err2, result2) {
						if(err2){	
							console.log('[SELECT ERROR] - ',err2.message);	
							return;
						}   
						console.log(result2);
						curr_scz = {openid:result2[0].openid};
						io.emit('CurrSCZ',{SCZName:result2[0].nickname,SCZOpenid:result2[0].openid,SCZGold:result2[0].total_gold});
				});	
				
			});
		}
		
		
		
		//删除	
		var delOnlinesql = "DELETE FROM zy_racedog_online  WHERE openid='"+socket.name+"' "+sql_where;
			console.log(delOnlinesql);		
		connection.query(delOnlinesql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}  
		
		});
		
		
		
		//查询在线人数
		var getOnlinesql = 'SELECT count(*) as num FROM zy_racedog_online WHERE 1 '+sql_where;
		connection.query(getOnlinesql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
			
				//向所有客户端广播用户加入
				var  base_onlinecountGetSql = "SELECT * FROM zy_racedog_online_count WHERE 1 "+sql_where+" limit 1";//查寻在线人数基数
				connection.query(base_onlinecountGetSql,function (err, result2) {
					if(err){
					  console.log('[SELECT base_onlinecount ERROR] - ',err.message);
					  return;
					}   
					if(result2 != null && result2[0] != null){
						base_onlinecount = Number(result2[0].base_onlinecount);
					}
				});
				io.emit('onlineCount',{onlineCount:result[0].num+base_onlinecount});
		});	
		
	});

	//监听用户发布聊天内容
	socket.on('message',function(obj){
		//向所有客户端广播发布的信息
		io.emit('message',obj);
		console.log(obj.username+'说: '+obj.content);
	});
	
	//监听用户送的狗狗是信息
	//Math.random()*(20-10)+10 返回10-20之间的随机数
	//Math.ceil(Math.random()*(38-8)+8) 返回8-38之间的随机数，并取整
	socket.on('dogInfo',function(obj){
		if(the_first_get_speed){
			/*var total = obj.wholeplace ? obj.wholeplace : 800;//跑道全长
			var num = obj.frequency ? obj.frequency : 0.2;  //跑动频率，即刷新移动的时间
			var dog = obj.dogs ? obj.dogs : 5;		//狗狗数量
			var minspeed = obj.minspeed ? obj.minspeed: 5;		//狗狗最小速度
			var times = [11,12,13,14,15];
			times = times.sort(randomsort);
			//console.log(obj);
			dogspeeds = new Array();  
			for(var i = 0; i < parseInt(dog); i ++  ){
				var time = Math.ceil(Math.random()*(15-11)+11)
				var nums = time / num;
				var dogspeed = dogrun(total, nums, minspeed);
				dogspeeds.push(dogspeed);
				//console.log(dogspeed);
				//console.log('\n---------\n');
			}*/
			dogspeeds =  speedsGlobal;
			
			the_first_get_speed = false;
		}
		
		io.emit('getDogInfo',speedsGlobal.data);
		
		
	});
	
	//申请赛场主
	socket.on('ApplyCZ',function(obj){
		//console.log(obj);
		
		var getSCZsql2 = 'SELECT * FROM zy_racedog_player WHERE openid = "'+obj.openid+'" '+sql_where;
		connection.query(getSCZsql2,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
				console.log('result');
				console.log(result);
				if(result != null && result[0] != null && result[0]['total_gold'] >= SCZ_ZG_GOLD){
					
					
					if(curr_scz.openid == sczOpenid){//当前场主为null表示场主为系统
						curr_scz = obj;
						//向用户发送当前赛场主的信息
					
						var getSCZsql = 'SELECT * FROM zy_racedog_player WHERE openid = "'+curr_scz.openid+'" '+sql_where;
						connection.query(getSCZsql,function (err, result) {
							if(err){	
								console.log('[SELECT ERROR] - ',err.message);	
								return;
							}   
							console.log(result);
							io.emit('CurrSCZ',{SCZName:result[0].nickname,SCZOpenid:result[0].openID,SCZGold:result[0].total_gold});
						});	
				  }else{
						if(!hasOpenidInList(obj.openid)){//如果该openid不在列表内就添加列表
							scz_list.push(obj);
						}
		
				  }
					
					
			}
			
		});	
		console.log(ishasZG);
				
		console.log(scz_list);
		console.log(curr_scz);
		
		
		
		
	});
	
	//取消赛场主
	socket.on("CancelCZ",function(obj){
		if(curr_scz.openid != sczOpenid){
			if(curr_scz.openid == obj.openid){
				if(scz_list[0]){
					curr_scz = scz_list[0];
					scz_list.pop();
				}else{
					curr_scz = {openid:sczOpenid};
				}
			}
		}
		console.log(scz_list);
		console.log(curr_scz);
		//向用户发送当前赛场主的信息
		if(curr_scz.openid == sczOpenid){
			var getSCZsql = 'SELECT * FROM zy_racedog_player WHERE openid = "'+sczOpenid+'" '+sql_where;
			connection.query(getSCZsql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
				console.log(result);
				io.emit('CurrSCZ',{SCZName:result[0].nickname,SCZGold:result[0].total_gold});
			});	
		}else{
			var getSCZsql = 'SELECT * FROM zy_racedog_player WHERE openid = "'+curr_scz.openid+'" '+sql_where;
			connection.query(getSCZsql,function (err, result) {
				if(err){	
					console.log('[SELECT ERROR] - ',err.message);	
					return;
				}   
				console.log(result);
				io.emit('CurrSCZ',{SCZName:result[0].nickname,SCZOpenid:result[0].openID,SCZGold:result[0].total_gold});
			});	
		}
	});

	//监听给狗狗送礼
	socket.on("gift",function(obj){
		
		console.log(obj);
		
		var key = md5(openidkey + obj.gold + obj.dog + obj.gift_type + game_id);	
		if(key == obj.key){
			//发送全部
			io.emit('set_gift',{status:1, gift_type:obj.gift_type, dog:obj.dog, openid:obj.openid,gold: obj.gold});	
		}
	/*	var  sqldateNow = new Date();	
		var  timestamp=Date.parse(sqldateNow)/1000;
		var  giftAddSql = 'INSERT INTO zy_gift_log (openid,gameid,dog,gift_type,gold,addtime) VALUES(?,?,?,?,?,?)';
		var  giftAddSql_Params = [obj.openid, game_id, obj.dog, obj.gift_type, obj.gold, timestamp];
		
	    
		connection.query(giftAddSql,giftAddSql_Params,function (err, result) {
			if(err){
				console.log(err);
				return;
			}
			console.log(result);
			if(result.insertId){
				
				var giftModSql = 'UPDATE zy_player SET total_gold = total_gold-? WHERE  openid= ?';
				var giftAddSql_Params = [obj.gold, obj.openid];
				connection.query(giftModSql,giftAddSql_Params,function (err2, result2) {
					if(err2){	
						console.log('[UPDATE zy_player ERROR] - ',err2.message);	
						return;
					}   
					//发送全部
					io.emit('set_gift',{status:1, gift_type:obj.gift_type, dog:obj.dog, openid:obj.openid });					
							
					console.log('UPDATE zy_player ID:',result.affectedRows); 
				});
			}
		})*/


		
	});
	
	
		//声音设置
	socket.on("audioSetting",function(obj){
		console.log(obj.status);
		if(obj.type == "Music"){

			var Sql = 'UPDATE zy_racedog_player SET music_set = ? WHERE openid= ? '+sql_where;
			var Sql_Params = [obj.status, obj.openid];
			connection.query(Sql,Sql_Params,function (err2, result2) {
				if(err2){	
					console.log('[UPDATE music_set ERROR] - ',err2.message);	
					return;
				}   
				
						
			});
		}else if(obj.type == "Effects"){
			var Sql = 'UPDATE zy_racedog_player SET effects_set = ? WHERE openid= ? '+sql_where;
			var Sql_Params = [obj.status, obj.openid];
			connection.query(Sql,Sql_Params,function (err2, result2) {
				if(err2){	
					console.log('[UPDATE effects_set ERROR] - ',err2.message);	
					return;
				}   
				
						
			});
		}else if(obj.type == "All"){
			var Sql = 'UPDATE zy_racedog_player SET effects_set = ? , music_set = ? WHERE openid= ? '+sql_where;
			var Sql_Params = [obj.status,obj.status, obj.openid];
			connection.query(Sql,Sql_Params,function (err2, result2) {
				if(err2){	
					console.log('[UPDATE music_effects_set ERROR] - ',err2.message);	
					return;
				}   
				
						
			});
		}

	})

	
	
	socket.on('getGameTime',function(){
		socket.emit('getGameTime',{time:gameTime});
	});

	//获得速度
	socket.on("getSpeed",function(obj){
		console.log(obj);
	})
	
	
	
});


var rule = new schedule.RecurrenceRule();
var times = [];
for(var i=1; i<60; i++){
　　　times.push(i);
}
rule.second = times;
var c=0;
var isStop = 0 ;
var j = schedule.scheduleJob(rule, function(){
　 c++;
  gameTime ++;
 
  if(gameTime == 55) {
	  
	  gameTime = 0;
	    
	  var reqData= curr_scz; //传赛场主到PHP
		    reqData = require('querystring').stringify(reqData);  
		var post_options = {
			host: hostStr,
			port: '80',
			path: '/gamecenter/index.php?d=racedog&c=raceDog&m=check_repaired&ChannelID='+ChannelID+'&ActiveID='+ActiveID+'&RoomID='+RoomID,
			method: 'POST',
			headers: {
			  'Content-Type': 'application/x-www-form-urlencoded',
			  'Content-Length': reqData.length
			}
		  };
 
		  var post_req = http_server.request(post_options, function (response) {
			  
			  console.log('STATUS: ' + response.statusCode);
			  console.log('HEADERS: ' + JSON.stringify(response.headers));
			  response.setEncoding('utf8');			  
						
			response.on('data', function (data) {
				 data = eval ("(" + data + ")");
				//通杀
				if(data.isStop == 1 && data.isStop != null){
					io.emit('repaired',{isStop:"1"});		
					isStop = 1;			
				}
				if(data.isStop == 0 && data.isStop != null){					
					isStop = 0;							
				}				
							
			    console.log(data);
				
			});
			response.on('end', function () {			 
			});
		  });
		 
		  // post the data
		  post_req.write(reqData);
		  post_req.end();
	  
  }
 
  if(isStop == 1) {console.log('暂停中' );return false ;}
　　console.log('定时：'+gameTime);
  switch(gameTime)
  {
	case 0:
	//  handleDisconnect();
	  console.log("connectionMysql:"+connection.state);
	  var  sqldateNow = new Date();	
	  var  timestamp=Date.parse(sqldateNow)/1000;
	  var  userAddSql = 'INSERT INTO zy_racedog_game(game_owner,addtime,ChannelID,ActiveID,RoomID) VALUES(?,?,?,?,?)';
	  var  userAddSql_Params = ['', timestamp,ChannelID,ActiveID,RoomID];
	  connection.query(userAddSql,userAddSql_Params,function (err, result) {
		  if(err){	
			  console.log('[game_id] - ',err.message);	
			  return;
		  }   
		  game_id = result.insertId;
		  console.log('game_id:',result.insertId); 
		  //查询上一局的gameid
			connection.query("SELECT id FROM zy_racedog_game WHERE id < "+game_id+" "+sql_where+" ORDER BY id DESC limit 1",function (err1, result1) {
				if(err1){
					 console.log('[SELECT reckon_to_ ERROR] - ',err1.message);
					return;
				}   
				if(result1[0] != null)	pre_game_id= result1[0].id;
					 
					
			});	
	  });

		  

	  
	  io.emit('newGame',{seconds:gameTime});  //开始新游戏	
	  
	  var getSCZsql = 'SELECT * FROM zy_racedog_player WHERE openid = "'+curr_scz.openid+'" '+sql_where;
		connection.query(getSCZsql,function (err, result) {
			if(err){	
				console.log('[SELECT ERROR] - ',err.message);	
				return;
			}   
			console.log(result);
			io.emit('CurrSCZ',{SCZName:result[0].nickname,SCZOpenid:result[0].openID,SCZGold:result[0].total_gold});
		});	 
	  break;
	  
	 
	 case 1:
	 	console.log('当前ID：'+game_id);
		console.log('上局ID：'+pre_game_id);
		var reqData= curr_scz; //传赛场主到PHP
		    reqData = require('querystring').stringify(reqData);  
		var post_options = {
			host: hostStr,
			port: '80',
			path: '/gamecenter/index.php?d=racedog&c=raceDog&m=get_tx_tp&ChannelID='+ChannelID+'&ActiveID='+ActiveID+'&RoomID='+RoomID,
			method: 'POST',
			headers: {
			  'Content-Type': 'application/x-www-form-urlencoded',
			  'Content-Length': reqData.length
			}
		  };
 
		  var post_req = http_server.request(post_options, function (response) {
			  
			  console.log('STATUS: ' + response.statusCode);
			  console.log('HEADERS: ' + JSON.stringify(response.headers));
			  response.setEncoding('utf8');			  
						
			response.on('data', function (data) {
				 data = eval ("(" + data + ")");
				//通杀
				if(data.status == 1 && data.total != null){
					io.emit('XLB',{text:"上局狗庄通杀所有玩家，获得"+ data['total']+"烟豆！"});
					console.log('通杀');
				}
				//通赔
				
				if(data.status == -1 && data.total != null){
					io.emit('XLB',{text:"上局狗庄通赔所有玩家，消耗"+ data['total']+"烟豆！"});
					console.log('通赔');
				}
				//获得最多的玩家
				if(data.status == 2 && data.total != null){
					io.emit('XLB',{text:"上局["+data.nickname+"]赢取最多烟豆"+ data['total']+"！"});
					console.log('获得最多的玩家');
				}
				
				//上一局没有玩家
				if(data.status == 3){
					io.emit('XLB',{text:data.content});
					console.log('上一局没有玩家');
				}
				
				
							
			    console.log(data);
			  
			});
			response.on('end', function () {
			
			});
		  });
		 
		  // post the data
		  post_req.write(reqData);
		  post_req.end();
		
		
	
	
	break;    
	
	
	
	
	case 2://2秒时模拟下注
		if(curr_scz.openid == sczOpenid){
			system_bet(5);			
		}
		break;
	case 3://2秒时模拟下注
		if(curr_scz.openid == sczOpenid){			
			system_bet(0);
		}
		break;	

	case 5://5秒时模拟下注
		if(curr_scz.openid == sczOpenid){
			system_bet(3);
		
		}
		break;
	case 7://2秒时模拟下注
		if(curr_scz.openid == sczOpenid){			
			system_bet(0);
		}
		break;	

	case 10://10秒时模拟下注
		if(curr_scz.openid == sczOpenid){
			system_bet(2);
			
		}
		break;
	

	case 12://2秒时模拟下注
		if(curr_scz.openid == sczOpenid){			
			system_bet(0);
		}
		break;
	case 15://15秒时模拟下注
		if(curr_scz.openid == sczOpenid){
			system_bet(4);
		
		}
		break;

	case 17://17秒时模拟下注
		if(curr_scz.openid == sczOpenid){
			system_bet(0);
			
		}
		break;
	
	
	
	  
	case 25:
	  
	  
	  	var reqData= curr_scz; //传赛场主到PHP
		    reqData = require('querystring').stringify(reqData);  
		var post_options = {
			host: hostStr,
			port: '80',
			path: '/gamecenter/index.php?d=racedog&c=raceDog&m=dogspeeds&ChannelID='+ChannelID+'&ActiveID='+ActiveID+'&RoomID='+RoomID,
			method: 'POST',
			headers: {
			  'Content-Type': 'application/x-www-form-urlencoded',
			  'Content-Length': reqData.length
			}
		  };
 
		  var post_req = http_server.request(post_options, function (response) {
			  
			  console.log('STATUS: ' + response.statusCode);
			  console.log('HEADERS: ' + JSON.stringify(response.headers));
			  response.setEncoding('utf8');
			  
			var responseText=[];			
			response.on('data', function (data) {
				speedsGlobal = {data:data};				
			    console.log(speedsGlobal.data);
			  
			});
			response.on('end', function () {
			  // Buffer 是node.js 自带的库，直接使用
			//  responseText = Buffer.concat(responseText,size);
			 // callback(responseText);
			});
		  });
		 
		  // post the data
		  post_req.write(reqData);
		  post_req.end();
	  
	  
	  
	 break;  
	case 30:	
	  the_first_get_speed = true;	//把下注信息返回给前端
	  
	  io.emit('startRun',{seconds:gameTime}); //开始跑
	  
	  //发送赛场主信息到PHP
	  var reqData= curr_scz; //传赛场主到PHP
		    reqData = require('querystring').stringify(reqData);  
		var post_options = {
			host: hostStr,
			port: '80',
			path: '/gamecenter/index.php?d=racedog&c=raceDog&m=saveSCZ&ChannelID='+ChannelID+'&ActiveID='+ActiveID+'&RoomID='+RoomID,
			method: 'POST',
			headers: {
			  'Content-Type': 'application/x-www-form-urlencoded',
			  'Content-Length': reqData.length
			}
		  };
 
		  var post_req = http_server.request(post_options, function (response) {
			  
			  console.log('STATUS: ' + response.statusCode);
			  console.log('HEADERS: ' + JSON.stringify(response.headers));
			  response.setEncoding('utf8');
			  
			var responseText=[];			
			response.on('data', function (data) {
						
			    console.log(data);
			  
			});
			response.on('end', function () {
			  // Buffer 是node.js 自带的库，直接使用
			//  responseText = Buffer.concat(responseText,size);
			 // callback(responseText);
			});
		  });
	  
	     post_req.write(reqData);
		  post_req.end();
	  
	  
	  
	  
	  break;
	case 45:
	//handleDisconnect();
	  io.emit('statement',{seconds:gameTime}); // 跑完结算
	  break;		  
	default:
		   
  }



});


//获取烟豆

function getYD(openid){
	var getSCZsql = 'SELECT * FROM zy_racedog_player WHERE openid = "'+openid+'" '+sql_where;
	var new_gold = 0;
	var getGold = connection.query(getSCZsql,function (err, result) {
		if(err){	
			console.log('[SELECT ERROR] - ',err.message);	
			return;
		}   
		
		if(result != null && result[0] != null){
			new_gold = result[0].total_gold;
			console.log("new_gold2:"+new_gold);
			io.emit('getsumDY_'+openid,{new_gold:new_gold}); // 
			
		}else{
			return 0;
		}
		
	});	
	
	
	
	console.log("new_gold3:"+new_gold);
	return new_gold;
}



//返回狗狗跑动的信息
function dogrun(total, num, minspeed){
	var total = total;
	var speeds = new Array();
	for (var i = 1; i < num ; i++) { 
		/* 随机安全上限 */
		var safe_total = (total - (num - i) * minspeed) / (num - i); 		
		//console.log(safe_total);
		var money = Math.floor( Math.random()*(40 - 1) + 1 );//(Math.random()*(safe_total * 100 - minspeed * 100) + minspeed * 100)  / 100; 
		total = total - money; 
		speeds.push( Number( money ) );
		//echo '第'.$i.'个红包：'.$money.' 元，余额：'.$total.' 元<br>';
	}
	speeds.push( Number( total ) );
	return speeds;
	
}

function randomsort(a, b) {
        return Math.random()>0.5 ? -1 : 1;
}

//判断该openid是否在赛场主列表内
function hasOpenidInList(openid){
	var res = false;
	for(var key in scz_list){
		if(scz_list[key].openid == openid){
			res = true;
		}
	}
	return res;
}


function md5(text) {
  return crypto.createHash('md5').update(text).digest('hex');
}

//取消任务
// j.cancel();


function system_bet(dog){
	var bianhao = Math.floor(Math.random()*4+2);//parseInt(Math.random()*5+2);
	if(dog != 0 ) bianhao = dog;
	var arr = [100,200,500,1000,1050,1200,1500,2030];
	var num = arr[Math.floor(Math.random()*arr.length)];
	var reqData= {data:'[{"openid": "systemPlayer","dog": '+bianhao+',"gold": '+num+'}]'}; //传赛场主到PHP
	    reqData = require('querystring').stringify(reqData);  
	var post_options = {
		host: hostStr,
		port: '80',
		path: '/gamecenter/index.php?d=racedog&c=raceDog&m=system_beton&ChannelID='+ChannelID+'&ActiveID='+ActiveID+'&RoomID='+RoomID,
		method: 'POST',
		headers: {
		  'Content-Type': 'application/x-www-form-urlencoded',
		  'Content-Length': reqData.length
		}
	  };

	  var post_req = http_server.request(post_options, function (response) {
		  
		  console.log('STATUS: ' + response.statusCode);
		  console.log('HEADERS: ' + JSON.stringify(response.headers));
		  response.setEncoding('utf8');
		  
		var responseText=[];			
		response.on('data', function (data) {
							
		    console.log(data);
		    io.emit('beton_return',eval('('+data+')'));
		  
		});
		response.on('end', function () {
		  // Buffer 是node.js 自带的库，直接使用
		//  responseText = Buffer.concat(responseText,size);
		 // callback(responseText);
		});
	  });
	 
	  // post the data
	  post_req.write(reqData);
	  post_req.end();
}






http.listen(3000,function(){
	console.log('listening on *:3000');
});
