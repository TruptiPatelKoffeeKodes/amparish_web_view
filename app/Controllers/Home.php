<?php

namespace App\Controllers;

use App\Models\HomeModel;

class Home extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: * ");
        $this->model = new HomeModel();
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        return view('home/index', $data);
    }
    public function product()
    {
        $data['title'] = "Product";
        return view('home/product', $data);
    }
    public function contact()
    {
        $post = $this->request->getPost();
        if(!empty($post))
        {
            $msg = $this->model->insert_edit_contact($post);
            return $this->response->setJSON($msg);
        }
        $data['title'] = "Contact";
        return view('home/contact', $data);
    }
    public function sendMail()
    {
        $post = array(
            'name' => 'trupti',
            'email' => 'truptipatel.koffeekodes@gamil.com',
            'subject' => 'test',
            'message' => 'test',
        );
        $customerIds = $this->model->send_mail_user($post);
        return $this->response->setJSON($customerIds);
    }
    
}
