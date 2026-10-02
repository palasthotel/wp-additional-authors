=== Additional Authors ===
Contributors: palasthotel, edwardbock, greatestview, benjaminbirkenhake, janaeggebrecht
Donate link: https://palasthotel.de/
Tags: author, meta fields
Requires at least: 5.0
Tested up to: 7.1.2
Requires PHP: 7.4
Stable tag: 1.4.0
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Lets you add more than one author to your posts.

== Description ==

Lets you add more than one author to your posts.

Optionally extends the byline your theme already renders - see the FAQ.

== Installation ==

1. Install the plugin from Plugins > Add New, or upload `additional-authors.zip` under Plugins > Add New > Upload Plugin
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= The additional authors do not show up in my theme =

By default the plugin only stores them; the output is up to the theme, through
`do_action( 'additional_authors_the_authors' )`. Since 1.4.0 it can also extend the
byline a standard theme already renders:

`add_filter( 'additional_authors_auto_byline', '__return_true' );`

That covers the `core/post-author` and `core/post-author-name` blocks used by block
themes such as Twenty Twenty-Four and Twenty Twenty-Five, and the `the_author()` and
`the_author_posts_link()` template tags used by classic themes. It is off by default,
because a plugin update should not change what your site outputs.

Two things worth knowing:

* Some classic themes — Twenty Twenty-One among them — wrap `get_the_author()` in a
  link they build themselves. The additional names then sit inside that link, which
  points at the main author. If per-author links matter to you, output them yourself
  with `do_action( 'additional_authors_the_authors_posts_links' )` instead.
* The `core/post-author` block is left untouched when its "Show bio" option is on: a
  biography belongs to one person, and listing several names above it would read as if
  it described all of them.

= Can I change how the names are joined? =

`additional_authors_byline_separator` sets the separator (default `, `), and
`additional_authors_byline_suffix` lets you build the whole appended string, for
example to get "Anna, Mark und David":

`add_filter( 'additional_authors_byline_suffix', function ( $suffix, $ids ) {
	$names = array_map( fn( $id ) => get_the_author_meta( 'display_name', $id ), $ids );
	$last  = array_pop( $names );
	return ( $names ? ', ' . implode( ', ', $names ) : '' ) . ' und ' . $last;
}, 10, 2 );`



== Screenshots ==

1. The Additional Authors panel in the block editor sidebar: search for a user, and the ones you picked are listed below with a button to remove them again.

== Changelog ==

= 1.4.0 =
**Features**
* optionally extend the byline a standard theme renders (cffb64c)

**Bug Fixes**
* point the All authors column at the right users (8567bd1)
* repair the post-count endpoint and the users list column (aa3416a)
* stop contributors from creating accounts and reassigning posts (2e19c60)

= 1.3.9 =
* Fix: Include build in pipeline

= 1.3.8 =
* Add gutenberg blocks to support archive pages

= 1.3.7 =
* Rework File Structure

= 1.3.6 =
* Added additional Filter

= 1.3.5 =
* Fix: PHP 8.2 warnings
* Fix: double slash in asset urls
* Packages update

= 1.3.3 =
* Packages update

= 1.3.2 =
 * WordPress Core compatibility fix
 * Packages update

= 1.3.1 =
 * Update: JS packages update

= 1.3.0 =
 * Feature: Show posts count on users table with additional author posts inclusive

= 1.2.13 =
 * Bugfix: Post type may be array on change post count hook

= 1.2.12 =
 * Optimization: Post table all authors list
 * Bugfix: Delete user crash

= 1.2.11 =
 * Optimization: Add admins and editors to additional author dropdown

= 1.2.10 =
 * Bugfix: Additional authors script broke reusable block editor

= 1.2.9 =
 * Optimization: autocomplete search case insensitive
 * Optimization: click outside hides dropdown

= 1.2.8 =
 * Bugfix: Missing migration script

= 1.2.7 =
 * WP5.7 checked
 * Bugfix: Database update error

= 1.2.6 =
 * Performance: WP_Query performance optimization
 * Update: Dependency updates
 * Bugfix: Cannot delete last additional author from post

= 1.2.5 =
 * Bugfix: Gutenberg no POST index fix

= 1.2.4 =
 * Optimization: only show additional authors im post type supports author feature
 * Feature: Customizing filter for get_users args in meta box

= 1.2.3 =
 * Optimization: Additional authors are included in has_published_posts WP_User_Query
 * Feature: New WP_User_Query argument "ignore_published_as_additional_author" for ignoring additional authors with "has_published_posts"

= 1.2.2 =
 * Fix: Query manipulation fix which lead to duplicate posts

= 1.2.1 =
 * Feature: Link to user profile page

= 1.2.0 =
 * Ready for 5.0 and Gutenberg
 * Optimization: With Gutenberg editor only the additional authors will be visible in post meta box. The post author was removed and needs to be handle with default post edit controls.
 * Info: post_meta _additional_authors is deprecated and will be will not be saved anymore
 * Bugfix: Delete user

= 1.1.5 =
 * Bugfix: Add empty additional author fix
 * Bugfix: Listen to wordpress author field change

= 1.1.4 =
 * BugFix: authors could not be added because of bad timing with onBlur
 * BugFix: keep order of additional authors
 * Feature: All WP_Query will use additional authors not only on authors page
 * Feature: new filter to set the default for ignoring or using additional authors with WP_Query
 * Optimization: Query manipulation optimization for author page

= 1.1.3 =
 * BugFix: IE11

= 1.1.2 =
 * Extendable meta box

= 1.1.1 =
* Added Gutenberg support
* CSS styles

= 1.1 =
* Author keys move from postmeta to custom table
* SQL Performance optimization

= 1.0 =
* First release

== Upgrade Notice ==

Since 1.2.3: Author lists will change if you use "has_published_posts" in WP_User_Query as additional authors are included.

Since 1.2.2: There was an update on query manipulation. Please make sure your results are still as expected.
