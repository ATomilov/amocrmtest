<?php
function requestToGetDataCRM($link){
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link);
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);
include_once "templates/errors_template.php";

$Response=json_decode($out,true);
$Response=$Response['_embedded']['items'];
return $Response;
}

function getLeadsList($subdomain){
  $link='https://'.$subdomain.'.amocrm.ru/api/v2/leads';
  $result = requestToGetDataCRM($link);
  return $result;
}
?>