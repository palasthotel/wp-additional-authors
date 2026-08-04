#!/usr/bin/env bash
# Syncs the plugin's version carriers after release-please opened or updated the
# release PR:
#   - public/additional-authors.php  "Version:" header
#   - public/readme.txt      "Stable tag:" and a new "= x.y.z =" changelog section
# The version is read from version.txt, which release-please bumps in the PR.
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

VERSION_FILE="$ROOT_DIR/version.txt"
CHANGELOG="$ROOT_DIR/CHANGELOG.md"
README="$ROOT_DIR/public/readme.txt"
PLUGIN_PHP="$ROOT_DIR/public/additional-authors.php"

if [[ ! -f "$VERSION_FILE" ]]; then
  echo "🤖 version.txt not found — is this a release-please branch?" >&2
  exit 1
fi

VERSION="$(tr -d '[:space:]' < "$VERSION_FILE")"
echo "🤖 Updating plugin files for version $VERSION …"

# sed -i.bak keeps this script usable on both GNU and BSD/macOS sed
sed_inplace() {
  sed -i.bak "$1" "$2"
  rm -f "$2.bak"
}

# ── 1. Update the Version header in plugin.php (keeping its alignment) ───
sed_inplace "s/^\( \* Version:[[:space:]]*\).*/\1$VERSION/" "$PLUGIN_PHP"

# ── 2. Update Stable tag in readme.txt ──────────────────────────────────────
sed_inplace "s/^Stable tag: .*/Stable tag: $VERSION/" "$README"

# ── 3. Bail out if this version is already in the readme changelog ──────────
# Only look inside "== Changelog ==" — "== Upgrade Notice ==" uses the same
# "= x.y.z =" heading syntax and must not count as an existing entry.
ALREADY_LOGGED=$(awk -v heading="= $VERSION =" '
  /^== Changelog ==/ { in_changelog = 1; next }
  in_changelog && /^== / { in_changelog = 0 }
  in_changelog && $0 == heading { found = 1 }
  END { print found ? "yes" : "no" }
' "$README")

if [[ "$ALREADY_LOGGED" == "yes" ]]; then
  echo "🤖 readme.txt already has a changelog entry for $VERSION — nothing to do"
  exit 0
fi

# ── 4. Extract and convert the changelog section for this version ────────────
# The section starts at "## [X.Y.Z]" and ends at the next heading of the same or
# a higher level. Stopping at any "# " / "## " — not just at the next "## [" —
# keeps anything release-please parks below the entries out of the readme, while
# the "### Bug Fixes" subheadings inside the entry are kept.
SECTION=$(awk -v version="$VERSION" '
  !found && index( $0, "## [" version "]" ) == 1 { found = 1; next }
  found && ( /^# / || /^## / ) { exit }
  found && /^[[:space:]]*<!--/ { next }
  found { print }
' "$CHANGELOG")

if [[ -z "$SECTION" ]]; then
  echo "🤖 No CHANGELOG.md entry found for $VERSION — skipping changelog update"
  exit 0
fi

# Convert Markdown to WordPress readme format:
#   - "### Bug Fixes"                 → "**Bug Fixes**", preceded by one blank line
#   - "* item ([abc1234](https://…))" → "* item (abc1234)"
#   - collapse the blank line runs release-please emits
WP_LINES=""
while IFS= read -r line; do
  if [[ "$line" =~ ^###+[[:space:]]+(.*)$ ]]; then
    [[ -n "$WP_LINES" ]] && WP_LINES+=$'\n'
    WP_LINES+="**${BASH_REMATCH[1]}**"$'\n'
    continue
  fi
  # Skip blank lines — the headings above provide the only spacing we want
  [[ -z "${line//[[:space:]]/}" ]] && continue
  line=$(printf '%s' "$line" | sed 's/\[\([^]]*\)\]([^)]*)/\1/g')
  WP_LINES+="$line"$'\n'
done <<< "$SECTION"

WP_ENTRY="= $VERSION ="$'\n'"${WP_LINES%$'\n'}"

# ── 5. Prepend entry after "== Changelog ==" ────────────────────────────────
ENTRY_FILE=$(mktemp)
printf '%s\n' "$WP_ENTRY" > "$ENTRY_FILE"

TMPFILE=$(mktemp)
awk -v entry_file="$ENTRY_FILE" '
  /^== Changelog ==/ && !injected {
    print
    print ""
    while ((getline line < entry_file) > 0) print line
    print ""
    injected = 1
    skip_blank = 1
    next
  }
  # Swallow the blank line that followed "== Changelog ==" — we printed our own
  skip_blank && /^[[:space:]]*$/ { skip_blank = 0; next }
  { skip_blank = 0; print }
' "$README" > "$TMPFILE"
mv "$TMPFILE" "$README"
rm -f "$ENTRY_FILE"

echo "🤖 readme.txt updated successfully."
