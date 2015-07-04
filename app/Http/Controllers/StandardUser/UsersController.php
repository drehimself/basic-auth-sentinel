<?php

namespace App\Http\Controllers\StandardUser;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UsersEditFormRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    /**
     * @var $user
     */
    protected $user;


    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;

        $this->middleware('notCurrentUser', ['only' => ['show', 'edit', 'update']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // $user = User::findOrFail($id);
        $user = $this->user->find($id);

        return view('protected.standardUser.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // $user = User::findOrFail($id);
        $user = $this->user->find($id);

        return view('protected.standardUser.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UsersEditFormRequest $request)
    {
        // $user = User::findOrFail($id);
        $user = $this->user->find($id);

        if (! $request->has("password")) {
            $input = $request->only('email', 'first_name', 'last_name');

            //$this->usersEditForm->excludeUserId($user->id)->validate($input);

            $user->fill($input)->save();

            return redirect()->route('profiles.edit', $user->id)
                             ->withFlashMessage('User has been updated successfully!');

        } else {
            $input = $request->only('email', 'first_name', 'last_name', 'password');

            //$this->usersEditForm->excludeUserId($user->id)->validate($input);

            // $input = array_except($input, ['password_confirmation']);

            $user->fill($input);
            $user->password = \Hash::make($request->input('password'));
            $user->save();

            //$user->save();

            return redirect()->route('profiles.edit', $user->id)
                             ->withFlashMessage('User (and password) has been updated successfully!');
        }
    }
}
