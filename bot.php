<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
function curl($url, $headers, $mode="get", $data=0)
        {
        if ($mode == "get" || $mode == "Get" || $mode == "GET")
                {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                }
        elseif ($mode == "post" || $mode == "Post" || $mode == "POST")
                {
                $headers[] = "Content-Length: ".strlen($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                }
        else
                {
                $result = "Not define";
                }
        return $result;
}
function timer($waktu){
for ($x=$waktu;$x>0;$x--){
echo "\r                                             \r";
echo "Please wait ".$x." second ";
sleep(1);
echo "\r                                             \r";
}
}
function randomku($leng) {
$characters = '1234567890abcdef';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $leng; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}
function ceknull($cek){
if($cek == null){
return "0";
}else{
return $cek;
}
}
$batas = str_repeat('#',55)."\n";
$batas2 = str_repeat('~',55)."\n";
while(true){
if(strpos(shell_exec('uname -a'),'Linux') !== false){
system('clear');
}else{
pclose(popen('cls', 'w'));
}
echo "========[ Script TonJoy ]========\n";
$akunn = file_get_contents('akun.json');
if($akunn == null){
echo "	[*] Total Akun ( 0 )\n";
}else{
$data = json_decode($akunn,true);
if(!isset($data)){
echo "	[*] Total Akun ( 0 )\n";
}else{
$akun = count($data);
echo "	[*] Total Akun ( ".$akun." )\n";
}
}
echo "	[1] Add Account\n";
echo "	[2] Run\n";
echo "	[3] Delete\n";
echo "	[4] Update Data\n";
$menu = readline('Options: ');
if($menu == 1){
$initdata = readline('Init Data: ');
$premiumm = readline('Akun Telegram Premium (Y/n): ');
if($premiumm == 'y' or $premiumm == 'Y'){
$premium = 1;
}else{
$premium = 0;
}
$parsing = json_decode(urldecode(explode('&',explode('user=',$initdata)[1])[0]));
$userid = $parsing->id;
$username = $parsing->username;
$firstn = $parsing->first_name;
$lastn = $parsing->last_name;
$files = 'akun.json';
if(!file_exists($files)){
$data = [];
$data [] = array(
'initdata' => $initdata,
'userid' => $userid,
'username' => $username,
'firstn' => $firstn,
'lastn' => $lastn,
'premium' => $premium
);
$jsonfile = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($files, $jsonfile);
}else{
$file = $files;
$anggota = file_get_contents($file);
$data = json_decode($anggota, true);
if(!is_array($data)) {
$data = []; 
}
$data [] = array(
'initdata' => $initdata,
'userid' => $userid,
'username' => $username,
'firstn' => $firstn,
'lastn' => $lastn,
'premium' => $premium
);
$jsonfile = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($file, $jsonfile);
}
echo "Akun Berhasil Di Simpan\n";
}elseif($menu == 2){
$lompat = explode('-',readline('Lompat Akun: '));
$lompat0 = $lompat[0]-1;
$lompat1 = $lompat[1]-1;
$config = file_get_contents('akun.json');
if($config == null){
echo "Config Tidak Ada\n";
}else{
$jsones = json_decode($config);
$hitt = count($jsones);
foreach($jsones as $keyy => $dataakun){
$initdata = $dataakun->initdata;
$userid = $dataakun->userid;
$username = $dataakun->username;
$firstn = urlencode($dataakun->firstn);
$lastn = urlencode($dataakun->lastn);
$premium = $dataakun->premium;
$token = randomku(32);
$vid = randomku(32);
$key = $keyy+1;
echo "Akun Ke [".$key."/".$hitt."] Name: ".$dataakun->firstn.$dataakun->lastn."\n";
if($keyy == $lompat0){
//skip
}elseif($keyy >= $lompat0 && $keyy <= $lompat1){
//skip
}else{
$headers = [
'content-type: application/json',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36'
];
$data = '{"initData":"'.$initdata.'","userId":'.$userid.',"pkg":"com.bw.ow.tg.rw"}';
$signin = curl('https://ow.tonjoy.ai/api/v1/user/task/sign/in?token='.$token.'&os=web&locale=in&appvn=main_0c97c2c&vn=7.10&app=com.bw.ow.tg.rw&vid='.$vid.'&type=3&user_id='.$userid.'&username='.$username.'&first_name='.$firstn.'&last_name='.$lastn.'&is_premium='.$premium.'&ows=tg&ts='.round(microtime(true) * 1000),$headers,'POST',$data);
$json = json_decode($signin);
if($json->code == "00000"){
if($json->data->status == 1){
$status = "Berhasil";
$diamon = $json->data->status;
}else{
$status = "Gagal";
$diamon = 0;
}
echo "Sign In: ".$status." | Diamonds: ".$diamon."\n";
}elseif($json->code == "10007"){
echo "Sign In: ".$json->message."\n";
}else{
echo "Sign In: ".$signin."\n";
}
$data = '{"initData":"'.$initdata.'","pageNum":1,"pageSize":100}';
$offerhome = curl('https://ow.tonjoy.ai/api/v1/offer/home?token='.$token.'&os=web&locale=in&appvn=main_0c97c2c&vn=7.10&app=com.bw.ow.tg.rw&vid='.$vid.'&type=3&user_id='.$userid.'&username='.$username.'&first_name='.$firstn.'&last_name='.$lastn.'&is_premium='.$premium.'&ows=tg&ts='.round(microtime(true) * 1000),$headers,'POST',$data);
$json = json_decode($offerhome);
if($json->code == "00000"){
echo "[ MENU OFFERS ]\n";
foreach($json->data->offer as $offer){
echo "Title\t\t: ".$offer->title."\n";
echo "Max Reward Coin\t: ".$offer->maxRewardCoin."\n";
echo "Wait Reward Coin: ".$offer->waitRewardCoin."\n";
echo "Reward Diamonds\t: ".$offer->rewardDiamonds."\n";
$ts = round(microtime(true) * 1000);
$up = rand(200,300).','.rand(400,500);
$url_parts = parse_url($offer->clickUrl[0]);
parse_str($url_parts['query'], $query_params);
$query_params['appName'] = rawurlencode($query_params['appName']);
$new_query = http_build_query($query_params);
$link = $url_parts['scheme'] . "://" . $url_parts['host'] . $url_parts['path'] . "?" . $new_query;
$link = str_replace(['__ACTION_UP__', '__ACTION_TIME__'], [$up, $ts], $link);
$headers2 = [
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36',
'content-type: text/plain;charset=UTF-8'
];
$data = '{"__ACTION_TIME__":'.$ts.',"__ACTION_UP__":"'.$up.'","initData":"'.$initdata.'"}';
$visit = curl($link,$headers2,"POST",$data);
$json = json_decode($visit);
if($json->code == "00000"){
echo "Visit Url\t: Ok\n";
if($offer->offerType == 2){
parse_str(parse_url($offer->targetUrl)['query'], $paramsq);
$bookid = explode('.',explode('.',$offer->bundle)[3])[0];
$end = curl('https://rpt.novelamazing.com/api/v1/report?ts='.round(microtime(true) * 1000).'&target_min=0.5&country='.$paramsq['country'].'&bookId='.$bookid.'&source='.$paramsq['utm_source'].'&adPkg='.$offer->bundle.'&clickId='.urlencode($paramsq['click_id']).'&key=book_task_0_5min',['user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36'],'GET');
$json = json_decode($end);
if($json->message->code == 200){
echo "Close Url\t: Ok\n";
}else{
echo "Close Url: ".$end."\n";
}
}elseif($offer->offerType == 3){
echo "Close Url\t: Ok\n";
}
}elseif($json->code == "10007"){
echo "Visit Url: ".$json->message."\n";
}else{
echo "Visit Url: ".$visit."\n";
}
$data = '{"initData":"'.$initdata.'","userId":'.$userid.',"pkg":"com.bw.ow.tg.rw","ows":"tg"}';
$info = curl('https://ow.tonjoy.ai/api/v1/user/info?token='.$token.'&os=web&locale=in&appvn=main_0c97c2c&vn=7.8&app=com.bw.ow.tg.rw&vid='.$vid.'&type=3&user_id='.$userid.'&username='.$username.'&first_name='.$firstn.'&last_name='.$firstn.'&is_premium='.$premium.'&ows=tg&ts='.round(microtime(true) * 1000),$headers,'POST',$data);
$json = json_decode($info);
if($json->code == "00000"){
echo "Received Coin\t: ".ceknull($json->data->userRewardDTO->receivedCoin)."\n";
echo "Invite Coin\t: ".ceknull($json->data->userRewardDTO->inviteCoin)."\n";
echo "Remain Coin\t: ".ceknull($json->data->userRewardDTO->remainCoin)."\n";
echo "Invite Diamond\t: ".ceknull($json->data->userRewardDTO->inviteDiamond)."\n";
echo "Task Coin\t: ".ceknull($json->data->userRewardDTO->taskCoin)."\n";
echo "Received Diamond: ".ceknull($json->data->userRewardDTO->receivedDiamond)."\n";
echo "Remain Diamond\t: ".ceknull($json->data->userRewardDTO->remainDiamond)."\n";
}elseif($json->code == "10007"){
echo "Info Akun: ".$json->message."\n";
}else{
echo "Info Akun: ".$info."\n";
}
echo $batas2;
}//foreach offer home
}elseif($json->code == "10007"){
echo "Offers: ".$json->message."\n";
}else{
echo "Offers: ".$offerhome."\n";
}
$data = '{"initData":"'.$initdata.'"}';
$inprogress = curl('https://ow.tonjoy.ai/api/v1/offer/inProgress?token='.$token.'&os=web&locale=in&appvn=main_0c97c2c&vn=7.10&app=com.bw.ow.tg.rw&vid='.$vid.'&type=3&user_id='.$userid.'&username='.$username.'&first_name='.$firstn.'&last_name='.$lastn.'&is_premium='.$premium.'&ows=tg&ts='.round(microtime(true) * 1000),$headers,'POST',$data);
$json = json_decode($inprogress);
if($json->code == "00000"){
echo "[ MENU ONGOING ]\n";
foreach($json->data->offer as $offer){
echo "Title\t\t: ".$offer->title."\n";
echo "Max Reward Coin\t: ".$offer->maxRewardCoin."\n";
echo "Wait Reward Coin: ".$offer->waitRewardCoin."\n";
echo "Reward Diamonds\t: ".$offer->rewardDiamonds."\n";
if($offer->offerType == 2){
if($offer->status == 1){
parse_str(parse_url($offer->targetUrl)['query'], $paramsq);
$bookid = explode('.',explode('.',$offer->bundle)[3])[0];
$end = curl('https://rpt.novelamazing.com/api/v1/report?ts='.round(microtime(true) * 1000).'&target_min=0.5&country='.$paramsq['country'].'&bookId='.$bookid.'&source='.$paramsq['utm_source'].'&adPkg='.$offer->bundle.'&clickId='.urlencode($paramsq['click_id']).'&key=book_task_0_5min',['user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36'],'GET');
$json = json_decode($end);
if($json->message->code == 200){
echo "Close Url\t: Ok\n";
}else{
echo "Close Url: ".$end."\n";
}
$data = '{"initData":"'.$initdata.'","userId":'.$userid.',"pkg":"com.bw.ow.tg.rw","ows":"tg"}';
$info = curl('https://ow.tonjoy.ai/api/v1/user/info?token='.$token.'&os=web&locale=in&appvn=main_0c97c2c&vn=7.8&app=com.bw.ow.tg.rw&vid='.$vid.'&type=3&user_id='.$userid.'&username='.$username.'&first_name='.$firstn.'&last_name='.$firstn.'&is_premium='.$premium.'&ows=tg&ts='.round(microtime(true) * 1000),$headers,'POST',$data);
$json = json_decode($info);
if($json->code == "00000"){
echo "Received Coin\t: ".ceknull($json->data->userRewardDTO->receivedCoin)."\n";
echo "Invite Coin\t: ".ceknull($json->data->userRewardDTO->inviteCoin)."\n";
echo "Remain Coin\t: ".ceknull($json->data->userRewardDTO->remainCoin)."\n";
echo "Invite Diamond\t: ".ceknull($json->data->userRewardDTO->inviteDiamond)."\n";
echo "Task Coin\t: ".ceknull($json->data->userRewardDTO->taskCoin)."\n";
echo "Received Diamond: ".ceknull($json->data->userRewardDTO->receivedDiamond)."\n";
echo "Remain Diamond\t: ".ceknull($json->data->userRewardDTO->remainDiamond)."\n";
}elseif($json->code == "10007"){
echo "Info Akun: ".$json->message."\n";
}else{
echo "Info Akun: ".$info."\n";
}
}//status
}//offer
echo $batas2;
}
}elseif($json->code == "10007"){
echo "Ongoing: ".$json->message."\n";
}else{
echo "Ongoing: ".$inprogress."\n";
}
echo $batas;
}//skip
}//foreach
}//cek file
}elseif($menu == 3){
$akun = file_get_contents('akun.json');
if($akun == null){
echo "Akun Kosong\n";
}else{
$akuns = json_decode($akun);
$del = explode('-',readline('Delete Akun: '));
$delete0 = $del[0]-1;
$delete1 = $del[1]-1;
$hitung = count($akuns);
foreach($akuns as $kuy => $akunn){
$kus = $kuy+1;
echo "Akun Ke: ".$kus."/".$hitung."\n";
if($kuy == $delete0){
unset($akuns[$kuy]);
file_put_contents('akun.json',json_encode(array_values($akuns),JSON_PRETTY_PRINT));
}elseif($kuy >= $delete0 && $kuy <= $delete1){
unset($akuns[$kuy]);
file_put_contents('akun.json',json_encode(array_values($akuns),JSON_PRETTY_PRINT));
}else{
echo "Continue\n";
}
}
}
}elseif($menu == 4){
$lompat = explode('-',readline('Lompat Akun: '));
$lompat0 = $lompat[0]-1;
$lompat1 = $lompat[1]-1;
$config = file_get_contents('akun.json');
if($config == null){
echo "Config Tidak Ada\n";
}else{
$jsones = json_decode($config,true);
$hitt = count($jsones);
foreach($jsones as $keyy => $dataakun){
$key = $keyy+1;
$username = $dataakun['username'];
echo "Akun Ke [".$key."/".$hitt."]\n";
if($keyy == $lompat0){
//skip
}elseif($keyy >= $lompat0 && $keyy <= $lompat1){
//skip
}else{
$akses = readline('Akses Akun @'.$username.' (Y/n): ');
if($akses == 'Y' || $akses == 'y'){
$initdata = readline('Init Data: ');
$premiumm = readline('Akun Telegram Premium (Y/n): ');
if($premiumm == 'y' or $premiumm == 'Y'){
$premium = 1;
}else{
$premium = 0;
}
$parsing = json_decode(urldecode(explode('&',explode('user=',$initdata)[1])[0]));
$userid = $parsing->id;
$username = $parsing->username;
$firstn = $parsing->first_name;
$lastn = $parsing->last_name;
$jsones[$keyy]['initdata'] = $initdata;
$jsones[$keyy]['userid'] = $userid;
$jsones[$keyy]['username'] = $username;
$jsones[$keyy]['firstn'] = $firstn;
$jsones[$keyy]['lastn'] = $lastn;
$jsones[$keyy]['premium'] = $premium;
$newJsonString = json_encode($jsones, JSON_PRETTY_PRINT);
file_put_contents('akun.json', $newJsonString);
echo "Data berhasil diupdate dan disimpan\n";
}else{
echo "Skip\n";
}
echo $batas;
}//skip
}//foreach
}//cek file
}
readline('Kembali Ke Menu Utama');
}
