# Usage: python3 scripts/i18n/check-blade.py $(git diff --name-only -- "*.blade.php")
# Lint PHP expressions inside {{ }}, {!! !!}, @json(...) of given Blade files, and
# compare directive balance against HEAD (to only flag newly introduced imbalance).
import re,sys,subprocess,tempfile,os
def exprs(s):
    s=re.sub(r'\{\{--.*?--\}\}','',s,flags=re.S); s=re.sub(r'@\{\{.*?\}\}','',s,flags=re.S)
    out=[m.group(1) for m in re.finditer(r'\{!!(.*?)!!\}',s,re.S)]
    s2=re.sub(r'\{!!.*?!!\}','',s,flags=re.S)
    out+=[m.group(1) for m in re.finditer(r'\{\{(.*?)\}\}',s2,re.S)]
    for m in re.finditer(r'@json\(',s):
        i=m.end(); d=1; j=i
        while j<len(s) and d: d+= {'(':1,')':-1}.get(s[j],0); j+=1
        out.append(s[i:j-1])
    return out
def bal(s):
    s=re.sub(r'\{\{--.*?--\}\}','',s,flags=re.S)
    return {k:len(re.findall(r'@'+k+r'\b',s))-len(re.findall(r'@end'+k+r'\b',s)) for k in ['if','foreach','section','push','auth','guest','php','forelse','isset','unless','component']}
bad=0
for f in sys.argv[1:]:
    s=open(f).read()
    code="<?php\n"+"".join("echo (%s);\n"%e.strip() for e in exprs(s) if e.strip())
    t=tempfile.NamedTemporaryFile('w',suffix='.php',delete=False); t.write(code); t.close()
    r=subprocess.run(['php','-l',t.name],capture_output=True,text=True); os.unlink(t.name)
    if r.returncode: bad+=1; print("EXPR",f,(r.stdout+r.stderr).strip().splitlines()[0][:200])
    try: old=subprocess.run(['git','show','HEAD:'+f],capture_output=True,text=True).stdout
    except Exception: old=''
    if old and bal(old)!=bal(s): bad+=1; print("BALANCE",f,bal(old),bal(s))
print("checked",len(sys.argv)-1,"bad",bad)
