#!/usr/bin/env bash
# Guard for the release job: the tag being released must match every version
# carrier in the repository. Expects VERSION in the environment (without "v").
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

VERSION="${VERSION:-}"
if [[ -z "$VERSION" ]]; then
  echo "ERROR: VERSION is not set (e.g. VERSION=1.0.4)" >&2
  exit 1
fi

# 1) version.txt — maintained by release-please
VERSION_TXT="$(tr -d '[:space:]' < "$ROOT_DIR/version.txt")"

# 2) readme.txt "Stable tag:"
README_VERSION="$(grep -E '^Stable tag:' "$ROOT_DIR/public/readme.txt" | head -n1 | sed -E 's/^Stable tag:[[:space:]]*//')"

# 3) the plugin header "Version:"
PLUGIN_VERSION="$(grep -E '^[[:space:]]*\*?[[:space:]]*Version:[[:space:]]*[0-9]+\.[0-9]+' "$ROOT_DIR/public/additional-authors.php" \
  | head -n1 \
  | sed -E 's/.*Version:[[:space:]]*([0-9]+(\.[0-9]+)+).*/\1/')"

fail=0

check_eq() {
  local label="$1"
  local got="$2"
  if [[ -z "$got" ]]; then
    echo "ERROR: could not read ${label}" >&2
    fail=1
  elif [[ "$got" != "$VERSION" ]]; then
    echo "ERROR: ${label} is $got, expected $VERSION" >&2
    fail=1
  else
    echo "OK: ${label} == $VERSION"
  fi
}

check_eq "version.txt" "$VERSION_TXT"
check_eq "readme.txt Stable tag" "$README_VERSION"
check_eq "additional-authors.php Version" "$PLUGIN_VERSION"

if [[ "$fail" -ne 0 ]]; then
  echo "Release version check failed." >&2
  exit 1
fi

echo "All versions match ✅"
