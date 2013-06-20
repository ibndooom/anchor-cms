<?php

/**
 * Returns the article ID
 *
 * @return string
 */
function article_id() {
	return Registry::prop('article', 'id');
}

/**
 * Returns the article title
 *
 * @return string
 */
function article_title() {
	return Registry::prop('article', 'title');
}

/**
 * Returns the article slug
 *
 * @return string
 */
function article_slug() {
	return Registry::prop('article', 'slug');
}

/**
 * Returns the previous article url
 *
 * @return string
 */
function article_previous_url() {
	$page = Registry::get('posts_page');
	$query = Post::where('created', '<', Registry::prop('article', 'created'))->where('status', '=', 'published');

	if($query->count()) {
		$article = $query->sort('created', 'desc')->fetch();
		$page = Registry::get('posts_page');

		return base_url($page->slug . '/' . $article->slug);
	}
}

/**
 * Returns the next article url
 *
 * @return string
 */
function article_next_url() {
	$page = Registry::get('posts_page');
	$query = Post::where('created', '>', Registry::prop('article', 'created'))->where('status', '=', 'published');

	if($query->count()) {
		$article = $query->sort('created', 'asc')->fetch();
		$page = Registry::get('posts_page');

		return base_url($page->slug . '/' . $article->slug);
	}
}

/**
 * Returns the article url
 *
 * @return string
 */
function article_url() {
	$page = Registry::get('posts_page');

	return base_url($page->slug . '/' . article_slug());
}

/**
 * Returns the article description
 *
 * @return string
 */
function article_description() {
	return Registry::prop('article', 'description');
}

/**
 * Returns the article content
 * (raw content that was entered into the database)
 *
 * @return string
 */
function article_html() {
	$raw = Registry::prop('article', 'html');

	// swap out shortcodes {{meta_key}}
	$parsed = parse($raw);

	return $parsed;
}

/**
 * Returns the article markdown
 * (content is parsed with markdown)
 *
 * @return string
 */
function article_markdown() {
	$raw = Registry::prop('article', 'html');

	// swap out shortcodes {{meta_key}}
	$parsed = parse($raw);

	$md = new Markdown;
	return $md->transform($parsed);
}

/**
 * Returns the article css
 *
 * @return string
 */
function article_css() {
	return Registry::prop('article', 'css');
}

/**
 * Returns the article js
 *
 * @return string
 */
function article_js() {
	return Registry::prop('article', 'js');
}

/**
 * Returns the article created date as a unix time stamp
 *
 * @return string
 */
function article_time() {
	if($created = Registry::prop('article', 'created')) {
		return Date::format($created, 'U');
	}
}

/**
 * Returns the article created date formatted
 *
 * @return string
 */
function article_date() {
	if($created = Registry::prop('article', 'created')) {
		return Date::format($created);
	}
}

/**
 * Returns the article status (published, draft, archived)
 *
 * @return string
 */
function article_status() {
	return Registry::prop('article', 'status');
}

/**
 * Returns the article category title
 *
 * @return string
 */
function article_category() {
	if($category = Registry::prop('article', 'category')) {
		$categories = Registry::get('all_categories');

		return $categories[$category]->title;
	}
}

/**
 * Returns the article category slug
 *
 * @return string
 */
function article_category_slug() {
	if($category = Registry::prop('article', 'category')) {
		$categories = Registry::get('all_categories');

		return $categories[$category]->slug;
	}
}

/**
 * Returns the article category url
 *
 * @return string
 */
function article_category_url() {
	if($category = Registry::prop('article', 'category')) {
		$categories = Registry::get('all_categories');

		return base_url('category/' . $categories[$category]->slug);
	}
}

/**
 * Returns the article total comments
 *
 * @return string
 */
function article_total_comments() {
	if($article = Registry::get('article')) {
		return $article->total_comments();
	}
}

/**
 * Returns the article author name (user name)
 *
 * @return string
 */
function article_author() {
	return Registry::prop('article', 'author_name');
}

/**
 * Returns the article author ID (user ID)
 *
 * @return string
 */
function article_author_id() {
	return Registry::prop('article', 'author_id');
}

/**
 * Returns the article author bio (user bio)
 *
 * @return string
 */
function article_author_bio() {
	return Registry::prop('article', 'author_bio');
}

/**
 * Returns the value of a custom field for a post (article)
 *
 * @param string
 * @param mixed
 * @return string
 */
function article_custom_field($key, $default = '') {
	$id = Registry::prop('article', 'id');

	if($extend = Extend::field('post', $key, $id)) {
		return Extend::value($extend, $default);
	}

	return $default;
}

/**
 * Returns true if the article contents custom css or js code
 *
 * @return bool
 */
function customised() {
	if($itm = Registry::get('article')) {
		return $itm->js or $itm->css;
	}

	return false;
}