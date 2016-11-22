
function mascara(o,f){
    v_obj=o;
    v_fun=f;
    setTimeout("execmascara()",1);
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}
function alphanum( v ){
    v=v.replace(/[^a-zA-Z0-9]/g,"");			//Remove tudo o que não é dígito
    return v;
}
