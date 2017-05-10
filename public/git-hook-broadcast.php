<?php

// check if in dev, staging or in live
switch (preg_replace("/:.*$/", "", strtolower($_SERVER['HTTP_HOST']))) {
    // PHP5 dev servers
    case 'stuart.loc':
        define ('BRANCH', 'dev');
        define ('WORK_DIR', '');
    break;
    
    case 'localhost':
        define ('BRANCH', 'dev');
        define ('WORK_DIR', '');
    break;
    
    case 'www.housestars.com.au':
        define ('BRANCH', 'master');
        define ('WORK_DIR', '/var/www/html/app');
    break;
    
    case 'staging.housestars.com.au':
        define ('BRANCH', 'staging');
        define ('WORK_DIR', '/var/www/html/staging');
    break;
    
    case 'dev.housestars.com.au':
        define ('BRANCH', 'dev');
        define ('WORK_DIR', '/var/www/html/dev');
    break;
    
    default:
        if(strstr($_SERVER['REQUEST_URI'], '/dev')) {
            define ('BRANCH', 'dev');
            define ('WORK_DIR', '/var/www/html/dev');
        } else if(strstr($_SERVER['REQUEST_URI'], '/staging')) {
            define ('BRANCH', 'staging');
            define ('WORK_DIR', '/var/www/html/staging');
        } else {
            define ('BRANCH', 'master');
            define ('WORK_DIR', '/var/www/html/app');
        }
    break;
}

if(!isset($_GET['to'])) {
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $to = 'stuart@simpleclick.com.au, john@simpleclick.com.au, chris@simpleclick.com.au';
    $subject = $_SERVER['HTTP_HOST'] . ' ' . strtoupper(BRANCH) . ' FAILED auto deploy';
    $body = 'Attempt to broadcast failed. Remote repository destination not defined!';
    mail($to, $subject, $body, $headers);
}

// if(isset($_GET['to']))
// {
//     define ('BROADCAST', $_GET['to']);
// }
// else
// {
//     define ('BROADCAST', "origin");
// }


$continue = true;
$log = "<h3>Git hook log:</h3>
<div style='color:darkred;background:#dfdfdf;font-family:monospace;padding:10px;font-size: 12px;'>";

$log .= "<b>Checking out " . BRANCH . "...</b> <br>";
$output = execute('git checkout ' . BRANCH, WORK_DIR);
foreach ($output as $k => $o) {
    if($o != "" && $k != 'code')
        $log .= '<pre>' . $o . '</pre><br>';
    if(strpos($o, 'error') !== false)
        $continue = false;
}
if($continue){
    $log .= "<b>Fetching information from git repo...</b> <br>";
    $output = execute('git fetch ', WORK_DIR);
    foreach ($output as $k => $o) {
        if($o != "" && $k != 'code')
            $log .= '<pre>' . $o . '</pre><br>';
    }

    $log .= "<b>Getting commit difference between local and remote...</b> <br>";
    $difference = execute('git rev-list --left-right --count '. BRANCH .'...origin/' . BRANCH, WORK_DIR);

    $behind = preg_split('/\s+/', $difference['out']);
    $log .= '<pre><i>' . BRANCH .'</i> ahead by ' . $behind[0] . ' commits
    <i>origin/'. BRANCH .'</i> ahead by ' . $behind[1] . ' commits</pre><br>';

    if($behind[1] == 0){
        $log .= 'No new revisions found. Terminating... </div>';
        $continue = false;
    }
}
if($continue){
    $log .= "<b>Attempting to pull from git repo...</b> <br>";
    $output = execute('git pull origin ' . BRANCH, WORK_DIR);
    foreach ($output as $k => $o) {
        if($o != "" && $k != 'code')
            $log .= '<pre>' . $o . '</pre><br>';
        if(strpos($o, 'Automatic merge failed') !== false)
            $continue = false;
    }
}
if($continue){
    $log .= "<b>Retrieving commit logs...</b> <br>";
    $commits = execute('git log -'.$behind[1], WORK_DIR);
    foreach ($commits as $k => $o) {
        if($o != "" && $k != 'code')
            $log .= '<pre>' . $o . '</pre><br>';
    }

    $log .= "<b>Pushing to " . BRANCH . " repo...</b> <br>";
    $output = execute('git push origin ' . BRANCH, WORK_DIR);
    foreach ($output as $k => $o) {
        if($o != "" && $k != 'code')
            $log .= '<pre>' . $o . '</pre><br>';
    }
}

$log .= "<b>Sending email...</b> <br>";
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subject = $_SERVER['HTTP_HOST'] . ' ' . strtoupper(BRANCH) . ' auto deploy message ';
if(strstr($output['err'], 'error') || strstr($output['err'], 'Aborting'))
    $subject = $_SERVER['HTTP_HOST'] . ' ' . strtoupper(BRANCH) . ' FAILED auto deploy';

$body =
    '<pre>' . $output['out'] . '</pre>' .
    '<br/>'.
    '<pre>' . $output['err'] .'</pre>' .
    $log . 'Email sent!</div>';

if(mail('stuart@simpleclick.com.au, john@simpleclick.com.au, chris@simpleclick.com.au', $subject, $body, $headers))
    $log .= "Email sent.</div>";
else
    $log .= "There was an error in sending the email.</div>";

echo $log;
/**
 * Executes a command and reurns an array with exit code, stdout and stderr content
 * @param string $cmd - Command to execute
 * @param string|null $workdir - Default working directory
 * @return string[] - Array with keys: 'code' - exit code, 'out' - stdout, 'err' - stderr
 */
function execute($cmd, $workdir = null) {

    if (is_null($workdir)) {
        $workdir = __DIR__;
    }

    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("pipe", "w"),  // stdout
        2 => array("pipe", "temp.txt", "w"),  // stderr
    );

    $process = proc_open($cmd, $descriptorspec, $pipes, $workdir, null);

    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    return [
        'code' => proc_close($process),
        'out' => trim($stdout),
        'err' => trim($stderr),
    ];
}