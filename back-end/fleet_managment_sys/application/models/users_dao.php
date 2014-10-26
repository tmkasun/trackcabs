<?php

class Users_dao extends CI_Model
{
    protected $role;
    protected $roleId;

    function __construct()
    {
        parent::__construct();
        $this->mongodb = new MongoClient();
    }

    /**
     * @param $geoNameId Geoname ID of a location , This is the default primary key for the geo_names collection
     * Return the
     * sample:
     *
     * {
     * "_id" : 1222722,
     * "uName" : "tmkasun",
     * "pass" : "plain_text",
     * "roleId" : "mongo_id",
     * "role" : 'role_name'
     * }
     * @returns null if record doesn't exist , if exist sends the first record
     */

    function authenticate($uName, $pass)
    {
        $searchQuery = array('uName' => $uName, 'pass' => $pass);
        return $this->mongodb->track->users->findOne($searchQuery);
    }

    /**
     * @param $uName
     * @param string $pass
     * @return array
     */
    function create($uName, $pass = "123456")
    {

        $user = $this->mongodb->track->users->findAndModify(
            array('uName' => $uName),
            array(
                '$setOnInsert' => array('pass' => $pass, 'createdOn' => new MongoDate())
            ), null,
            array('new' => true,
                'upsert' => true)
        );
        return $user;

    }

    /**
     * @param null $name
     * @return mixed
     */
    public function __get($name = null)
    {
        return $this->self[$name];
    }

    /**
     * @param $role
     */
    public function assignRole($role)
    {
        $this->role = $role;
    }

    function find($username){
        return $this->mongodb->track->users->findOne(array('uName' => $username));
    }

}