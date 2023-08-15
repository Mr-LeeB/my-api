<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Containers\Release\Models\Release;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Release::class, function (Faker $faker) {
  return [
    'name'               => $faker->unique()->name,
    'title_description'  => $faker->text,
    'detail_description' => $faker->text,
    'date_created'       => $faker->date('Y-m-d'),
    'is_publish'         => $faker->boolean,
    // 'images'             => [UploadedFile::fake()->image('release.jpg', 100, 100)],
  ];
});