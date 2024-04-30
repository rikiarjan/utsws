<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    protected $authorization = 123;

    public function index(Request $request)
    {
        if ($request->header('Authorization') != $this->authorization) {
            $response = ApiFormatter::createJson(401, 'Unauthorized');
            return response()->json($response);
        }

        $mahasiswa = Mahasiswa::orderby('id', 'ASC')->get();
        if ($request->header('Accept') == 'text/html') {
            $html = '<ul>';
            foreach ($mahasiswa as $key => $value) {
                $html .= '<li>' . $value->province_name . '</li>';
            }
            $html .= '</ul>';

            return response($html)->header('Content-Type', 'text/html');
        }

        $response = ApiFormatter::createJson(200, 'Get Data Success', $mahasiswa);
        return response()->json($response);


        // // Ambil semua data mahasiswa dari database
        // $mahasiswa = Mahasiswa::orderby('id', 'ASC')->get();
        // $response = ApiFormatter::createJson(200, 'Get Data Success', $mahasiswa);
        // return response()->json($response);
    }

    public function detail($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);

            if (is_null($mahasiswa)) {
                return ApiFormatter::createJson(404, 'mahasiswa not found');
            }

            $response = ApiFormatter::createJson(200, 'Get detail mahasiswa sucess', $mahasiswa);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(400, $e->getMessage());
            return response()->json($response);
        }
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();

            $validator = Validator::make(
                $params,
                [
                    'nim' => 'required|max:10',
                    'nama_mahasiswa' => 'required',
                ],
                [
                    'nim.required' => 'Nim mahasiswa is required',
                    'nim.max'      => 'Nim mahasiswa must not exceed 10 characters',
                    'nama_mahasiswa.required' => 'Nama is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $mahasiswa = [
                'nim' => $params['nim'],
                'nama_mahasiswa' => $params['nama_mahasiswa'],
            ];

            $data = Mahasiswa::create($mahasiswa);
            $createdMahasiswa = Mahasiswa::find($data->id);

            $response = ApiFormatter::createJson(200, 'Create mahasiswa success', $createdMahasiswa);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();

            $preMahasiswa = Mahasiswa::find($id);
            if (is_null($preMahasiswa)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $validator = Validator::make(
                $params,
                [
                    'nim' => 'required|max:10',
                    'nama_mahasiswa' => 'required',
                ],
                [
                    'nim.required' => 'Nim mahasiswa is required',
                    'nim.max'      => 'Nim mahasiswa must not exceed 10 characters',
                    'nama_mahasiswa.required' => 'Nama is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $mahasiswa = [
                'nim' => $params['nim'],
                'nama_mahasiswa' => $params['nama_mahasiswa'],
            ];

            $preMahasiswa->update($mahasiswa);
            $updatedMahasiswa = $preMahasiswa->fresh();

            $response = ApiFormatter::createJson(200, 'Update mahasiswa success', $updatedMahasiswa);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function patch(Request $request, $id)
    {
        try {
            $params = $request->all();

            $preMahasiswa = Mahasiswa::find($id);
            if (is_null($preMahasiswa)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $validator = Validator::make(
                $params,
                [
                    'nim' => 'sometimes|max:10',
                    'nama_mahasiswa' => 'sometimes',
                ],
                [
                    'nim.max'      => 'Nim mahasiswa must not exceed 10 characters',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response);
            }

            $mahasiswa = [];

            if (isset($params['nim'])) {
                $mahasiswa['nim'] = $params['nim'];
            }

            if (isset($params['nama_mahasiswa'])) {
                $mahasiswa['nama_mahasiswa'] = $params['nama_mahasiswa'];
            }

            $preMahasiswa->update($mahasiswa);
            $updatedMahasiswa = $preMahasiswa->fresh();

            $response = ApiFormatter::createJson(200, 'Update mahasiswa success', $updatedMahasiswa);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }

    public function delete($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);

            if (is_null($mahasiswa)) {
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $mahasiswa->delete();

            $response = ApiFormatter::createJson(200, 'Delete province success');
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }
}
