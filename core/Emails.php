<?php
namespace Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class Emails {
    public function sendEmail($email, $subject, $message) {

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->SMTPAuth = true;
        $mail->Port = EMAIL_PORT;
        $mail->SMTPSecure = ($mail->Port == 587)?'tls':'ssl';
        $mail->Host = EMAIL_HOST;
        $mail->Mailer = "smtp";
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->IsHTML(true);

        $mail->setFrom(EMAIL_SENDER, SENDER_NAME);
        $mail->addAddress($email);
        $mail->Subject  = $subject;
        $mail->Body     =  $message;
        return $mail->send();

    }

    public static function forgottenPasswordSablon($username, $email, $token) {
        //elfelejtett jelszó sablon
        $message = "";
        $message = "<html><body>";
        $message .= "<h2 style='color: #000';>Kedves " .$username. "!</h2>";
        $message .= "<p style='color: #000';>Korábban kérte a felhasználó fiókjához tartozó jelszava módosítását.</p>";
        $message .= "<p style='color: #000';>Amennyiben szeretne a fiókjához tartozó jelszót megváltoztatni, kérjük kattintson vagy másolja az alábbi linket böngészőjébe.</p>";
        $message .= "<a href='localhost/webapp/register/passwordChange/".$token."'>localhost/webapp/register/passwordChange/".$token."</a>";
        $message .= "<p style='color: #000';>Amennyiben nem ön kérelmezte a jelszó emlékeztetőt, levelünket kérjük tekintse tárgytalannak.</p>";
        $message .= "<p style='color: #000';>Üdvözlettel:</p>";
        $message .= "<p style='color: #000';>Mezőgazdasági és Őstermelői Aukciósportál ügyfélszolgálata</p>";

        self::sendEmail($email, 'Elfelejtett jelszó', $message);
    }

    public static function closedAuctionEmailSablon($product, $vendor, $sold = 0, $bid = '', $customer = NULL) {
        if ($sold == 1) {
            //customer email sablon
            $message = "";
            $message = "<html><body>";
            $message .= "<h1 style='color:#000;'>Tisztelt ".$customer->username."!</h1>";
            $message .= "<h4 style='color:#000;'>Gratulálunk, az Ön által ajánlot licit volt a legmagasabb, ezáltal megnyerte a licitre bocsátott terméket!</h4>";
            $message .= "<h3 style='margin-top:20px; color: #000;'>Árverés adatai:</h3>";
            $message .= "<table rules='all' style='border-color: #666;' cellpadding='10'";
            $message .= "<tr style='background: #eee;'><td><strong>Termék azonosító:</strong> </td><td>". strip_tags($product->id) ."</td></tr>";
            $message .= "<tr><td><strong>Termék neve:</strong> </td><td>" . strip_tags($product->product_name) . "</td></tr>";
            $message .= "<tr><td><strong>Termék ára:</strong> </td><td>" . strip_tags($bid->bid_amount) . " Ft</td></tr>";
            $message .= "<tr><td><strong>Termék mennyisége:</strong> </td><td>" . strip_tags($product->quantity) . " kg</td></tr>";
            $message .= "<tr><td><strong>Eladó felhasználó neve:</strong> </td><td>" . strip_tags($vendor->username). "</td></tr>";
            $message .= "<tr><td><strong>Eladó e-mail címe:</strong> </td><td>" . strip_tags($vendor->email) . "</td></tr>";
            $message .= "<tr><td><strong>Eladó mobiltelefonszáma:</strong> </td><td>" . strip_tags($vendor->mobile_phone) . "</td></tr>";
            if (isset($vendor->phone) && $vendor->phone != '' )
            $message .= "<tr><td><strong>Eladó telefonszáma:</strong> </td><td>" . strip_tags($vendor->phone) . "</td></tr>";
            $message .= "</table>";
            $message .= "<p>Kérem vegye fel a kapcsolatot az eladóval!</p>";
            $message .= "<p>Üdvözlettel:</p>";
            $message .= "<p>Mezőgazdasági és Őstermelői Aukciósportál ügyfélszolgálata</p>";
            $message .= "</body></html>";
            self::sendEmail($customer->email, 'Megnyert árverés', $message);

            //vendor email sablon
            $message = "";
            $message = "<html><body>";
            $message .= "<h1 style='color:#000;'>Tisztelt ".$vendor->username."!</h1>";
            $message .= "<h3 style='color:#000'>Gratulálunk, az Ön által árverésre bocsátott termék elkelt.</h3>";
            $message .= "<h3 style='margin-top:20px; color: #000;'>Árverés adatai:</h3>";
            $message .= "<table rules='all' style='border-color: #666;' cellpadding='10'";
            $message .= "<tr style='background: #eee;'><td><strong>Termék azonosító:</strong> </td><td>". strip_tags($product->id) ."</td></tr>";
            $message .= "<tr><td><strong>Termék neve:</strong> </td><td>" . strip_tags($product->product_name) . "</td></tr>";
            $message .= "<tr><td><strong>Termék ára:</strong> </td><td>" . strip_tags($bid->bid_amount) . " Ft</td></tr>";
            $message .= "<tr><td><strong>Termék mennyisége:</strong> </td><td>" . strip_tags($product->quantity) . " kg</td></tr>";
            $message .= "<tr><td><strong>Vásárló felhasználó neve:</strong> </td><td>" . strip_tags($customer->username). "</td></tr>";
            $message .= "<tr><td><strong>Vásárló e-mail címe:</strong> </td><td>" . strip_tags($customer->email) . "</td></tr>";
            $message .= "<tr><td><strong>Vásárló mobiltelefonszáma:</strong> </td><td>" . strip_tags($customer->mobile_phone) . "</td></tr>";
            if (isset($customer->phone) && $customer->phone != '' )
            $message .= "<tr><td><strong>Vásárló telefonszáma:</strong> </td><td>" . strip_tags($customer->phone) . "</td></tr>";
            $message .= "</table>";
            $message .= "<p>Kérem vegye fel a kapcsolatot a vásárlóval!</p>";
            $message .= "<p>Üdvözlettel:</p>";
            $message .= "<p>Mezőgazdasági és Őstermelői Aukciósportál ügyfélszolgálata</p>";
            $message .= "</body></html>";
            self::sendEmail($vendor->email, 'Lezárult árverés(ek)', $message);
        } else {
            // sikertelen árverés email sablon
            $message = "";
            $message = "<html><body>";
            $message .= "<h1 style='color:#000;'>Tisztelt ".$vendor->username."!</h1>";
            $message .= "<h3 style='color:#000'>Sajnáljuk, az alábbi árverésre bocsátott terméke nem kelt el.</h3>";
            $message .= "<h3 style='margin-top:20px; color: #000;'>Árverés adatai:</h3>";
            $message .= "<table rules='all' style='border-color: #666;' cellpadding='10'";
            $message .= "<tr style='background: #eee;'><td><strong>Termék azonosító:</strong> </td><td>". strip_tags($product->id) ."</td></tr>";
            $message .= "<tr><td><strong>Termék neve:</strong> </td><td>" . strip_tags($product->product_name) . "</td></tr>";
            $message .= "<tr><td><strong>Termék ára:</strong> </td><td>" . strip_tags($product->price) . " Ft</td></tr>";
            $message .= "<tr><td><strong>Termék mennyisége:</strong> </td><td>" . strip_tags($product->quantity) . " kg</td></tr>";
            $message .= "</table>";
            $message .= "<p>Amennyiben elszeretné adni a terméket, kérjük töltse fel újra!</p>";
            $message .= "<p>Üdvözlettel:</p>";
            $message .= "<p>Mezőgazdasági és Őstermelői Aukciósportál ügyfélszolgálata</p>";
            $message .= "</body></html>";
            self::sendEmail($vendor->email, 'Lezárult árverés(ek)', $message);
        }
    }
}
