<?php

class ForumController extends AbstractController
{
	// accueil
	protected function accueilAction()
	{
		if ($this->getGet('ajax') == true) {
			$ajax = true;
		} else {
			$ajax = false;
		}
		// Select categories
		// Check si l'user est modo/admin
		if ($this->getSession('right') >= 2) {
			$showPrivate = 1;
		} else {
			$showPrivate = 0;
		}

		$categories = $this->getMySQL()->myQuery(
			'SELECT categories.id, categories.name, categories.descri, categories.private, users.pseudo, msg.date_crea as lastMsg, topic.name as topicName
			FROM categories
			LEFT JOIN msg
			ON msg.id = categories.last_msg_id
			LEFT JOIN topic
			ON topic.id = msg.topic_id
			LEFT JOIN users
			ON users.id = msg.user_id
			WHERE private <= :right
			GROUP BY categories.id',
			'CategorieEntity',
			['right' => $showPrivate]);

		return [
			'headers' => ['Content-Type:text/html;charset=utf-8'],
			'content' => $this->getTwig()->render('accueil.html.twig', [
				'pageName' => 'Accueil',
				'categories' => $categories,
				'ajax' => $ajax,
				'session' => $this->getSession(),
			]),
		];	
	}

	protected function topicsAction()
	{
		if ($this->getGet('ajax') == true) {
			$ajax = true;
		} else {
			$ajax = false;
		}

		$topics = $this->getMySQL()->myQuery(
			'SELECT categories.name as cateName ,topic.id, topic.name, topic.user_id as userId, topic.open, topic.on_top as onTop, categories.id as cateId, COUNT(msg.id) as nbrMsg, users.pseudo as author
			, (SELECT msg.id
				FROM msg 
				WHERE msg.topic_id = topic.id
				ORDER BY msg.date_crea DESC
				LIMIT 0, 1
			) as lastMsgId
			FROM topic
			LEFT JOIN categories
			ON categories.id = topic.categori_id
			LEFT JOIN msg
			ON msg.topic_id = topic.id
			LEFT JOIN users
			ON users.id = msg.user_id
			WHERE categories.id = :categoriesSelected
			GROUP BY topic.id
			ORDER BY msg.date_crea DESC',
			'TopicEntity',
			[':categoriesSelected' => $this->getGet('targetId')]);

		// Recuperation des pseudo et date des dernier message de topic
		foreach ($topics as $topic) {
			$idLastMsg[] = $topic->getLastMsgId();
		}
		$idLastMsg = implode(',', $idLastMsg);
		if (!empty($this->getSession())) {
			$userId = $this->getSession('id');
		} else {
			$userId = 0;
		}
		$lastMsgs = $this->getMySQL()->myQuery(
			'SELECT users.pseudo, msg.date_crea as msgDateCrea,
			 msg.topic_id as topicId, 
			IF(topic_users.msg_id = msg.id,
				 1, 0) AS isUpToDate 
			FROM msg
				LEFT JOIN users
				ON msg.user_id = users.id
			LEFT JOIN topic_users
				ON topic_users.topic_id = msg.topic_id
					AND topic_users.user_id = :userId
					AND topic_users.msg_id = msg.id
			WHERE msg.id IN (' . $idLastMsg . ')',
			'LastMsgEntity',
			[
				'userId' => $userId,
			]);
		// Rajout dans topics
		foreach ($topics as $topic) {
			foreach ($lastMsgs as $lastMsg) {
				if ($topic->getId() === $lastMsg->getTopicID()) {
					$topic->setLastMsgDate($lastMsg->getMsgDateCrea());
					$topic->setLastMsgUser($lastMsg->getPseudo());
					$topic->setIsUpToDate($lastMsg->getIsUpToDate());
					continue;
				}
			}
		}
		// Tri des resultat par date de dernier message
		usort($topics, 'ArrayHelper::cmpByDate');

		return [
			'headers' => ['Content-Type:text/html;charset=utf-8'],
			'content' => $this->getTwig()->render('topic.html.twig', [
				'pageName' => $this->getGet('cateName'),
				'cateName' => $this->getGet('cateName'),
				'cateId' => $this->getGet('targetId'),
				'topics' => $topics,
				'ajax' => $ajax,
				'session' => $this->getSession(),
			]),
		];	
	}

	protected function inTopicAction()
	{
		if ($this->getGet('ajax') == true) {
			$ajax = true;
		} else {
			$ajax = false;
		}

		if ($this->getGet('numPage') === null ) {
			$numPage = 1;
		} else {
			$numPage = $this->getGet('page');
		}

		if (!empty($this->getSession())) {
			$isEverSee = $this->getMySQL()->myQuery(
			'SELECT COUNT(user_id) as isEverSee,(
				SELECT msg.id
				FROM msg
				WHERE msg.topic_id = :topic
				ORDER BY msg.date_crea DESC
				LIMIT 0, 1
			) as lastMsgId
			FROM topic_users
			WHERE topic_id = :topic
			 AND user_id = :user_id',
			'UpdateLastMsgEntity',
			[
				'topic' => $this->getGet('targetId'),
				'user_id' => $this->getSession('id'),
				
			]);

			if ($isEverSee[0]->getIsEverSee() === '0') {
				// Insertion du dernier message lue
				$stmt = $this->getMySQL()->prepare(
					'INSERT INTO topic_users(topic_id, user_id, msg_id)
					VALUES (:topicId, :userId, :lastMsgId)');
					$stmt->execute([
					'topicId' => $this->getGet('targetId'),
					'userId' => $this->getSession('id'),
					'lastMsgId' => $isEverSee[0]->getLastMsgId(),
				]);
			} else {
				// Ou mise a jour du dernier message lue
				$stmt = $this->getMySQL()->prepare(
					'UPDATE topic_users
					SET msg_id = :lastMsgId
					WHERE topic_id = :topicId
			 		 AND user_id = :userId');
					$stmt->execute([
					'topicId' => $this->getGet('targetId'),
					'userId' => $this->getSession('id'),
					'lastMsgId' => $isEverSee[0]->getLastMsgId(),
				]);
			}
		}

		$stmt = $this->getMySQL()->prepare(
			'SELECT msg.id, msg.content, msg.topic_id as topicId,
			 msg.user_id as userId, msg.date_crea as dateCrea, 
			 msg.date_last_change as dateLastChange, topic.name as topicName, 
			 users.pseudo as userPseudo, categories.id as cateId, 
			 categories.name as cateName
			FROM topic
			LEFT JOIN msg
			 ON topic.id = msg.topic_id
			LEFT JOIN users
			 ON users.id = msg.user_id
			LEFT JOIN categories
			 ON categories.id = topic.categori_id
			WHERE topic.id = :topic
			ORDER BY msg.date_crea ASC
			LIMIT :startPage, :endPage');
			$stmt->bindValue('topic', $this->getGet('targetId'), PDO::PARAM_INT);
			$stmt->bindValue('startPage', 15 * ($numPage - 1), PDO::PARAM_INT);
			$stmt->bindValue('endPage', 15 * $numPage - 1, PDO::PARAM_INT);
			$stmt->execute();
		$msgs = $stmt->fetchAll(PDO::FETCH_CLASS, 'InTopicEntity');

		return [
			'headers' => ['Content-Type:text/html;charset=utf-8'],
			'content' => $this->getTwig()->render('inTopic.html.twig', [
				'pageName' => $msgs[0]->getTopicName(),
				'msgs' => $msgs,
				'ajax' => $ajax,
				'session' => $this->getSession(),
			]),
		];	
	}

	protected function answerAction()
	{
		if ($this->getPost('msg') === '') {
			$return ='Veulliez ecrire un message avant de l\'envoyé';
		} elseif (strlen($this->getPost('msg')) > 6000) {
			$return = 'Maximum 6000 caractere on a dit!';
		} else {
			$stmt = $this->getMySQL()->prepare(
				'INSERT INTO msg(content, topic_id, user_id, date_crea)
				VALUES (:content, :topicId, :userId, now())');
			$stmt->execute([
				'content' => $this->getPost('msg'),
				'topicId' => $this->getPost('topic'),
				'userId' => $this->getSession('id'),
			]);

			$msgId = $this->getMySQL()->lastInsertId();

			$stmt = $this->getMySQL()->prepare(
				'SELECT @categoriId := categori_id
					FROM topic
					WHERE id = :topicId;
				UPDATE categories
				SET categories.last_msg_id = :msgId
				WHERE categories.id = @categoriId');
			$stmt->execute([
				'msgId' => $msgId,
				'topicId' => $this->getPost('topic'),
			]);

			$return = 'Message envoyé';
		}

		return [
			'headers' => ['Location:' + $this->getPost('location')],
			'content' => $return,
		];
	}

	protected function newTopicPageAction()
	{
		if ($this->getGet('ajax') == true) {
			$ajax = true;
		} else {
			$ajax = false;
		}

		return [
			'headers' => ['Content-Type:text/html;charset=utf-8'],
			'content' => $this->getTwig()->render('newTopicPage.html.twig', [
				'pageName' => 'Nouveau Topic dans ' . $this->getGet('cateName'),
				'ajax' => $ajax,
				'session' => $this->getSession(),
				'cateId' => $this->getGet('cateId'),
				'cateName' => $this->getGet('cateName'),
			]),
		];	
	}

	protected function newTopicAction()
	{
		$epingle = 0;
		if ($this->getPost('msg') === ''
		|| $this->getPost('titre') === '') {
			http_response_code(500);
			$return = 'Veulliez remplir tous les champs avant d\'envoyé le nouveaux topic';
			return [
				'headers' => ['Location:' + $this->getPost('location')],
				'content' => $return,
			];
		} elseif (strlen($this->getPost('msg')) > 6000) {
			$return = 'Maximum 6000 caractere on a dit!';
			http_response_code(500);
			return [
				'headers' => ['Location:' + $this->getPost('location')],
				'content' => $return,
			];
		} else {
			$stmt = $this->getMySQL()->prepare('
				INSERT INTO topic(name, user_id, categori_id, on_top)
				VALUES (:titre, :userId, :cateId, :onTop)'
			);
			$stmt->execute([
			'titre' => $this->getPost('titre'),
			'userId' => $this->getSession('id'),
			'cateId' => $this->getPost('cateId'),
			'onTop' => $epingle,
			]);

			$topicId = $this->getMySQL()->lastInsertId();

			$stmt = $this->getMySQL()->prepare(
				'INSERT INTO msg(content, topic_id, user_id, date_crea)
				VALUES (:msg, :topicId, :userId, now())'
			);
			
			$stmt->execute([
			'userId' => $this->getSession('id'),
			'msg' => $this->getPost('msg'),
			'topicId' => $topicId,
			]);

			$msgId = $this->getMySQL()->lastInsertId();

			$stmt = $this->getMySQL()->prepare(
				'SELECT @categoriId := categori_id
					FROM topic
					WHERE id = :topicId;
				UPDATE categories
				SET categories.last_msg_id = :msgId
				WHERE categories.id = @categoriId');
			$stmt->execute([
				'msgId' => $msgId,
				'topicId' => $topicId,
			]);

		}

		return [
			'headers' => ['Location:' + $this->getPost('location')],
			'content' => $topicId,
		];
	}
}
