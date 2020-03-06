
<?php
ob_start();
define('API_KEY','token');
//tokenni yozing
$admin = "you id";
function fsize($size,$round=2)
{
$sizes=array(' Bytes',' Kb',' Mb',' Gb',' Tb');
$total=count($sizes)-1;
for($i=0;$size>1024 && $i<$total;$i++){
$size/=1024;
}
return round($size,$round).$sizes[$i];
}
function del($nomi){
   array_map('unlink', glob("$nomi"));
   }
 
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}   
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$chat_id = $message->chat->id;
$text1 = $message->text;
$fadmin = $message->from->id;
//bu yerni o'zgartirishingiz mumkin.
$sreply = $message->reply_to_message->text;  $sreplyd = $message->audio;
    $ent = $message->entities[0]->type;
    $reply_menu = json_encode([
           'resize_keyboard'=>false,
                'force_reply' => true,
                'selective' => true
            ]);
if($text1=="/start"){  
$baza = file_get_contents("pechat.dat");
if(mb_stripos($baza, $chat_id) !== false){
}else{
file_put_contents("pechat.dat", "$baza\n$chat_id");
}
  $text = "Bu bot juda foydali.
Botni kanalingizga admin qiling.
Musica yuboring. 2soniya kuting. Va hammasi tayyor.";
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>$text,
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [['text'=>'Gruppaga qoshish','url'=>'https://telegram.me/AutoEditBot?startgroup=new']],
]
    ])
  ]);
} 
$chm = $update->channel_post;
$chuser = $chm->chat->username;
$chtext = $chm->text;
$title = $chm->chat->title;
$chma = $chm->audio;
$doc=$chm->audio;
 $doc=$message->audio;
$doc_id = $chma->file_id;
$message_ch = $update->channel_post;
$message_ch_mid = $message_ch->message_id;
$muser = $message_ch->chat->username;
$message_ch_chid = $message_ch->chat->id;
if(mb_stripos($chtext,"#cap") !==false){
        $ex = explode("#cap",$chtext);
        $tx = $ex[1];
        bot('deleteMessage',[
         'chat_id'=>$message_ch_chid,
         'message_id'=>$message_ch_mid,
         ]);
         file_put_contents("$message_ch_chid.caption","$tx");
    }
if(mb_stripos($chtext,"#btn") !==false){
        $ex = explode("#btn",$chtext);
        $tx = $ex[1];
        bot('deleteMessage',[
         'chat_id'=>$message_ch_chid,
         'message_id'=>$message_ch_mid,
         ]);
         file_put_contents("$message_ch_chid.btn","$tx");
    }
 if($chma){
$url = json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY.'/getFile?file_id='.$doc_id),true);
$path=$url['result']['file_path'];
$file = 'https://api.telegram.org/file/bot'.API_KEY.'/'.$path;
$ftitle = $chma->title;
$fname = $chma->performer;
$type = strtolower(strrchr($file,'.')); 
$typeee=str_replace('dodasi.com','@'.$muser,$ftitle);
file_put_contents($doc_id.".mp3",file_get_contents($file));
$xajm = fsize(filesize($doc_id.".mp3"));
bot('deletemessage',[ 'chat_id'=>$message_ch_chid, 'message_id'=>$message_ch_mid ]);
$chid = $message_ch->chat->id;
$size = $chma->file_size;
$dur12 = $chma->duration;
$dur = $dur12/60;
$size = $size/1048576;
$coor = explode('.', $size);
$coor2 = substr ($coor['1'], 0, 2);
$coor3 = explode('.', $dur);
 $coor4 = substr ($coor3['1'], 0, 2);
$dur1 = $coor3[0];
$dur2 = $dur1 * 60;
$duri = $dur12 - $dur2;
$size = $coor['0'].'.'.$coor2;
$dur = $coor3['0'].'.'.$coor4;
include("getid3/getid3.php");
$getID3 = new getID3;
$filer = $getID3->analyze($doc_id.".mp3");
$durm = $filer['playtime_string'];
require_once 'phpmp3.php';
//Extract 30 seconds starting after 10 seconds.
$mp3 = new PHPMP3($doc_id.".mp3");
$mp3_1 = $mp3->extract(15,45);
$mp3_1->save('yes.ogg');

bot('sendVoice',[
          'chat_id'=>$message_ch_chid,
'voice'=>new CURLFile("yes.ogg"),
'duration'=>$du,
      'caption'=>$fname."-".$typeee."\n👇 Musicani to'liq holatda tinglang👇\n\n@".$muser." kanali uchun maxsus",
          ]);
$btn = file_get_contents("$message_ch_chid.btn");
if(strlen($btn)>2){
$buton = $btn;
}else{
$buton = "👫Dostlarga ulashish";
}
$chcap = file_get_contents("$message_ch_chid.caption");
if(strlen($chcap)>2){
$cap = $chcap;
}else{
$cap = "@$muser kanali uchun maxsus";
}
bot('sendAudio',[
          'chat_id'=>$message_ch_chid,
          'audio'=>new CURLFile($doc_id.".mp3"),
        'title'=>$fname."-".$typeee,
        'performer'=>"@".$muser,
          'thumb'=>$fileid,
      'caption'=>$fname."-".$typeee."\n 💾|" .$xajm."  🕐|" .$durm."\n\n".$cap,
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"$buton", "url"=>"https://t.me/share/url?url=https://telegram.me/$muser/$message_ch_mid"]],
            ]
        ])
          ]);
del($doc_id.".mp3");
del("yes.ogg");
}
$type = $message->chat->type;
if($type =="private"){
$baza = file_get_contents("Azolar.txt");
    if(mb_stripos($baza, $chat_id) !== false){
}else{
file_put_contents("Azolar.txt", "$baza\n$chat_id");
}    
}
if($chuser){
$dat = file_get_contents("chuser.dat");
if(mb_stripos($dat,$chuser) !== false){
}else{
file_put_contents("chuser.dat", "$dat\n@$chuser");
file_put_contents("$message_ch_chid.caption","");
file_put_contents("$message_ch_chid.btn",""); 
}
} if($text1=="/stat"){
    $stat = file_get_contents("Azolar.txt");
    $count = substr_count($stat,"\n");
     bot('sendmessage',[
        'chat_id'=>$chat_id,
    'text'=>"Botimiz a'zolari: $count",
]);
}
if($text1=="/chuser"){
    $chus = file_get_contents("chuser.dat");
        $user = file_get_contents("chuser.dat");
    $son = substr_count($user,"\n");
    $son1 = $son - "1";
     bot('sendmessage',[
        'chat_id'=>$chat_id,
    'text'=>"Barcha kanallar useri: $chus \n\nBarcha kanallar:$son ta",
]);
}