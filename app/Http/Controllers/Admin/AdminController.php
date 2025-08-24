<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\AdminListBuilder;
use App\Models\Admin;
use DB;
use Exception;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Throwable;
use Validator;

class AdminController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return AdminListBuilder::render();
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $this->validate($request, [
            'name' => [
                'required',
                'unique:admins',
            ],
            'email' => [
                'required', 'email:rfc,dns',
                'unique:admins',
            ],
            'mobile' => [
                'required', 'regex:/^[6789][0-9]{9}$/',
                'unique:admins',
            ],
            'is_super' => 'required',
            'permissions' => 'required_if:is_super,===,0|array',
            'permissions.*' => 'required_if:is_super,===,0|exists:permissions,name',
            'password' => 'required|without_spaces',
        ], [
            'email.required' => 'The Email ID is required',
            'name.required' => 'The name is required',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'Mobile number already exists',
            'is_super.required' => 'The is super admin required',
            'permissions.required_if' => "The permission is required when super admin is selected as a 'No'",
            'permissions.*.required_if' => "The permission is required when super admin is selected as a 'No'",
            'email.email' => 'The Email ID must be a valid format',
            'email.unique' => 'Email already exists',
            'permissions.required' => 'At least one permission is required',
            'password.without_spaces' => 'The password cannot contain white spaces',
            'password.required' => 'The password is required',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $admin = Admin::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'mobile' => $request->get('mobile'),
                    'is_super' => $request->get('is_super') == true,
                    'password' => Hash::make($request->get('password')),
                    'status' => Admin::STATUS_ACTIVE,
                    'creator_id' => $this->admin->id,
                ]);

                $admin->assignRole('admin');

                if ($request->get('is_super') == 0) {
                    $admin->givePermissionTo($request->get('permissions'));
                }

                return redirect()->route('admin.admins.index')->with(['success' => 'Admin added successfully']);
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    public function create(): Factory|View|Application
    {
        $permissions = Permission::all()
            ->groupBy(function (Permission $permission) {
                return preg_replace('/-(create|read|update|delete)/', '', $permission->name);
            });

        return view('admin.admins.create', [
            'permissions' => $permissions,
        ]);
    }

    public function edit(Admin $admin): Renderable|RedirectResponse
    {
        if ($admin->id === 1) {
            return redirect()->route('admin.admins.index')->with(['error' => 'Invalid Admin']);
        }

        $permissions = Permission::all()
            ->groupBy(function (Permission $permission) {
                return preg_replace('/-(read|create|update|delete)/', '', $permission->name);
            });

        return view('admin.admins.edit', [
            'admin' => $admin,
            'permissions' => $permissions,
        ]);
    }

    public function changePassword(Admin $admin): Factory|View|Application
    {
        return view('admin.admins.change-password', ['admin' => $admin]);
    }

    /**
     * @throws ValidationException
     */
    public function changePasswordUpdate(Admin $admin, Request $request): RedirectResponse
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $this->validate($request, [
            'password' => 'required|without_spaces|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'The new password is required',
            'password_confirmation.required' => 'The confirm password is required',
            'password.without_spaces' => 'Space not allowed in new password',
            'password.confirmed' => 'The password confirmation does not match',
            'password_confirmation.without_spaces' => 'Space not allowed in confirm password',
        ]);
        try {
            $password = $request->get('password');
            $admin->update([
                'password' => Hash::make($password),
            ]);

            return redirect()->route('admin.admins.index')->with(['success' => 'Password changed successfully']);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(Admin $admin, Request $request): JsonResponse|RedirectResponse
    {
        if ($admin->id === 1) {
            return redirect()->route('admin.admins.index')->with(['error' => 'Invalid User']);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:admins,email,'.$admin->id,
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/|unique:admins,mobile,'.$admin->id,
            'is_super' => 'required',
            'permissions' => 'required_if:is_super,===,0|array',
            'permissions.*' => 'required_if:is_super,===,0|exists:permissions,name',
        ], [
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'Mobile number already exists',
            'is_super.required' => 'The is super admin required',
            'permissions.required_if' => 'The permissions is required when is super admin is No',
            'permissions.*.required_if' => 'The permissions is required when is super admin is No',
            'email.email' => 'The email must be a valid format',
            'email.unique' => 'Email already exists',
            'permissions.required' => 'At least one permission is required',
        ]);
        try {
            return DB::transaction(function () use ($request, $admin) {
                $admin->name = $request->get('name');
                $admin->email = $request->get('email');
                $admin->mobile = $request->get('mobile');
                $admin->is_super = $request->get('is_super') == true;
                $admin->save();

                if ($request->get('is_super') == 0) {
                    $admin->syncPermissions($request->get('permissions'));
                }

                return redirect()->route('admin.admins.edit', $admin)->with(['success' => 'Admin update successfully']);
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    public function updateStatus(Admin $admin): JsonResponse|RedirectResponse
    {
        try {
            if ($admin->status == Admin::STATUS_ACTIVE) {
                $admin->status = Admin::STATUS_IN_ACTIVE;
            } else {
                $admin->status = Admin::STATUS_ACTIVE;
            }
            $admin->save();

            return redirect()->route('admin.admins.index')->with(['success' => 'Status changed successfully']);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
