<?php

namespace App\Models;

use CodeIgniter\Model;
use \Hermawan\DataTables\DataTable;

class HomeModel extends Model
{
    public function insert_edit_contact($post)
    {
        $db = $this->db;
        $builder = $db->table('contact_us');
        $msg = array();
        $pdata = array(
            'name' => $post['name'],
            'email' => $post['email'],
            'mobile' => $post['mobile'],
            'subject' => $post['subject'],
            'message' => $post['message'],
            'created_at' => date('Y-m-d H:i:s'),

        );
        $result = $builder->Insert($pdata);
        $post['id'] = $db->insertID();

        $send_user = $this->send_mail_user($post);
        $send_admin = $this->send_mail_admin($post);

        if ($result) {
            $msg = array('st' => 'success', 'msg' => "Your Details Added Successfully!!!");
        } else {
            $msg = array('st' => 'fail', 'msg' => "Your Details Updated fail");
        }

        return $msg;
    }
    public function send_mail_user($post)
    {
        $email = \Config\Services::email();

        $email->setTo($post['email']);

        $email->setFrom('<info@ampraish.co.uk>', 'AMp');

        $email->setSubject('Thank you for contacting us!');

        $name = $post['name'];
        $uemail = $post['email'];
        $subject = $post['subject'];
        $message = $post['message'];

        // Set message body with <br> tags for line breaks

        $message = "
            Hello $name,<br><br>

            Thank you for reaching out to us. We’ve received your message and our support team will get back to you as soon as possible.<br><br>
        
            We appreciate your patience and will reply within 24–48 hours.<br><br>

            Best regards,  <br>
            [Amparish]  <br>
            [info@ampraish.co.uk] <br> [+44 (0) 7717364224]

        ";
        $email->setMessage($message);

        $email->setMailType('html');
        if ($email->send()) {
            echo "✅ Email sent successfully!";
        } else {
            // Show debug info if failed
            echo "❌ Email not sent.<br>";
            echo $email->printDebugger(['headers']);
        }
    }
    public function send_mail_admin($post)
    {
        $email = \Config\Services::email();

        $name = $post['name'];
        $uemail = $post['email'];
        $subject = $post['subject'];
        $message = $post['message'];
        $date = date('Y-m-d H:i:s');

        $email->setTo('truptipatel.koffeekodes@gmail.com');


        $email->setFrom('<truptipatel.koffeekodes@gmail.com>', '');

        $email->setSubject('New Contact Form Submission ' . $uemail);


        // Set message body with <br> tags for line breaks

        $message = "
            Hello Admin,<br><br>

            A new message has been submitted through the Contact Us form.<br><br>
            Here are the details:<br>
            Name: $name<br>
            Email: $uemail<br>
            Subject: $subject<br>
            Message: $message<br>
            Submitted on: $date<br><br>

            Please review and respond to the user at your earliest convenience.<br><br>

            regards,  <br>
            [Amparish]  <br>
        ";
        $email->setMessage($message);

        $email->setMailType('html');
        if ($email->send()) {
            //echo "✅ Email sent successfully!";
        }
    }
}
