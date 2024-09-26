<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Arr;

trait Authorizable
{
    protected $abilities = [
        'index' => 'show',
        'create' => 'add',
        'store' => 'add',
        'edit' => 'edit',
        'update' => 'edit',
        'show' => 'show',
        'destroy' => 'delete'
    ];

    /**
     * Override of callAction to perform the authorization before
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if (! auth('admin')->user()?->isSuperAdmin()) {
            if ($ability = $this->getAbility($method)) {
                $this->authorize($ability);
            }
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', request()->route()->getName());
        $action = Arr::get($this->getAbilities(), $method);
        return $action ? $this->permissionName . '.' . $action : null;
    }

    private function getAbilities()
    {
        return array_merge($this->abilities, ($this->additionalAbilities ?? []));
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}
