<?php

namespace App\Containers\Release\UI\WEB\Controllers;

use App\Containers\Release\UI\WEB\Requests\CreateReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\DeleteReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\GetAllReleasesRequest;
use App\Containers\Release\UI\WEB\Requests\FindReleaseByIdRequest;
use App\Containers\Release\UI\WEB\Requests\UpdateReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\StoreReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\EditReleaseRequest;
use App\Ship\Parents\Controllers\WebController;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

/**
 * Class Controller
 *
 * @package App\Containers\Release\UI\WEB\Controllers
 */
class Controller extends WebController
{
  /**
   * Show all entities
   *
   * @param GetAllReleasesRequest $request
   */
  public function getAllRelease(GetAllReleasesRequest $request)
  {
    $releases = Apiato::call('Release@GetAllReleasesAction', [new DataTransporter($request)]);

    if (auth()->user()->hasAdminRole()) {
      return view('release::admin.admin-home', compact('releases'));
    }
    return view('release::home', compact('releases'));
  }

  /**
   * Show one entity
   *
   * @param FindReleaseByIdRequest $request
   */
  public function show(FindReleaseByIdRequest $request)
  {
    $release = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);

    // ..
  }

  /**
   * Create entity (show UI)
   *
   * @param CreateReleaseRequest $request
   */
  public function create(CreateReleaseRequest $request)
  {
    // ..
  }

  /**
   * Add a new entity
   *
   * @param StoreReleaseRequest $request
   */
  public function store(StoreReleaseRequest $request)
  {
    $release = Apiato::call('Release@CreateReleaseAction', [new DataTransporter($request)]);
    // ..
  }

  /**
   * Edit entity (show UI)
   *
   * @param EditReleaseRequest $request
   */
  public function edit(EditReleaseRequest $request)
  {
    $release = Apiato::call('Release@GetReleaseByIdAction', [new DataTransporter($request)]);
    // ..
  }

  /**
   * Update a given entity
   *
   * @param UpdateReleaseRequest $request
   */
  public function update(UpdateReleaseRequest $request)
  {
    $release = Apiato::call('Release@UpdateReleaseAction', [new DataTransporter($request)]);
    // ..
  }

  /**
   * Delete a given entity
   *
   * @param DeleteReleaseRequest $request
   */
  public function delete(DeleteReleaseRequest $request)
  {
    $result = Apiato::call('Release@DeleteReleaseAction', [new DataTransporter($request)]);
    // ..
  }
}