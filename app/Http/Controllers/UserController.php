<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('phones')->get()->toArray();

        if(empty($users)) throw new NotFoundHttpException;

        return response()->json([
            'errors' => false,
            'data' => $users,
        ], 200);
    }

    public function byId($id)
    {
        $user = User::where(['id'=> $id])->with('phones')->first();

        if(!$user) throw new NotFoundHttpException;

        return response()->json([
            'errors' => false,
            'data' => [$user],
        ], 200);
    }

    public function byName( Request $request )
    {
        $data = array_filter($request->all(['name', 'surname', 'patronymic']));

        $users = User::where($data)->with('phones')->get()->toArray();

        if(empty($users)) throw new NotFoundHttpException;

        return response()->json([
            'errors' => false,
            'data' => $users,
        ], 200);
    }

    public function byPhone( $phone )
    {
        $user = User::whereHas('phones', function ($query) use ($phone) {
            $query->where('number', '=', $phone );
        })->with('phones')->first();

        if(empty($user)) throw new NotFoundHttpException;

        return response()->json([
            'errors' => false,
            'data' => [$user],
        ], 200);
    }

    public function post (UserCreateRequest $request)
    {
        $user_data = $request->all(['name', 'surname', 'patronymic']);

        $phones_data = $request->get('phones');

        $user = User::create($user_data);

        $user->phones()->createMany($phones_data);

        return response()->json([
            'errors' => false,
            'data' => [User::where(['id'=> $user->id])->with('phones')->first()],
        ], 200);
    }

    public function delete ( $id )
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'errors' => false,
            'data' => [['id' => $id]],
        ], 200);
    }

    public function update ( UserUpdateRequest $request)
    {
        $user = User::findOrFail($request->get('id'));

        $user_data = $request->all(['name', 'surname', 'patronymic']);

        $phones_data = $request->get('phones');

        $user->phones()->delete();

        $user->update($user_data);

        $user->phones()->createMany($phones_data);

        return response()->json([
            'errors' => false,
            'data' => [User::where(['id'=> $user->id])->with('phones')->first()],
        ], 200);
    }
}
