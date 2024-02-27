<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GenderModels;

class UserController extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function adduser()
    {
        $data = array();
        helper('form');

        //When button is clicked
        if($this->request == 'post')
        {
            $post = $this->request->getPost(['first_name', 'middle_name',
             'last_name', 'age', 'gender_id',
            'email', 'password']);

            //Provide
             $rules = [
                'first_name' => ['label' => 'first_name',
                'rules' => 'required'], 
                'middle_name' => ['label' => 'middle_name',
                'rules' => 'permit_empty'],
                'last_name' => ['label' => 'last_name',
                'rules' => 'required'],
                'age' => ['label' => 'age',
                'rules' => 'required|numeric'],
                'gender_id' => ['required'],
                'email' => ['label' => 'email',
                'rules' => 'required|is_unique[users.email]'],
                'password' => ['label' => 'password',
                'rules' => 'required'],
                'confirm_password' => ['label' => 'confirm password',
                'rules' => 'required_with[password]']
             ];

             if(! $this->validate ($rules))
             {
                $data['validation'] = $this->validator;
             } 
             
             else 
             {
                // Encrypt Password
                $post['password'] = sha1($post['password']);

                $userModel = new UserModel();
                $userModel ->save($post);

                return 'User Successfully saved!';
             }
        }

        // Fetch all values from genders table
        $genderModel = new GenderModel();
        $data = [genders] = $genderModel->findAll();

        return view('user/add', $data);
    }
}
