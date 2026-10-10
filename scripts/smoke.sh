#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"; cd "$ROOT"
fail(){ echo "✗ $1" >&2; exit 1; }; ok(){ echo "✓ $1"; }
command -v php >/dev/null || fail "需要 PHP"
[[ -f gen_json.php && -f get_phrase.php ]] || fail "缺少 PHP 脚本"
[[ -f index.html || -f album/album.html ]] || fail "缺少前端页"
[[ -d photos && -d phrases ]] || fail "缺少 photos/phrases"
ok "核心文件齐全"
php -l gen_json.php >/dev/null
php -l get_phrase.php >/dev/null
ok "PHP lint OK"
php gen_json.php >/dev/null || true
[[ -f photos.json ]] && ok "photos.json 存在/已生成" || echo "⚠ photos.json 未生成（photos 可能为空）"
PORT="${SMOKE_PORT:-18083}"
php -S "127.0.0.1:${PORT}" -t "$ROOT" >/tmp/family-album-smoke.log 2>&1 &
PID=$!; trap "kill $PID 2>/dev/null||true" EXIT
for i in $(seq 1 30); do curl -sf "http://127.0.0.1:${PORT}/" >/dev/null 2>&1 && break; sleep 0.15; done
curl -sf "http://127.0.0.1:${PORT}/" | grep -qi 'html' || fail "首页失败"
ok "首页 200"
echo ""; echo "smoke: ok"
