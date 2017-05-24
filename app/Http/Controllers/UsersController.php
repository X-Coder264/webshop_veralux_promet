<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;

class UsersController extends Controller
{
    /**
     * Show a list of all the users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function data()
    {
        $users = User::withTrashed()->get(['id', 'name', 'email', 'verified', 'slug', 'created_at', 'deleted_at']);

        return Datatables::of($users)
            ->editColumn('created_at', function (User $user) {
                Carbon::setLocale('hr');
                return $user->created_at->diffForHumans();
            })->add_column('activated', function (User $user) {
                if ($user->verified) {
                    return "Aktiviran";
                } else {
                    return "Nije aktiviran";
                }
            })->add_column('actions', function(User $user) {
                $actions = "";
                if (! $user->trashed()) {
                    $actions .= '<a href='. route('admin.users.show', $user->slug) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i></a>
                            <a href='. route('admin.users.edit', $user->slug) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>';
                }

                if (Auth::user()->id != $user->id) {
                    if (! $user->trashed()) {
                        $actions .= '<a href='. route('admin.confirm-delete/user', $user->slug) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>';
                    } else {
                        $actions .= '<a href='. route('admin.restore/user', $user->id) .' <i class="livicon" data-name="user-restore" data-size="18" data-loop="true" data-c="#f36254" data-hc="#f36254" title="restore user"></i></a>';
                    }
                }
                return $actions;
            })->rawColumns(['actions'])->make(true);
    }

    /**
     * Create new user form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new user in the DB.
     * @param  UserRequest $request
     * @return Redirect
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'), ['rounds' => 15]);
        $user->email = $request->input('email');
        $user->phone = $request->input('phone', '');
        $user->company = $request->input('company', '');
        $user->company_id = $request->input('company_id', '');
        $user->city = $request->input('place', '');
        $user->address = $request->input('address', '');
        $user->postal = $request->input('post', '');
        $user->verified = 1;

        if (! $user->save()) {
            // Redirect to the user creation page
            return Redirect::back()->withInput()->with('error', "Pogreška.");
        }

        // Redirect to the home page with success menu
        return Redirect::route('admin.users.index')->with('success', "Korisnik je uspješno stvoren.");
    }

    /**
     * Display specified user profile.
     *
     * @param  User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Return user orders.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showOrders($id)
    {
        $orders = Order::where('user_id', '=', $id)->get();

        return Datatables::of($orders)
            ->edit_column('created_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->created_at->format('d.m.Y. H:i:s') . " (" . $order->created_at->diffForHumans() . ")";
            })->edit_column('updated_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->updated_at . " (" . $order->updated_at->diffForHumans() . ")";
            })->make(true);

    }

    /**
     * User update form.
     *
     * @param  string $user
     * @return \Illuminate\View\View
     */
    public function edit($user = null)
    {
        $user = User::withTrashed()->whereSlug($user)->first();
        return view('admin/users/edit', ['user' => $user]);
    }

    /**
     * Update user data in the DB.
     *
     * @param  User $user
     * @param UserRequest $request
     * @return Redirect
     */
    public function update(User $user, UserRequest $request)
    {
        $data = $request->intersect([
            'name',
            'email',
            'company',
            'company_id',
            'phone',
            'city',
            'address',
            'postal'
        ]);

        // check if the user was updated
        if ($user->update($data)) {
            // the admin field is not fillable so an additional query is needed
            if ($request->has('admin')) {
                $user->admin = true;
            } elseif(Auth::user()->id === $user->id) {
                $user->admin = true;
            } elseif($user->id !== 1) {
                $user->admin = false;
            }

            $user->save();

            // Prepare the success message
            $success = "Promjene su uspješno spremljene.";

            // Redirect to the user page
            return Redirect::route('admin.users.edit', $user)->with('success', $success);
        }

        // Prepare the error message
        $error = "Dogodila se pogreška";

        // Redirect to the user page
        return Redirect::route('admin.users.edit', $user)->withInput()->with('error', $error);
    }

    /**
     * Show a list of all the deleted users.
     *
     * @return \Illuminate\View\View
     */
    public function getDeletedUsers()
    {
        // Grab deleted users
        $users = User::onlyTrashed()->get();

        // Show the page
        return view('admin/deleted_users', compact('users'));
    }


    /**
     * Delete Confirm
     *
     * @param   User $user
     * @return  \Illuminate\View\View
     */
    public function getModalDelete(User $user)
    {
        $type = 'delete';
        $model = 'user';
        $confirm_route = $error = null;

        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::user()->id) {
            // Prepare the error message
            $error = Lang::get('users/message.error.delete');

            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }

        $confirm_route = route('admin.delete/user', $user);
        return view('admin.layouts.modal_confirmation', compact('error', 'type', 'model', 'confirm_route', 'user'));
    }

    /**
     * Delete the given user.
     *
     * @param  User $user
     * @return Redirect
     */
    public function destroy(User $user)
    {
        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::user()->id) {
            // Prepare the error message
            $error = "Ne možeš obrisati samog sebe";

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }

        // Soft delete the user
        $user->delete();

        // Prepare the success message
        $success = "Korisnik je uspješno obrisan.";

        // Redirect to the user management page
        return Redirect::route('admin.users.index')->with('success', $success);
    }

    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($id = null)
    {
        // Get user information
        $user = User::withTrashed()->find($id);

        // check if the user was restored
        if ($user->restore()) {
            // Prepare the success message
            $success = "Korisnik je vraćen.";

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('success', $success);
        }

        // Prepare the error message
        $error = "Dogodila se pogreška";

        // Redirect to the user page
        return Redirect::route('admin.users.index')->withInput()->with('error', $error);
    }

    public function passwordreset(User $user, Request $request)
    {
        if ($request->ajax()) {
            $password = $request->input('password');
            $user->password = Hash::make($password, ['rounds' => 15]);
            if ($user->save()) {
                return "success";
            }
        }
    }
}
