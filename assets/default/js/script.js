var Moquiz = {
    showThisHideThat(tis,that){
        $(that).hide();
        $(tis).show();
        return false;
    },

    toggleAccountCreateBtn(obj){
       let cText = $(obj).data('ltext');
       let lText = $(obj).data('ctext');
       if($('.home-page-wrapper-content-login').css('display') === 'block'){
           $('.home-page-wrapper-content-login').hide();
           $('.home-page-wrapper-content-signup').fadeIn();
           $(obj).html(cText)
       }else{
           $('.home-page-wrapper-content-signup').hide();
           $('.home-page-wrapper-content-login').fadeIn();
           $(obj).html(lText)
       }
       return false;
    }
};