<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClientRepository;

class ClientController extends Controller
{
    /**
     * The ClientRepository instance.
     *
     * @var \App\Repositories\ClientRepository
     */
    protected $ClientRepository;

    /**
     * Create a new ClientController instance.
     *
     * @param \App\Repositories\ClientRepository $ClientRepository
     * @return void
     */
    public function __construct(
        ClientRepository $ClientRepository
    ) {
        parent::__construct();
        $this->ClientRepository = $ClientRepository;
        $this->middleware('admin');
        $this->middleware('admin.client');
    }

    /**
     * Get client datatable list
     * @return json
     */
    public function getClientList () {
        return $this->ClientRepository->getClientList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Get region datatable list
     * @return json
     */
    public function getRegionList () {
        return $this->ClientRepository->getRegionList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Create the client
     * @return json
     */
    public function createClient () {
        $data = \Input::get('data');

        if (!$region = $this->ClientRepository->findRegionById(trim($data['region_id']))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data daerah tidak ditemukan.'
            ]);
        }

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;

        try {
            $model = $this->ClientRepository->store($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->client_name}] telah ditambah.",
        ]);
    }

    /**
     * Edit client page
     * @param string $id
     * @return html
     */
    public function editClient ($id) {
        if (!$model = $this->ClientRepository->findById(trim($id))) {
            return redirect(route('client.list'))->with('flashMessage', [
                'class' => 'danger',
                'message' => 'Data klien tidak ditemukan.'
            ]);
        }

        return view('client.edit')->with('model', $model);
    }

    /**
     * Edit client regional page
     * @param string $id
     * @return html
     */
    public function editClientRegional ($id) {
        if (!$model = $this->ClientRepository->findRegionById(trim($id))) {
            return redirect(route('client.regional.list'))->with('flashMessage', [
                'class' => 'danger',
                'message' => 'Data daerah tidak ditemukan.'
            ]);
        }

        return view('client.regionEdit')->with('model', $model);
    }

    /**
     * Update client
     * @param string $id
     * @return json
     */
    public function updateClient ($id) {
        if (!$model = $this->ClientRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data client #{$id} tidak ditemukan."
            ]);
        }

        $data = \Input::get('data');

        if (!$region = $this->ClientRepository->findRegionById(trim($data['region_id']))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data daerah tidak ditemukan.'
            ]);
        }

        try {
            $model = $this->ClientRepository->update($model, $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->client_name}] telah diubah.",
        ]);
    }

    /**
     * Delete client
     * @param string $id
     * @return json   
     */
    public function deleteClient ($id) {
        if (!$model = $this->ClientRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data klien #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => 'Data klien telah berhasil dihapus.'
        ]);
    }

    /**
     * Create regional
     * @return json
     */
    public function createRegional () {
        $data = \Input::get('data');

        if (!isset($data['is_parent'])) {
            if (!$region = $this->ClientRepository->findRegionById($data['parent_id'])) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data daerah tidak ditemukan.'
                ]);
            }

            if (!$region->is_parent) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data daerah bukan parent.'
                ]);
            }
            $data['is_parent'] = false;
        } else {
            $data['parent_id'] = 0;
            $data['is_parent'] = true;
        }

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;

        try {
            $model = $this->ClientRepository->storeRegional($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->region_name}] telah ditambah.",
            'redirect' => route('client.regional')
        ]);
    }

    /**
     * Update regional
     * @param string $id
     * @return json    
     */
    public function updateRegional ($id) {
        if (!$model = $this->ClientRepository->findRegionById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data daerah #{$id} tidak ditemukan.'
            ]);
        }

        $data = \Input::get('data');

        if (!isset($data['is_parent'])) {
            if (!$region = $this->ClientRepository->findRegionById($data['parent_id'])) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data daerah tidak ditemukan.'
                ]);
            }

            if (!$region->is_parent) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data daerah bukan parent.'
                ]);
            }
            $data['is_parent'] = false;
        } else {
            $data['parent_id'] = 0;
            $data['is_parent'] = true;
        }

        try {
            $model = $this->ClientRepository->update($model, $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->region_name}] telah diubah.",
            'redirect' => route('client.regional')
        ]);
    }

    /**
     * Delete regional
     * @param string $id
     * @return json    
     */
    public function deleteRegional ($id) {
        if (!$model = $this->ClientRepository->findRegionById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data daerah #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data daerah #{$id} telah dihapus.",
        ]); 
    }
}
