<?php

namespace App\Containers\Authorization\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class CreateRoleRequest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateRoleRequest extends Request
{

  /**
   * Define which Roles and/or Permissions has access to this request.
   *
   * @var  array
   */
  protected $access = [
    'roles' => '',
    'permissions' => 'manage-roles',
  ];

  /**
   * Id's that needs decoding before applying the validation rules.
   *
   * @var  array
   */
  protected $decode = [

  ];

  /**
   * Defining the URL parameters (`/stores/999/items`) allows applying
   * validation rules on them and allows accessing them like request data.
   *
   * @var  array
   */
  protected $urlParameters = [
    'id'
  ];

  /**
   * @return  array
   */
  public function rules()
  {
    return [
      'id' => 'required|exists:roles,id',
      'name' => 'unique:roles,name|min:2|max:20|no_spaces',
      'description' => 'max:255',
      'display_name' => 'max:100',
      'level' => 'integer|min:0|max:999'
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