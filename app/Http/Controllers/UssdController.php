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
                   $response = "CON Welcome to EPay \n";
                   $response .= "1. Register \n";
                   $response .= "2. EPay";
                    break;

                case "1":
                    $response = "CON Choose a payment platform you want to register under EPay/n";
                    $response .= "1. FastPay Services \n";
                    $response .= "2. RemotePay Services \n";
                    break;

                case "1*1":
                    $response = "CON Please enter your name /n";
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level ==3):
                        $response = "CON Please enter your email /n";
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level ==4):
                        $response = "CON Please enter your Phone number /n";
                    break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 1 && $level == 5):
                        $response = "END Your data has been captured successfully! Thank you for registering for Fast Services  at EPay. /n";
                    break;


                case "1*2":
                        $response = "CON Please enter your name /n";
                        break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 2 && $level ==3):
                            $response = "CON Please enter your email /n";
                        break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 2 && $level ==4):
                            $response = "CON Please enter your Phone number /n";
                        break;

                case ($ussdStringExploded[0] == 1 && $ussdStringExploded[1] == 2 && $level == 5):
                            $response = "END Your data has been captured successfully! Thank you for registering for Remote Pay Services  at EPay. /n";
                        break;

                default:
                      // Our response a user respond with input 2 from our first level
                         $response = "END At  EPay gret services!.";
                    break;
            }
        echo $response;
    }
}
