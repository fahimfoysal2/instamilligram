<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->userRepo = $userRepository;
    }

    /**
     * Register/ Create a new user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'user_name' => 'required|unique:users,user_name',
            'password' => 'required|min:8',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'phone' => 'required|unique:users,phone',
            'bio' => 'string',
            'account_type' => 'int'
        ]);

        $user = $this->userRepo->register(array_merge(
            $request->except('password'),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
