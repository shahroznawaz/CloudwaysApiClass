<?php 
include 'CloudwaysApi.php'; 
$api_key = 'Your_api_key'; 
$email = 'Your_Cloud_email'; 
$cw_api = new CloudwaysAPI($email,$api_key); 
$servers = $cw_api->getServers(); 
$settings = $cw_api->getServerSettings($serverId);
$applications = $cw_api->getApplications(); 
$addapp= $cw_api->addApplication($serverid, $application, $app_version, $app_name);
$delapp= $cw_api->deleteApplication($serverid, $applicationid);
$delserver = $cw_api->deleteServer($serverId); 

echo "<pre>";
var_dump($servers);
echo "</pre>";

//for updating server settings

foreach($servers->servers as $serverinfo){}
    $server_settings = $cw_api->get_servers_settings($serverinfo->id);
    $success = null;
    if(isset($_POST['submit']))
    {
        $server_id = $_POST['server_id'];
        $date_timezone = $_POST['date_timezone'];
        $display_errors = $_POST['display_errors'];
        $apc_shm_size = $_POST['apc_shm_size'];
        $execution_limit = $_POST['execution_limit'];
        $memory_limit = $_POST['memory_limit'];
        $max_input_vars = $_POST['max_input_vars'];
        $max_input_time = $_POST['max_input_time'];
        $mod_xdebug = $_POST['mod_xdebug'];
        $upload_size = $_POST['upload_size'];
        $error = null;
        $result = $cw_api->set_servers_settings($server_id,$date_timezone,$display_errors,$apc_shm_size,$execution_limit,$memory_limit,$max_input_vars,$max_input_time,$mod_xdebug,$upload_size);
        if($result == [])
        {
            $success["message"] = "Settings has been saved!";
        }
        else
        {
            $success["message"] = "Kindly correct the above errors.";
        }
        $Message = urlencode($success["message"]);
        header('Location:index.php?Message='.$Message);
    }

