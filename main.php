<?php
// INGRESA EL TOKEN DE TU BOT OBTENIDO EN BOTFATHER
$botToken = 'AQUI VA EL TOKEN DE TU BOT'; 

// LLAMAR A LAS VARIABLES DEL BOT
require_once('config/variables.php');

//LLAMAR A OXXOPAY
require_once('oxxo.php');

//VARIABLES OXXOPAY
  $date = date("d-m-Y");
  $mod_date = strtotime($date."+ 1 days");
  $fecha = date("d-m-Y",$mod_date); // LAS REFERENCIAS EXPIRAN EN UN DIA
  
  $reference = $order->charges[0]->payment_method->reference;
  $dinero = $order->amount/100;
  
  $producto = $order->line_items->name;
  
// COMIENZO DEL BOT

if (strpos($message, '/start') === 0){
  bot('sendMessage',[
    'chat_id' => $chat_id, //Busca el chat id del mensaje
    'message_id' => $message_id, //Busca el Mensaje ID
    'text' => '<b> Hola se bienvenido al bot para obtener una referencia de pago en OxxoPay 😃</b>',
    'reply_to_message_id' => $message_id, //Responde al usuario
    'parse_mode' => 'HTML',
    //Creacion de Botones
    'reply_markup' => json_encode(['inline_keyboard' => [
        [
            ['text'=>'Obtener referencia 😃', 'callback_data'=>'ref'] 
        ]
        
        ]])
      
  ]);
}

//LLAMADA DE CALLBACK POR LLAMADA EN BOTONES TELEGRAM
 if($data == "ref"){
    bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"<b>Hola Tu referencia se genero de forma exitosa 😃!

Refrencia => <code>$reference</code>
         
Monto => $$dinero
         </b>",
    'parse_mode'=>'html',
    'disable_web_page_preview'=>true,
    'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"Gracias por usarme 😊",'callback_data'=>"fin"]]
  ],'resize_keyboard'=>true])
  ]);
  
  }



// FUNCIONES REQUERIDAS
function bot($method,$datas=[]){
  global $botToken;
  $url = "https://api.telegram.org/bot".$botToken."/".$method;
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

// ENVIAR MENSAJE 
function sendMessage($chat_id,$text,$keyboard){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$text,
'reply_markup'=>$keyboard]);
}

// EDITAR MENSAJE
function editMessage($chat_id,$message_id,$text,$reply_markup){
bot('editMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$text,
'reply_markup'=>$reply_markup]);
}
