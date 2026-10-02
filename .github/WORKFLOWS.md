# CI/CD Workflows

The four workflows in `.github/workflows/` call the shared ones in
[palasthotel/github-workflows](https://github.com/palasthotel/github-workflows). How
they work, every input and what to do when a deploy fails is described there, in
[docs/wp-plugin.md](https://github.com/palasthotel/github-workflows/blob/main/docs/wp-plugin.md).

What is specific to this plugin:

| | |
|---|---|
| wordpress.org slug | `additional-authors` |
| version file | `version.txt` (`release-type: simple`) - `package.json` carries no version |
| build step | `npm ci && npm run build` → `public/build/`; the PR check also runs `npm run lint` (`tsc --noEmit`) |
| composer | `public/composer.json` - the pack writes a `--no-dev` optimized autoloader and drops `composer.json`/`composer.lock` from the payload |
| required files | everything `Assets.php` enqueues and the two blocks `Blocks.php` registers from `public/build/` |
| assets | `assets/` is in the repository and mirrored to the plugin page media in SVN |
