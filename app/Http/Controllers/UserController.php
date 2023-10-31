<?php
// php artisan make:controller NomeDoController
namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\USerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return USerResource::collection($users);
    }

    public function store(StoreUpdateUserRequest $resquest)
    {
        //  all -> Pega todos os dados do request
        // $data = $resquest->all();
        //  all -> Pega todos os dados validados do request
        $data = $resquest->validated();
        // dd($data);
        $user = User::create($data);
        return new USerResource($user);
    }

    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();

        if ($request->password)
            $data['password'] = bcrypt($request->password);

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
