// Compile every changed .vue template and parse its <script> (no build).
// Usage: node scripts/i18n/check-vue.js "$PWD" $(git diff --name-only -- "*.vue")
const fs=require('fs'), path=require('path');
const root=process.argv[2]; const c=require(path.join(root,'node_modules/vue-template-compiler'));
const acorn=(()=>{try{return require(path.join(root,'node_modules/acorn'))}catch(e){return null}})();
let bad=0, n=0;
for (const f of process.argv.slice(3)) {
  const src=fs.readFileSync(f,'utf8'); const sfc=c.parseComponent(src); n++;
  if (sfc.template) { const r=c.compile(sfc.template.content,{whitespace:'condense'}); if (r.errors.length){bad++; console.log('TEMPLATE',f,r.errors.slice(0,3));} }
  if (sfc.script && acorn) { try { acorn.parse(sfc.script.content,{ecmaVersion:2022,sourceType:'module'}); } catch(e){ bad++; console.log('SCRIPT',f,e.message); } }
}
console.log('checked',n,'bad',bad, acorn?'':'(no acorn: scripts not parsed)');
