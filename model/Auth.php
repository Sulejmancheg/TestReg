<?php

namespace model;

class Auth {

    private Model $model;

	private string $userInfoListPath = '1.txt';
    private null|string $login = null;
    private null|string $password = null;
	private string $loginReg = '/^[a-z]([-.\w])*/i';
	private string $pwdReg = '/[<>\'"`;:\/}{\s]/';

	public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getUser(): string {
		if (self::isAuthentificated()){
			$userInfoList = $this->getUserInfoList();
			foreach ($userInfoList as $userInfo){
				if ($userInfo['nickname'] == $this->model->getNickname()){
					return $this->decodeUser($userInfo['nickname'],$userInfo['id']);
				}
			}
		}
		return 'Guest';
	}

	public function isAuthentificated(): bool {
		return !empty($this->model->getNickname());
	}

	public function tryToLogin(): bool {
	    echo 'TryToLogIn'.PHP_EOL;
		$userInfoList = $this->getUserInfoList();
		foreach ($userInfoList as $userInfo){
			if ($userInfo['login'] == hash('sha3-512', $this->login) && $userInfo['password'] == hash('sha3-512', $this->password)){
				$this->model->setNickname($userInfo['nickname']);
				return true;
			}
		}
		return false;
	}

	private function encodeUser($user, $id): string {
		$arr = str_split(base64_encode($user), (int)(strlen(rtrim(base64_encode($user),'='))/2));
		$first = array_shift($arr);
		array_unshift($arr, $first, $id);
		return base64_encode(implode($arr));
	}

	private function decodeUser($user, $id): bool|string {
		$arr = str_split(base64_decode($user), (int)((strlen(rtrim(base64_decode($user), '='))-strlen($id))/2));
		$first = array_shift($arr);
		$second = array_shift($arr);
		$arr2 = str_split($second, strlen($id));
		array_shift($arr2);
		array_unshift($arr, $first, implode($arr2));
		return base64_decode(implode($arr));
	}

	private function getUserInfoList(): array {
		$strFromFile = file_get_contents($this->userInfoListPath);
		$arrFromFile = explode('*&', $strFromFile);
		foreach ($arrFromFile as $key => $value){
			$tmp = explode('*', $value);
			foreach ($tmp as $value2){
				$tmp2 = explode('=>',$value2);
				$tmp3[$tmp2[0]] = $tmp2[1];
			}
			$arrFromFile[$key] = $tmp3;
		}
		return $arrFromFile;
	}

	public function setUserInfoList( $arr ): bool {
		$strToFile = '';
		foreach ($arr as $value){
			foreach ($value as $key2 => $value2){
				$strToFile .= $key2.'=>'.$value2.'*';
			}
		}
		return (bool)file_put_contents($this->userInfoListPath, rtrim($strToFile, '*&'));
	}

	public function logout()
	{
		session_destroy();
	}

	public static function setLogMessage($message)
	{
		$_SESSION['msg'] = $message;
	}

	public static function getLogMessage() {
		if (isset($_SESSION['msg'])){
				echo '<div class="form-label-group">'
				     .$_SESSION['msg'].
				     '</div>';
			unset($_SESSION['msg']);
		}
	}

    public function validLogData($login, $password): bool
    {
        if ((!preg_match($this->loginReg, $login)) || (preg_match($this->pwdReg, $password))){
            return false;
        } else {
            $this->login = strtolower($login);
            $this->password = $password;
            return true;
        }
	}
}