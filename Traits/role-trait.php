<?php
// Trait with Laratrust

namespace App\Traits;
use Auth;

trait RoleTrait
{
    public function isLogin()
    {
        if ( Auth::check() ) {

            return true;

        }

        return false;
    }

    public function currentID()
    {
        if ( $this->isLogin() ) {

            return Auth::user()->id;

        }

        return '';
    }

    public function getCurrentID()
    {

        return $this->currentID();

    }

    public function isAdmin()
    {

        if ( $this->isLogin() && Auth::user()->hasRole('admin') ) {

            return true;

        }

        return false;

    }

    public function userCan($permission=[], $check_all=false)
    {
        if ( $this->isLogin() && Auth::user()->can($permission, $check_all) ) {

            return true;

        }

        return false;

    }

    public function userOqatCheck($permission=[], $check_all=false)
    {
        if ( $this->isLogin() && Auth::user()->can($permission, $check_all) ) {

            return true;

        }

        abort(403);

    }

    public function currentUser()
    {
        if ( $this->isLogin() ) {

            return Auth::user();

        }

        return false;

    }

}
