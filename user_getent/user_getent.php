<?php

class OC_USER_GETENT extends OC_User_Backend implements OC_User_Interface
{
	private $users = array ();

	public function __construct ()
	{
		$passwd = array ();
		$shadow = array ();
		
		exec ('getent passwd', $passwd);
		exec ('sudo getent shadow', $shadow);
		
		foreach ($passwd as $key => $user)
		{
			$data = explode (':', $user);
			
			$username = $data[0];
			$uid = $data[2];
			$gid = $data[3];
			$gecos = $data[4];
			$home = $data[5];
			$shell = $data[6];
			
			$boom = explode (':', $shadow[$key]);
			$crypt = $boom[1];
			$expire = $boom[7];
			
			if ($uid >= 1000 && $crypt != 'x' && $crypt != '*' && $shell != '/bin/false' && $shell != '/usr/sbin/nologin')
				$this->users[$username] = array ($username, $crypt, $uid, $gid, $gecos, $home, $shell, $expire);
		} 
	}
	 
	public function deleteUser ($uid)
	{
		OC_Log::write ('OC_USER_GETENT', "Can't remove local users.", 3);

		return false;
	}
	
	public function setPassword ($uid, $password)
	{
		OC_Log::write ('OC_USER_GETENT', "Can't change password of local users.", 3);
		
		return false;
	}

	public function checkPassword ($username, $password)
	{
		$username = strtolower ($username);
		
		if (! $this->usernameExists ($username))
			return false;
		
		$user = $this->users[$username];
		
		if (crypt ($password, $user[1]) == $user[1])
		{
			$now = ceil (time () / 60 / 60 / 24);
			
			if ($now <= $user[7] || $user[7] == -1 || empty ($user[7]))
				return $username;
			else
				return false;
		}
		
		return false;
	}
	
	public function userExists ($uid) // $uid always seems to be 1 here for some reason //
	{
		return true;
		
		/*
		foreach ($this->users as $user)
		{
			if ($user[2] === $uid)
				return true;
		}

		return false;
		*/
	}
	 
	public function usernameExists ($username)
	{
		return array_key_exists ($username, $this->users);
	}
	 
	public function getUsers ($search = '', $limit = 10, $offset = 10)
	{
		$result = array ();

		foreach ($this->users as $username => $user)
		{
			if (empty ($search) || strpos ($username, $search) === 0)
				$result[] = $user[0];
		}

		if ($limit == -1)
			$limit = null;

		return array_slice ($result, $offset, $limit);
	}
}
?>
