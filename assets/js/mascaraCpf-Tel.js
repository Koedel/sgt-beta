
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function cpf_mask(v) {
        v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca ponto entre o terceiro e o quarto dígitos
        v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca ponto entre o terceiro e o quarto dígitos
        v = v.replace(/(\d{3})(\d)/, "$1-$2") //Coloca barra após o quinto dígito

        return v
    }


    function tel_mask(v) {
        v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{0})(\d)/, "$1($2") //Coloca parentese antes do primeiro digito
        v = v.replace(/(\d{2})(\d)/, "$1)$2") //Coloca parentese após o segundo digito
        v = v.replace(/(\d{4})(\d)/, "$1-$2") //Coloca barra após o quarto digito

        return v
    }
    function cel_mask(v) {
        v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{0})(\d)/, "$1($2") //Coloca parentese antes do primeiro digito
        v = v.replace(/(\d{2})(\d)/, "$1)$2") //Coloca parentese após o segundo digito
        v = v.replace(/(\d{5})(\d)/, "$1-$2") //Coloca barra após o quarto digito

        return v
    }
    
function mascaraRG(v){
         v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca parentese antes do primeiro digito
        v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca parentese após o segundo digito
        v = v.replace(/(\d{3})(\d)/, "$1-$2") //Coloca barra após o quarto digito

        return v
}
