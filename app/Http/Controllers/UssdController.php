<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UssdController extends Controller
{
    //
    public function onlineUssdMenu(Request $request)
    {
        $sessionId = $request->get('sessionId');
        $serviceCode = $request->get('serviceCode');
        $mobileNumber = $request->get('mobileNumber');
        $text = $request->get('text');
        // use explode to split the string text response from Africa's talking gateway into an array
        $ussdStringExploded = explode("*", $text);
        // Get ussd menu level number from the gateway
        $level = count($ussdStringExploded);
        $this->menuStatus($text, $ussdStringExploded, $level);
    }

    private function menuStatus($text, $ussdStringExploded, $level)
    {
        switch ($text) {
                case "":
                   $response = "CON Welcome to mAgric Farmer Onboarding".PHP_EOL;
                   $response .= "Are you a farmer ?".PHP_EOL;
                   $response .= "1. Yes".PHP_EOL;
                   $response .= "2. No".PHP_EOL;
                    break;

                case "1":
                    $response = "CON Name: Philip Appiah".PHP_EOL;
                    $response .= "1. Confirm".PHP_EOL;
                    $response .= "2. Cancel".PHP_EOL;;
                    break;

                case "1*1":
                    $response = "CON Select type of crop".PHP_EOL;
                    $response .= "1. Cocoa".PHP_EOL;
                    $response .= "2. Cashew".PHP_EOL;
                    $response .= "3. Coffee".PHP_EOL;
                    $response .= "4. Other".PHP_EOL;
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level ==3):
                        $response .= "CON Select quantity of last safe".PHP_EOL;
                        $response .= "1. 0 - 54kg".PHP_EOL;
                        $response .= "2. 55 - 124kg".PHP_EOL;
                        $response .= "3. 125 - 254kg".PHP_EOL;
                        $response .= "4. 255 - 500kg".PHP_EOL;
                        $response .= "5. Greater than 500kg".PHP_EOL;
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level ==4):
                        $response .= "CON Enter the location of your farm".PHP_EOL;
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level == 5):
                        $response .= "END You have been" .PHP_EOL;
                        $response .= "successfully registered " .PHP_EOL;
                        $response .= "as a farmer" .PHP_EOL;
                        $response .= "" .PHP_EOL;
                        $response .= "Thank you" .PHP_EOL;

                    break;


                case "1*2":
                        $response = "END ";
                        break;
                default:
                      // Our response a user respond with input 2 from our first level
                         $response = "END";
                    break;
            }
        echo $response;
    }
}
