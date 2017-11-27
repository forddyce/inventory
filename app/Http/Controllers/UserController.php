<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $UserRepository;

    /**
     * Create a new UserController instance.
     * 
     * @param \App\Repositories\UserRepository $UserRepository
     * @return void
     */
    public function __construct (
        UserRepository $UserRepository
    ) {
        parent::__construct();
        $this->UserRepository = $UserRepository;
        $this->middleware('admin');
        $this->middleware('admin.user');
    }

    /**
     * Get user list
     * @return json
     */
    public function getList () {
        return $this->UserRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Create User
     * @return json
     */
    public function createUser () {
        $data = \Input::get('data');

        try {
            $user = $this->UserRepository->createUser($data);
        } catch (\Exception $e) {
            if (isset($user)) $user->delete();
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "User berhasil dibuat."
        ]);
    }

    /**
     * Edit User Page
     * @param string $id
     * @return html
     */
    public function editUser ($id) {
        if (!$updateUser = \Sentinel::findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "User tidak ditemukan."
            ]);
        }

        return view('user.edit')->with('model', $updateUser);
    }

    /**
     * Update User
     * @param string $id
     * @return json
     */
    public function updateUser ($id) {
        if (!$updateUser = \Sentinel::findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "User tidak ditemukan."
            ]);
        }

        if ($updateUser->email == 'forddyce92@gmail.com') {
            return \Response::json([
                'type' => 'error',
                'message' => "User tidak dapat diupdate."
            ]);
        }

        $data = \Input::get('data');

        try {
            $user = $this->UserRepository->updateUser($updateUser, $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "User berhasil diupdate."
        ]);
    }

    /**
     * Delete User
     * @param string $id
     * @return json
     */
    public function deleteUser ($id) {
        if (!$checkUser = \Sentinel::findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "User tidak ditemukan."
            ]);
        }

        if ($checkUser->email == 'forddyce92@gmail.com') {
            return \Response::json([
                'type' => 'error',
                'message' => "User tidak dapat diupdate."
            ]);
        }

        $checkUser->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "User berhasil dihapus."
        ]);
    }
}
