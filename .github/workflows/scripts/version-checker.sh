#!/usr/bin/env bash
set -euo pipefail

VERSION="${VERSION:-}"

if [[ -z "$VERSION" ]]; then
  echo "ERROR: VERSION ist nicht gesetzt (z.B. VERSION=2.0.2)" >&2
  exit 1
fi

# 1) package.json version (Node muss verfügbar sein)
PKG_VERSION="$(node -p "require('./package.json').version" 2>/dev/null || true)"
if [[ -z "$PKG_VERSION" ]]; then
  echo "ERROR: Konnte package.json version nicht auslesen (package.json vorhanden?)" >&2
  exit 1
fi

# 2) readme.txt Stable tag
README_VERSION="$(grep -E '^Stable tag:' ./readme.txt | head -n1 | sed -E 's/^Stable tag:[[:space:]]*//')"
if [[ -z "$README_VERSION" ]]; then
  echo "ERROR: Konnte 'Stable tag:' nicht in readme.txt finden" >&2
  exit 1
fi

# 3) Plugin.php Version (typisch in Plugin-Headern; wir nehmen die erste passende Zeile)
PLUGIN_VERSION="$(grep -E '^[[:space:]]*\*?[[:space:]]*Version:[[:space:]]*[0-9]+\.[0-9]+\.[0-9]+' ./additional-authors.php \
  | head -n1 \
  | sed -E 's/.*Version:[[:space:]]*([0-9]+\.[0-9]+\.[0-9]+).*/\1/')"

if [[ -z "$PLUGIN_VERSION" ]]; then
  echo "ERROR: Konnte 'Version:' nicht in Plugin.php finden" >&2
  exit 1
fi

fail=0

check_eq () {
  local label="$1"
  local got="$2"
  if [[ "$got" != "$VERSION" ]]; then
    echo "ERROR: ${label} ist $got, erwartet $VERSION" >&2
    fail=1
  else
    echo "OK: ${label} == $VERSION"
  fi
}

check_eq "package.json version" "$PKG_VERSION"
check_eq "readme.txt Stable tag" "$README_VERSION"
check_eq "Plugin.php Version" "$PLUGIN_VERSION"

if [[ "$fail" -ne 0 ]]; then
  echo "Release-Version-Check fehlgeschlagen." >&2
  exit 1
fi

echo "Alle Versionen passen ✅"
