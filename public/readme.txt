=== Additional Authors ===
Contributors: palasthotel, edwardbock, greatestview
Donate link: http://palasthotel.de/
Tags: author, meta fields
Requires at least: 4.0
Tested up to: 6.4.2
Stable tag: 1.3.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl

Let's you add more than one author to your posts.

== Description ==

Let's you add more than one author to your posts.

== Installation ==

1. Upload `additional-authors-wordpress.zip` to the `/wp-content/plugins/` directory
1. Extract the Plugin to a `Additional Authors` Folder
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

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

Since 1.2.2: There was an update on query manipulation. Please make shure your results are still as expected/befor.


== Arbitrary section ==



