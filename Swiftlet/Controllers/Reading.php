<?php

namespace Swiftlet\Controllers;

class Reading extends \Swiftlet\Controllers\Read
{
	const
		ITEM_SORT_RELEVANCE_TIME = 0,
		ITEM_SORT_TIME           = 1
		;

	protected
		$title = 'My Reading'
		;

	/**
	 * Default action
	 */
	public function index()
	{
		$userId = $this->app->getSingleton('helper')->ensureValidUser();

		$this->getItems();
	}

	/**
	 * Get personal items
	 */
	public function items()
	{
		$this->app->getSingleton('helper')->ensureValidUser();

		if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$this->view->name = 'read';
		}

		$this->getItems();
	}

	/**
	 * Get personal items
	 */
	protected function getItems()
	{
		$userId = $this->app->getSingleton('session')->get('id');

		$excludes = !empty($_GET['excludes']) ? explode(' ', $_GET['excludes']) : array();

		$dbh = $this->app->getSingleton('pdo')->getHandle();

		// Fetch items
		$sth = $dbh->prepare('
      SELECT
				feeds.id    AS feed_id,
				feeds.title AS feed_title,
				feeds.link  AS feed_link,
				items.id,
				items.url,
				items.title,
				items.contents,
				items.posted_at,
				users_feeds.folder_id,
				COALESCE(users_items.saved, 0) AS starred,
				1 AS feed_subscribed
      FROM       users_feeds
			STRAIGHT_JOIN       items ON       items.feed_id = users_feeds.feed_id
      STRAIGHT_JOIN       feeds ON       feeds.id      =       items.feed_id
			LEFT     JOIN users_items ON users_items.item_id =       items.id      AND users_items.user_id = ?
			WHERE
				users_feeds.user_id = ? AND
				( users_items.read    = 0 OR users_items.read IS NULL )
				' . ( $excludes ? 'AND items.id NOT IN ( ' . implode(', ', array_fill(0, count($excludes), '?')) . ' )' : '' ) . '
			ORDER BY DATE(IF(items.posted_at, items.posted_at, items.created_at)) DESC
			LIMIT ?
			');

		$i = 1;

		$sth->bindParam($i ++, $userId, \PDO::PARAM_INT);
		$sth->bindParam($i ++, $userId, \PDO::PARAM_INT);

		foreach( $excludes as $key => $itemId ) {
			$sth->bindParam($i ++, $excludes[$key], \PDO::PARAM_INT);
		}

		$limit = self::ITEMS_PER_PAGE;

		$sth->bindParam($i ++, $limit, \PDO::PARAM_INT);

		$sth->execute();

		$items = $sth->fetchAll(\PDO::FETCH_OBJ);

		$this->prepare($items);

		$grouped = $this->app->getSingleton('helper')->getFolders();

		foreach ( $items as $i => $item ) {
			$item->folder_title = '';

			if ( $item->folder_id ) {
				foreach ( $grouped as $group ) {
					if ( $group->folder && $item->folder_id == $group->folder->id ) {
						$item->folder_title = $group->folder->title;
					}
				}
			}
		}

		$this->view->set('items', $items);
	}
}
