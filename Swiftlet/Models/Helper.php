<?php

namespace Swiftlet\Models;

class Helper extends \Swiftlet\Model
{
	/**
	 * Ensure the user is logged in
	 *
	 * @param bool $ajax
	 * @return int
	 */
	public function ensureValidUser($ajax = false)
	{
		if ( !( $userId = $this->app->getSingleton('session')->get('id') ) ) {
			header('HTTP/1.0 403 Forbidden');

			if ( $ajax ) {
				exit(json_encode(array('message' => 'You need to be logged in')));
			}

			header('Location: ' . $this->app->getRootPath() . 'signin');

			exit;
		}

		return $userId;
	}

	/**
	 * Get the current user's folders
	 *
	 * @return array
	 */
	public function getUserFolders()
	{
		$userId = $this->app->getSingleton('session')->get('id');

		$dbh = $this->app->getSingleton('pdo')->getHandle();

		$sth = $dbh->prepare('
			SELECT
				folders.id,
				folders.title
			FROM       folders
			WHERE
		 		user_id = :user_id
			LIMIT 1000
			;');

		$sth->bindParam('user_id', $userId, \PDO::PARAM_INT);

		$sth->execute();

		$folders = $sth->fetchAll(\PDO::FETCH_OBJ);

		return $folders;
	}

	/**
	 * Apply local time-zone offset to UTC date-time
	 *
	 * @param string $dateTime
	 * @return int
	 */
	public function localize(&$dateTime)
	{
		$dateTime = $dateTime ? strtotime($dateTime) + $this->app->getSingleton('session')->get('timezone') : 0;
	}

	/**
	 * Send an email
	 *
	 * @param bool $ajax
	 * @return int
	 */
	public function sendMail($to, $subject, $message)
	{
		$headers = implode("\r\n", array(
			'Content-type: text/plain; charset=UTF-8',
			'From: '     . $this->app->getConfig('emailFrom'),
			'Reply-To: ' . $this->app->getConfig('emailFrom')
			));

		return mail($to, $subject, $message, $headers);
	}

	/**
	 * Generate direct link to feed
	 *
	 * @param object $controller
	 */
	public function getFeedLink($id, $title)
	{
		return $this->app->getRootPath() . 'feed/view/' . $id . '/' . trim(preg_replace('/--+/', '-', preg_replace('/[^a-z0-9]/', '-', strtolower( html_entity_decode($title, ENT_QUOTES, 'UTF-8')))), '-');
	}
}
