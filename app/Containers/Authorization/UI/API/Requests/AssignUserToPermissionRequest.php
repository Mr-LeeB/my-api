<?php

namespace App\Containers\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class AssignUserToRoleRequest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AssignUserToPermissionRequest extends Request
{

  /**
   * Define which Roles and/or Permissions has access to this request.
   *
   * @var  array
   */
  protected $access = [
    'roles' => '',
    'permissions' => 'manage-admins-access',
  ];

  /**
   * Id's that needs decoding before applying the validation rules.
   *
   * @var  array
   */
  protected $decode = [
    'user_id',
    'permissions_ids.*',
  ];

  /**
   * Defining the URL parameters (`/stores/999/items`) allows applying
   * validation rules on them and allows accessing them like request data.
   *
   * @var  array
   */
  protected $urlParameters = [

  ];

  /**
   * @return  array
   */
  public function rules()
  {
    // dd("test");
    return [
      'permissions_ids' => 'array|required',
      'permissions_ids.*' => 'exists:permissions,id',
      'user_id' => 'required|exists:users,id',
    ];
  }

  /**
   * @return  bool
   */
  public function authorize()
  {
    return $this->check([
      'hasAccess',
    ]);
  }
}
