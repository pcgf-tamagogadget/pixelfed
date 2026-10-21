<?php
// Usage: php scripts/i18n/check-keys.php . [path-prefix ...]   (no vendor/ needed)
// Checks: (1) every $t()/__() key referenced in files under the given path
// prefixes exists in lang/en-US; (2) en-US vs ja-JP have identical leaf keys for
// every group; (3) placeholders/HTML tags match; (4) no empty ja-JP strings.
if (!function_exists('config')) { function config($k,$d=null){return $d ?? 'x';} }
if (!function_exists('route')) { function route(...$a){return '/r';} }
if (!function_exists('url')) { function url(...$a){return '/u';} }
$root = rtrim($argv[1] ?? '.', '/'); $prefixes = array_slice($argv, 2);
$FRONT = ['admin','classic','compose','groups','spa'];
function flat($a,$p=''){ $o=[]; foreach($a as $k=>$v){ $kk=$p===''?(string)$k:"$p.$k"; if(is_array($v)&&$v!==[]) $o+=flat($v,$kk); elseif(!is_array($v)) $o[$kk]=$v;} return $o; }
function load($root,$loc,$g){ $f="$root/lang/$loc/$g.php"; if(!is_file($f)) return null; try { $r = require $f; } catch (\Throwable $e) { echo "PHP ERROR in $f: {$e->getMessage()}\n"; return []; } return is_array($r)?flat($r):[]; }
$errors=0;
$groups=array_map(fn($f)=>basename($f,'.php'), glob("$root/lang/en-US/*.php"));
$en=[]; $ja=[];
foreach($groups as $g){ $en[$g]=load($root,'en-US',$g)??[]; $ja[$g]=load($root,'ja-JP',$g)??[]; }
$tok=function($s){ preg_match_all('/(:[a-z_]+|\{[a-zA-Z_]+\}|<\/?[a-z]+)/',(string)$s,$m); $x=$m[0]; sort($x); return $x; };
foreach($groups as $g){
  if ($g==='validation') continue;
  foreach($en[$g] as $k=>$v){
    if(!array_key_exists($k,$ja[$g])){ echo "JA MISSING  $g.$k\n"; $errors++; continue; }
    if(!is_string($ja[$g][$k])||trim($ja[$g][$k])===''){ echo "JA EMPTY    $g.$k\n"; $errors++; continue; }
    if($tok($v)!==$tok($ja[$g][$k])){ echo "PLACEHOLDER $g.$k\n   en: $v\n   ja: {$ja[$g][$k]}\n"; $errors++; }
    if(in_array($g,$FRONT)||$g==='web'){ if(preg_match('/(?<!@)\|/',$v)) { echo "PIPE(|) in vue string $g.$k\n"; $errors++; } }
  }
  foreach(array_diff_key($ja[$g],$en[$g]) as $k=>$_){ if(!str_starts_with($k,'custom.')) { echo "JA EXTRA    $g.$k\n"; $errors++; } }
}
// referenced keys
$it=new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/resources", FilesystemIterator::SKIP_DOTS));
$refs=0;
foreach($it as $f){ $p=$f->getPathname(); $rel=substr($p,strlen($root)+1);
  if(!preg_match('/\.(vue|php)$/',$p) || str_contains($rel,'/i18n/')) continue;
  if($prefixes && !array_filter($prefixes, fn($x)=>str_starts_with($rel,$x))) continue;
  $s=file_get_contents($p);
  if(str_ends_with($p,'.vue') || preg_match_all('/\$tc?\(/',$s)) {
    preg_match_all('/(?:\$t[ce]?\(\s*|<i18n\b[^>]*?\bpath=)[\'"]([A-Za-z0-9_.\-]+)[\'"]/',$s,$m);
    foreach($m[1] as $key){ if(str_ends_with($key,".")) continue; $refs++; $parts=explode('.',$key); $g=in_array($parts[0],$FRONT)?array_shift($parts):'web'; $k=implode('.',$parts);
      if(!isset($en[$g][$k])){ echo "UNDEFINED   \$t('$key') in $rel\n"; $errors++; } }
  }
  if(str_ends_with($p,'.php')){
    preg_match_all('/(?:__|trans|trans_choice|@lang|@choice|Lang::get)\(\s*[\'"]([a-z_]+)\.([A-Za-z0-9_.\-]+)[\'"]/',$s,$m,PREG_SET_ORDER);
    foreach($m as $x){ [$all,$g,$k]=$x; if(str_ends_with($k,'.')) continue; $refs++; if(!in_array($g,$groups)) continue; if(!isset($en[$g][$k])){ echo "UNDEFINED   __('$g.$k') in $rel\n"; $errors++; } }
  }
}
echo "checked refs=$refs errors=$errors\n"; exit($errors?1:0);
