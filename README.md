# Additional Authors (WordPress-Plugin)

Assign more than one author to a post, and make WordPress treat all of them as
authors — in author archives, in `count_user_posts()`, and in the REST API.

- **WordPress.org:** https://wordpress.org/plugins/additional-authors/
- **User documentation:** [public/readme.txt](public/readme.txt) (the text shown on WordPress.org)
- **Changelog:** [CHANGELOG.md](CHANGELOG.md) — release-please owns that file, so do
  not add notes to it by hand. Entries up to 1.3.9 are in the `== Changelog ==`
  section of [public/readme.txt](public/readme.txt).

## What it does

WordPress stores exactly one `post_author` per post. This plugin keeps the additional
ones in its own table (`{prefix}additional_authors`, a `post_id` / `author_id` pair)
and then teaches the rest of WordPress about them:

| Where | What changes |
|---|---|
| Block editor | a panel to add and remove authors |
| Classic editor | the (deprecated) *Additional Authors* meta box |
| Author archives | `posts_where` is extended, so `/author/name/` also lists posts where the user is an additional author |
| Post counts | `get_usernumposts` adds the additional authorships |
| Users list | `has_published_posts` in `WP_User_Query` counts additional authorship too |
| Posts list | an *All authors* column |
| REST API | an `additional_authors` field (array of user IDs) on public post types |
| Blocks | `ph-aa-author-archive-title` and `ph-aa-author-archive-biography` for author archive templates |

## Rendering in a theme

```php
do_action( 'additional_authors_the_authors' );                  // "Anna, Mark, David"
do_action( 'additional_authors_the_authors_posts_links' );      // linked, one <address> each
do_action( 'additional_authors_the_author_posts_link', $id );   // a single one

additional_authors_get_the_authors_ids( $post_id );             // int[], main author first
```

Pass a post ID as the first argument when you are outside the loop.

### Overriding the markup

Copy a file from [public/templates/](public/templates) to
`your-theme/plugin-parts/` and edit it there. Sub-directories of `plugin-parts/` are
searched as well, and other plugins can add search paths with the
`additional_authors_template_paths` filter.

## Filters

| Filter | Purpose |
|---|---|
| `additional_authors_meta_box_get_users` | the `get_users()` arguments behind the author picker |
| `additional_authors_wp_query_capability_for_authors` | which capability a user needs to be offered as an author (default `edit_posts`) |
| `additional_authors_wp_query_ignore_additional_default` | default for whether a query ignores additional authors |
| `additional_authors_template_paths` | extra template search paths |

`WP_User_Query` accepts `ignore_published_as_additional_author => true` to get core's
unmodified `has_published_posts` behaviour back.

## Repository layout

`public/` is exactly what ships to WordPress.org. Everything outside it is
repository-only.

| Path | Description |
|---|---|
| `public/additional-authors.php` | plugin header and bootstrap |
| `public/classes/` | the plugin's PHP, autoloaded via `AdditionalAuthors\` → `classes` |
| `public/templates/` | the overridable output templates |
| `public/build/` | compiled editor assets — **generated**, not in the repository |
| `public/languages/` | translations |
| `public/vendor/` | generated composer autoloader, no third-party code |
| `src/`, `src-blocks/` | JavaScript and TypeScript sources |
| `assets/` | media for the WordPress.org plugin page — not part of the download |
| `additional-authors.php` | DEV wrapper, loads `public/additional-authors.php` when the repository is checked out into `wp-content/plugins/` |
| `resource/` | wp-env helpers |
| `bin/` | release helper scripts |
| `.github/workflows/` | CI/CD — see [.github/WORKFLOWS.md](.github/WORKFLOWS.md) |

## Development

```sh
npm ci
npm run lint          # tsc --noEmit
npm run build         # → public/build/
npx wp-env start      # http://localhost:8888, admin / password
bash bin/pack.sh      # → additional-authors.zip
```

`public/build/` is generated and gitignored — the release pipeline builds it. Run
`npm run build` before `wp-env start` or `bin/pack.sh`, otherwise the plugin has no
editor assets.

## Releasing

Releases are automated with [release-please](https://github.com/googleapis/release-please)
and deployed to the WordPress.org SVN repository. There is nothing to bump by hand —
commit with [conventional commits](https://www.conventionalcommits.org/) and merge
the release PR:

```
fix: …   → patch    feat: …  → minor    feat!: … → major
```

The full pipeline is documented in [.github/WORKFLOWS.md](.github/WORKFLOWS.md), the
commit conventions in [CONTRIBUTING.md](CONTRIBUTING.md).

## License

GNU General Public License v3.0 or later — see [LICENSE](LICENSE).
