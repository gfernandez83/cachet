
<?php


$code = $argv[1];
print $code;

/*switch ($code) {
    case 200: 
    case 301:
    case 302:
        $component_status = 1;
        break;
    case 500: 
    case 0: 
    case 504:
    case 503:
    case 502:    
        $component_status = 4;
        break;
    case 522: 
    case 520: 
    case 523:
        $component_status = 3;
        break;
    default:
        $component_status = 2;
        break;
}
*/

switch ($code) {
    case 200:
    case 301:
    case 302:
        $component_status = 1;
        print $component_status;
        break;
    case 500:
    case 0:
    case 504:
    case 503:
    case 502:
        $component_status = 4;
        print $component_status;
        break;
    case 522:
    case 520:
    case 523:
        $component_status = 3;
        print $component_status;
        break;
    default:
        $component_status = 2;
        print $component_status;
        break;
}

?>
