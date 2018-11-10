<?php

namespace LPF\Framework\Auth;

use LPF\Framework\App;
use LPF\Framework\Database\QueryBuilder;

/**
 * Auth for users
 */
class Auth
{   
    /** @var App */
    protected $app = null;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * Construct auth
     *
     * @param App $app
     * @param string $table
     * @param string $pk
     */
    public function __construct(App $app, $table = 'users', $pk = 'id')
    {   
        $this->app = $app;
        $this->table = $table;
        $this->primaryKey = $pk;
    }

    /**
     * Check if user is signed in
     *
     * @return bool
     */
    public function check()
    {
        if(isset($_SESSION['user_id'])) return true; 

        return false;
    }

    /**
     * Get current user
     *
     * @return void
     */
    public function user()
    {
        $qb = new QueryBuilder("SELECT * FROM " . $this->table);

        // check if user is signed in
        if($this->check()) 
        {
            // get user by primary_key
            $qb->where($this->primaryKey, '=', $_SESSION['user_id']);

            $u = $qb->run($this->app->getConnection());

            return $u[0] ?? null;
        }

        return null;
    }

    /**
     * Attempt sign in by email and password
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function attempt($email, $password) 
    {   
        // user is signed in do not let attempt again
        if($this->check()) return false;

        $qb = new QueryBuilder("SELECT * FROM " . $this->table);
        $qb->where('email', '=', $email);

        // get users matching the email
        $u = $qb->run($this->app->getConnection())[0];

        // if there is no any user then return false
        if($u == null) return false; 

        // check password if wrong return false
        if(password_verify($password, $u['password']))
        {
            $_SESSION['user_id'] = $u[$this->primaryKey];
            return true;
        }

        return false;
    }   
    
    /**
     * Sign out user
     *
     * @return void
     */
    public function signOut()
    {
        unset($_SESSION['user_id']);
    }
}
