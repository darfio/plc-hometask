<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EntityController;
use App\Models\Bug;
use App\Helpers\Crud;

class BugController extends EntityController
{
    protected $crud;
    protected $route_names_prefix = "bugs";
    protected $fields_path = "pages.bugs.fields";

    public function __construct(){
        parent::__construct(Bug::class);
    }

}
