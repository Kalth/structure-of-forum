<?php

class UserController extends AbstractController
{
	// Page d'inscription
	protected function signInPageAction()
	{
		if ($this->getGet('ajax') == true) {
			$ajax = true;
		} else {
			$ajax = false;
		}
		
		return [
			'headers' => ['Content-Type:text/html;charset=utf-8'],
			'content' => $this->getTwig()->render('signIn.html.twig', [
				'pageName' => 'Inscription',
				'ajax' => $ajax,
				'session' => $this->getSession(),
			]),
		];	
	}

	// Inscription
	protected function signInAction()
	{
		if ($this->getPost('password') !== $this->getPost('password2')) {
			$return = 'Mot de passe different de la confirmation';
			return [
				'headers' => ['Location:' + $this->getPost('location')],
				'content' => $return,
			];
		}

		$verifSignIn = $this->getMySQL()->myQuery(
			'SELECT COUNT(id) as doublon
			FROM users
			WHERE identifiant = :identifiant OR mail = :mail OR pseudo = :pseudo',
			'VerifSignInEntity',
			['identifiant' => $this->getPost('identifiant'),
			'mail' => $this->getPost('mail'),
			'pseudo' => $this->getPost('pseudo'),]);

		if ($verifSignIn[0]->getDoublon() > 0) {
			$return = 'identifiant, pseudo, ou mail deja pris';
			return [
				'headers' => ['Location:' + $this->getPost('location')],
				'content' => $return,
			];
		}

		if ($this->getPost('mail') === '') {
			$mail = null;
		} else {
			$mail = $this->getPost('mail');
		}

		$stmt = $this->getMySQL()->prepare(
			'INSERT INTO users(identifiant, password, mail, pseudo, last_co)
			VALUES(:identifiant, :password, :mail, :pseudo, now())'
		);

		$stmt->execute([
			'identifiant' => $this->getPost('identifiant'),
			'password' => hash('ripemd320', $this->getPost('password')),
			'mail' => $mail,
			'pseudo' => $this->getPost('pseudo'),
		]);

		$return = 'Inscription effectué ,vous pouvez vous connecter';

		return [
			'headers' => ['Location:' + $this->getPost('location')],
			'content' => $return,
		];
	}

	// Connection
	protected function logInAction()
	{
		$logIn = $this->getMySQL()->myQuery(
			'SELECT id, pseudo, `right`
			FROM users
			WHERE identifiant = :identifiant AND password = :password',
			'LogInEntity',
			[
				'identifiant' => $this->getPost('identifiant'),
				'password' => hash('ripemd320', $this->getPost('password')),
			]
		);

		if (empty($logIn)) {
			http_response_code(500);
			$return = 'identifiant ou mot de passe incorecte';
			return [
				'headers' => ['Location:' + $this->getPost('location')],
				'content' => $return,
			];
		}

		$this->setSession($logIn[0]->getId(), 'id');
		$this->setSession($logIn[0]->getPseudo(), 'pseudo');
		$this->setSession($logIn[0]->getRight(), 'right');

		$return = 'Bonjour ' . $this->getSession('pseudo');
		return [
			'headers' => ['Location:' + $this->getPost('location')],
			'content' => $return,
		];
	}

	protected function logOutAction()
	{
		$this->unsetSession();

		$this->setSession($logIn[0]->getId(), 'id');
		$this->setSession($logIn[0]->getPseudo(), 'pseudo');
		$this->setSession($logIn[0]->getRight(), 'right');

		$return = 'Bonjour ' . $this->getSession('pseudo');
		return [
			'headers' => ['Location:' . $this->getPost('location')],
			'content' => $return,
		];
	}
	
}
