<?php
/**
 * 常用函数，通用函数
 * by tangjian 
 */



function getSCZNameByopenid($openid){
    if(empty($openid)) return '';
    $CI = &get_instance();
    $query = $CI->db->query("select nickname from zy_racedog_player where openID = '$openid'");
    $user = $query->row_array();
    
    return $user['nickname'];
}

function getBetSum($bianhao,$gameid){
    if(empty($bianhao) && empty($gameid)) return '';
    $CI = &get_instance();
    $query = $CI->db->query("select sum(gold) as gold,sum(last_gold) as last_gold from zy_racedog_bet_on where gameid = $gameid and dog = $bianhao");
    $res = $query->row_array();
    
    return $res;
}