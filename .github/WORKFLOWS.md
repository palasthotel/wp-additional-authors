# CI/CD Workflows

This repository uses four GitHub Actions workflows. The plugin is versioned by
[release-please](https://github.com/googleapis/release-please) based on
[conventional commits](https://www.conventionalcommits.org/):
`fix:` → patch, `feat:` → minor, `feat!:` / `BREAKING CHANGE:` → major.

Tag format: `v*` (e.g. `v1.3.10`).

---

## Overview

```
Push to main
    │
    ├──▶ [release-please.yml]
    │        Creates / updates the release PR, bumping version.txt + CHANGELOG.md
    │
    │    On release PR (opened / synchronize)
    ├──▶ [update-plugin-version.yml]
    │        Syncs public/additional-authors.php Version
    │        + readme.txt Stable tag & changelog entry
    │
    │    On PR to main
    └──▶ [pr.yml]
             php -l on 7.4 / 8.2 / 8.3 / 8.4
             tsc --noEmit + build + "were the enqueued assets produced?"
             pack + "is the payload clean?"


Merge release PR  →  release-please pushes tag v1.3.10 + creates GitHub Release
    │
    └── v*  ──▶ [wordpress-svn-release.yml]
                    version check → npm build → pack → upload zip to the Release
                    → deploy to WordPress.org SVN (trunk + tags/1.3.10)
```

---

## `pr.yml` — PR checks

Three jobs:

- **php-lint** — `php -l` over every PHP file except `public/vendor/` (generated
  autoloader), on PHP 7.4, 8.2, 8.3 and 8.4.
- **assets** — `npm run lint` (`tsc --noEmit`), `npm run build`, then a check that the
  build produced every file the plugin enqueues. `public/build/` is not in the
  repository; the release builds it, so nothing can go stale, but a renamed or broken
  entry point would otherwise only show up as a 404 in wp-admin.
- **pack** — runs `bin/pack.sh` and asserts the staged payload has an autoloader and
  the plugin file, and carries no `composer.json`, `composer.lock`, `src/`,
  `src-blocks/` or `tsconfig.json`.

## `release-please.yml` — release PR

Runs on every push to `main`. Uses a short-lived installation token of the org-owned
"Palasthotel Release Bot" app rather than `GITHUB_TOKEN`, because the tag this job
pushes has to trigger `wordpress-svn-release.yml` — and tags pushed with
`GITHUB_TOKEN` trigger nothing.

## `update-plugin-version.yml` — version carriers

Runs on the release-please PR only (`startsWith(github.head_ref, 'release-please--')`)
and only for branches in this repository, so `pull_request` is safe here and gives
access to secrets. It runs `bin/update-plugin-version.sh`, which reads `version.txt`
and writes:

- the `Version:` header in `public/additional-authors.php`
- `Stable tag:` in `public/readme.txt`
- a new `= x.y.z =` section under `== Changelog ==` in `public/readme.txt`, converted
  from the `CHANGELOG.md` entry release-please just wrote

The commit is pushed with the app token so the PR checks re-run on the new head.

## `wordpress-svn-release.yml` — deploy

**Trigger:** push of a `v*` tag.

```
Tag v1.3.10 pushed
    │
    ├── strip prefix → VERSION=1.3.10
    │
    ├── bin/version-checker.sh
    │       version.txt == readme.txt Stable tag == plugin header Version == tag
    │       aborts before anything is published if they disagree
    │
    ├── npm ci + npm run build         (editor assets → public/build/)
    │
    ├── bin/pack.sh
    │       rsync -rL public/ → build/additional-authors/
    │       composer install --no-dev + dump-autoload --optimize
    │       drop composer.json / composer.lock from the payload
    │       zip → additional-authors.zip  (build/ is left in place)
    │
    ├──▶ Upload additional-authors.zip to the GitHub Release
    │
    ├── svn checkout $SVN_REPO_URL → ./svn/
    │
    └── SVN commit
            rm trunk/*  +  rm tags/$VERSION
            rsync -rL build/additional-authors/ → trunk/ → tags/$VERSION/
            rsync -rL --delete assets/ → assets/   (only if assets/ exists in the repo)
            svn add --force . ; svn rm for files that disappeared
            svn commit "Release version $VERSION"
```

The SVN payload comes from `build/additional-authors/`, the same directory that was
zipped, so the download on wordpress.org and the GitHub release asset are identical.
`rsync -rL` resolves symlinks, because wordpress.org drops them when it builds the
download.

`assets/` holds the media for the wordpress.org plugin page (banner, icon,
screenshots). It sits **next to** `trunk/` in SVN and is never part of the download.
The repository is the source of truth for it, hence `--delete`.

**Retry:** the workflow also accepts `workflow_dispatch` with a version input (e.g.
`1.3.10`), for when a tag-triggered run failed. A tag push reads the workflow file as
it was at the tagged commit, so re-running the tag event replays the old file;
dispatch from a branch runs the current one. It deploys the content of the ref you
select, and `bin/version-checker.sh` aborts before anything is published if the
version carriers disagree with the version you entered.

**Required secrets / vars:**

| Secret / Variable | Purpose |
|---|---|
| `vars.RELEASE_BOT_APP_ID` | GitHub App id of the release bot |
| `secrets.RELEASE_BOT_PRIVATE_KEY` | its private key |
| `secrets.SVN_USERNAME` | WordPress.org username |
| `secrets.SVN_PASSWORD` | WordPress.org password |
| `vars.SVN_REPO_URL` | `https://plugins.svn.wordpress.org/additional-authors` |
