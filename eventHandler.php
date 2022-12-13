<?php      
// Include database configuration file  
require_once 'config.php'; 
 
// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
 
if($jsonObj->request_type == 'addEvent'){ 
    $start = $jsonObj->start; 
    $end = $jsonObj->end; 
 
    $event_data = $jsonObj->event_data; 
    $eventTitle = !empty($event_data[0])?$event_data[0]:''; 
    $eventDesc = !empty($event_data[1])?$event_data[1]:''; 
    $eventURL = !empty($event_data[2])?$event_data[2]:''; 
    $eventKlas = !empty($event_data[3])?$event_data[3]:'';
    $eventCrebo = !empty($event_data[4])?$event_data[4]:'';
    $eventKwalificatie = !empty($event_data[5])?$event_data[5]:'';
    $eventCohort = !empty($event_data[6])?$event_data[6]:'';
    $eventBenamingeenheid = !empty($event_data[7])?$event_data[7]:'';
    $eventCodeeenheid = !empty($event_data[8])?$event_data[8]:'';
    $eventAfnamevorm = !empty($event_data[9])?$event_data[9]:'';
    $eventTijd = !empty($event_data[10])?$event_data[10]:'';
    $eventDuur = !empty($event_data[11])?$event_data[11]:'';
    $eventBeoordelaar = !empty($event_data[12])?$event_data[12]:'';
    $eventLeverancier = !empty($event_data[13])?$event_data[13]:'';
    $eventToezicht = !empty($event_data[14])?$event_data[14]:'';
    $eventAantal = !empty($event_data[15])?$event_data[15]:'';
    $eventStudentnummer = !empty($event_data[16])?$event_data[16]:'';
    $eventCluster = !empty($event_data[17])?$event_data[17]:'';
    $eventVersie = !empty($event_data[18])?$event_data[18]:'';
    $eventLocatie = !empty($event_data[19])?$event_data[19]:'';
    $eventOpmerking = !empty($event_data[20])?$event_data[20]:'';

    if(!empty($eventTitle)){ 
        // Insert event data into the database 
        $sqlQ = "INSERT INTO events (title,description,url,start,end) VALUES (?,?,?,?,?)"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("sssss", $eventTitle, $eventDesc, $eventURL, $start, $end); 
        $insert = $stmt->execute(); 
 
        if($insert){ 
            $output = [ 
                'status' => 1 
            ]; 
            echo json_encode($output); 
        }else{ 
            echo json_encode(['error' => 'Event Add request failed!']); 
        } 
    } 
}elseif($jsonObj->request_type == 'deleteEvent'){ 
    $id = $jsonObj->event_id; 
 
    $sql = "DELETE FROM events WHERE id=$id"; 
    $delete = $conn->query($sql); 
    if($delete){ 
        $output = [ 
            'status' => 1 
        ]; 
        echo json_encode($output); 
    }else{ 
        echo json_encode(['error' => 'Event Delete request failed!']); 
    } 
}