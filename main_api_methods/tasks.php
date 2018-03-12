<?php
function getTasksList($subdomain, $lead_id){
  $link='https://'.$subdomain.'.amocrm.ru/api/v2/tasks?element_id='.$lead_id;
  $result = requestToGetDataCRM($link);
  return $result;
}

function createTaskToLead($subdomain, $lead_id, $text_task, $complete_till_at){
  $link='https://'.$subdomain.'.amocrm.ru/api/v2/tasks';
  $tasks['add']=array(
    array(
    'element_id'=>$lead_id,
    'element_type'=>2,
    'task_type'=>1,
    'text'=>$text_task,
    'complete_till_at'=>strtotime($complete_till_at)
    )
  );
  $result = requestToCreateDataCRM($link, $tasks);
  return $result;
}

function requestToCreateDataCRM($link, $input_data_array){
  $curl=curl_init();
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
  curl_setopt($curl,CURLOPT_URL,$link);
  curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
  curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($input_data_array));
  curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
  curl_setopt($curl,CURLOPT_HEADER,false);
  curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
  curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
  curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
  curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
  $out=curl_exec($curl);
  $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
  include_once "templates/errors_template.php";
  $Response=json_decode($out,true);
  $Response=$Response['_embedded']['items'];
  return $Response;
}
?>