<?php
function get_author_count(){
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$author_count = 0;
	$query = "select count(*) as author_count from authors";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$author_count = $row['author_count'];
	}
	return($author_count);
}

function get_user_count(){
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$user_count = 0;
	$query = "select count(*) as user_count from users";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$user_count = $row['user_count'];
	}
	return($user_count);
}

function get_book_count(){
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$book_count = 0;
	$query = "select count(*) as book_count from books";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$book_count = $row['book_count'];
	}
	return($book_count);
}

function get_issue_book_count(){
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$issue_book_count = 0;
	$query = "select count(*) as issue_book_count from issued_books";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$issue_book_count = $row['issue_book_count'];
	}
	return($issue_book_count);
}

function get_category_count(){
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$cat_count = 0;
	$query = "select count(*) as cat_count from category";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$cat_count = $row['cat_count'];
	}
	return($cat_count);
}

/**
 * New helper: get_pending_request_count()
 * returns integer count of requests with status 'Pending'
 */
function get_pending_request_count() {
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$cnt = 0;
	$query = "SELECT COUNT(*) AS cnt FROM book_requests WHERE status = 'Pending'";
	$res = mysqli_query($connection, $query);
	if ($res) {
		$row = mysqli_fetch_assoc($res);
		$cnt = (int)$row['cnt'];
	}
	return $cnt;
}
?>
