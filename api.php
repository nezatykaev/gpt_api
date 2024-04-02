<?php 

define('OPENAI_API_KEY', 'entry_key');

if (!empty($_POST)) {
//echo $_POST['user_id'];
  $url="https://api.openai.com/v1/chat/completions";
  
  $headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . OPENAI_API_KEY
  ];
  $data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        
    ["role" => "user", "content" => $_POST['msg']]
  ],
    'max_tokens' => 3000,
    "temperature" => 0.5,
  ];
//echo "test";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response  = curl_exec($ch);
  if (curl_errno($ch)) {
    $return = [
      'error' => ['msg'=>'<span style="color:red">' . curl_error($ch) . '</span>']
    ];
    curl_close($ch);
    return $return;
  }
  //echo $response;
  curl_close($ch);
  $arr = json_decode($response, 1);
  //$decoded_json = json_decode($response, false);
  print_r($arr['choices'][0]['message']['content']);
  $return = [
    'message' => ''
  ];
  if(!empty($arr['error'])){
    $return['error'] = ['msg'=>'<span style="color:red">' . $arr['error']['message'] . '</span>'];
  }
  elseif(!empty($arr['choices'])){
    $return['message'] = trim($arr['choices'][0]['message']['content']);
  }
  return $return;
  //echo "test";

}else{
echo "wrong";
}

set_time_limit(120);

// To use the official API (GPT-3 and GPT-3.5 turbo)
// get OPENAI_API_KEY https://platform.openai.com/account/api-keys

// To use chat.openai.com
// get cookie "_puid=user-..." - https://chat.openai.com/chat
//define('COOKIE_PUID', '_puid=user-...');

// To use chat.openai.com
// get ACCESS_TOKEN - https://chat.openai.com/api/auth/session
//define('ACCESS_TOKEN', '');

?>
