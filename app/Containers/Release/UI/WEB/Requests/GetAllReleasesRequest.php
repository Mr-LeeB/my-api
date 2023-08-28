<?php

namespace App\Containers\Release\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class GetAllReleasesRequest.
 */
class GetAllReleasesRequest extends Request
{

    /**
     * The assigned Transporter for this Request
     *
     * @var string
     */
    protected $transporter = \App\Containers\Release\Data\Transporters\GetAllReleasesTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => 'list-users',
        'roles'       => ['admin', 'user'],
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
            // 'id' => 'required',
            // '{user-input}' => 'required|max:255',
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