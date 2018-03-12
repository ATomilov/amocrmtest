<?php
include_once "auth.php"; 
include_once "leads.php"; 
include_once "tasks.php";

$counter = 0;

$authStatus = getAuthStatus('d155161@nwytg.com', '5bb5e799a5b3de4e93bc4df140d9ce95', 'new5aa6d09c89afe');
if ($authStatus['auth']):
  echo 'Авторизация прошла успешно <br>';
else: 
  echo 'Авторизация не удалась <br>';
endif;

$leadsList = getLeadsList($authStatus['accounts'][0]['subdomain']);
if ($leadsList) : 
  echo "Список сделок: <br>";
  foreach ($leadsList as $key => $value) :
    $tasksList = getTasksList($authStatus['accounts'][0]['subdomain'], $value['id']);
    echo $value['name'];
    if ($tasksList) : 
      echo " (Задачи данной сделки: ";
      foreach ($tasksList as $key => $value_task) :
        $counter++;
        if ($value['id'] == $value_task['element_id'] && !($value_task['is_completed']) && ($value_task['complete_till_at'] > strtotime("now"))) : 
          if ($counter != count($tasksList) ) : 
            echo $value_task['text'] . ", ";
          else : 
            echo $value_task['text'] . " ";
          endif;
        endif;
      endforeach;
      $counter = 0;
      echo ")<br>";
    else : 
      createTaskToLead($authStatus['accounts'][0]['subdomain'], $value['id'], "Сделка без задачи", "+5 week");
      // echo " (У задачи нет открытых сделок)<br>";
    endif;
  endforeach;
endif;
?>