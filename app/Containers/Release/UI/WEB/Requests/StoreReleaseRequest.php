<?php

namespace App\Containers\Release\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class StoreReleaseRequest.
 */
class StoreReleaseRequest extends Request
{

  /**
   * The assigned Transporter for this Request
   *
   * @var string
   */
  protected $transporter = \App\Containers\Release\Data\Transporters\CreateReleaseTransporter::class;

  /**
   * Define which Roles and/or Permissions has access to this request.
   *
   * @var  array
   */
  protected $access = [
    'permissions' => '',
    'roles' => 'admin',
  ];

  /**
   * Id's that needs decoding before applying the validation rules.
   *
   * @var  array
   */
  protected $decode = [
    // 'id',
  ];

  /**
   * Defining the URL parameters (e.g, `/user/{id}`) allows applying
   * validation rules on them and allows accessing them like request data.
   *
   * @var  array
   */
  protected $urlParameters = [
    // 'id',
  ];

  /**
   * @return  array
   */
  public function rules()
  {
    return [
      'name' => 'required|unique:releases,name|max:40|min:3',
      'date_created' => 'required|date',
      'title_description' => 'required|max:255|min:3',
      'detail_description' => 'required|string|max:4096|min:3',
      'images' => 'array',
      'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:6144',
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