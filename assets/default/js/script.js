var Moquiz = {
    general_error_message : $('#sm-wrong').val(),

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
    },

    hideElement : function(elem){
        $(elem).hide();
    },

    showElement : function(elem){
        $(elem).show();
    },

    saveQuestion : function(){
      let q = $('#quiz-title-input');
      let errmsg  = $(q).data('errmsg');
      if(q.val() == '') return notifyError(errmsg);
      Moquiz.hideElement('.quiz-title-wrapper');
      Moquiz.showElement('.quiz-question-create-box');
      return false;
    },

    redirect : function(url){
        window.location.href = url;
    },
    saveQuiz : function(){
        let frm = $('#submit-quiz-form');
        let loader = $('.form-loader');
        loader.fadeIn();
        frm.ajaxSubmit({
            url : frm.attr('action'),
            method : 'POST',
            success : function (data) {
                //console.log(data)
                let rsp = jQuery.parseJSON(data);
                if(rsp.status == 0){
                    notifyError(rsp.message);
                }else{
                    notifySuccess(rsp.message);
                   Moquiz.redirect(rsp.url)
                }
                loader.hide();
            },

            error : function (data) {
                loader.hide();
                notifyError(this.general_error_message);
            }


        });
    },

    updateQuestionCount : function(c){
        $('.question-count-number').html('#'+c);
        $('.qq-btn-count').html('Question #'+c);
    },

    nextQuestion : function(){

        let active_question = $(".q-question-answer-wrapper.active");
        let success = true;
        if(active_question.length){
            //check if question text or photo is set
            let qtext = active_question.find('.question-row-input input').val();
            let img = active_question.find('.question-image-area input').val();
            if(qtext == '' && img == ''){
                notifyError($("#rq-question").val());
                success = false;
                return false;
            }

            //check if answer Text or Phot is set
            active_question.find('.a-input-wrapper').each(function(index){
                let elem = $(this);
                if(elem.find('.image-file-input').val() == '' && elem.find('.answer-box-row-input').val() == ''){
                    notifyError($("#rq-answer").val());
                    success = false;
                    return false;
                }
            });
            if(!success) return false;

            //check if at least one correct answer is choosen

            let atleast_one = false;
            active_question.find('.a-input-wrapper').each(function () {
                let elem = $(this);
                if(parseInt(elem.find('.switch input[type=radio]:checked').val()) == 1){
                   atleast_one = true;
                }
            });

            if(!atleast_one){
                notifyError($("#rq-correct").val());
                return false;
            }
            if(success){
                let index = active_question.data('id');
                let nidx = parseInt(index) + 1;

                //we might be coming back from previous
                if($("#q-a-"+nidx).length){

                    $("#q-a-"+index)
                        .removeClass('active')
                        .hide();

                    $("#q-a-"+nidx)
                        .addClass('active')
                        .show();

                    $('.submit-q-prev').show();
                    this.updateQuestionCount(nidx);
                    return true;
                }
                let html = $('#q-a-0').clone();
                //notifySuccess('Add Question #'+nidx+' or save your Quiz', 4000);

                Moquiz.updateQuestionCount(nidx)
                //$('.q-question-answer-wrapper-parent').append(html);

                $(html).attr('id','q-a-'+ nidx);
                $(html).attr('data-id',  nidx);

                //remove all the active
                $('.q-question-answer-wrapper').removeClass('active');
                $(html).addClass('active');
                html.find('.remove-answer-box').click();
                html.find('.dynamic-ans').remove();

                //hide the current question
                $("#q-a-"+index).hide();
                $("#q-a-"+nidx).show();

                //reset all the previous input
                $(html).find('input').val('');
                $(html).find('img').attr('src','').hide();

                //rename all the input to carry the index
                $(html).find('.question-row-input input').attr('name','question_'+nidx);
                $(html).find('.question-image-area input').attr('name','qimage_'+nidx);

                //answer image
                $(html).find('.answer-image-area:first input').attr('name','answer_image_'+nidx+'_1');
                $(html).find('.answer-image-area:last input').attr('name','answer_image_'+nidx+'_2');

                //answer text
                $(html).find('.answer-box-row-input:first').attr('name','answer_text_'+nidx+'_1');
                $(html).find('.answer-box-row-input:last').attr('name','answer_text_'+nidx+'_2');

                //correct toggle for this question
                $(html).find('.switch:first input').attr('name','correct_'+nidx+'_1');
                $(html).find('.switch:first input:first').val(0);
                $(html).find('.switch:first input:last').val(1);
                $(html).find('.switch:last input').attr('name','correct_'+nidx+'_2');
                $(html).find('.switch:last input:first').val(0);
                $(html).find('.switch:last input:last').val(1);



                //show the previous btn
                $('.submit-q-prev').show();
                $('.submit-save-quiz').show();

                $('.q-question-answer-wrapper-parent').append(html.show());

            }

        }else{
            notifyError(this.general_error_message);
        }
    },

    prevQuestion : function (d) {
        let obj = $(d);
        let a_elem = $(".q-question-answer-wrapper.active");
        let ai = parseInt($(a_elem).data('id'));
        console.log(' ac ' + ai);
        let pi = ai-1;
        if(pi > 0){
            $("#q-a-"+ai)
                .removeClass('active')
                .hide();
            $("#q-a-"+pi)
                .addClass('active')
                .show();
            Moquiz.updateQuestionCount(pi);
            if(ai === 2){
                $(obj).hide();
            }
        }else{
            $(obj).hide();
        }
        //if()
    }
};

function notifyError(m,t){
    Swal.fire({
        position: 'bottom-left',
        //type: 'error',
        html: '<span class="text-danger">'+m+'</span>',
        showConfirmButton: false,
        showCloseButton: true,
        timer: (typeof t != "undefined") ? t : 8000
    })
}

function show_iframe(m,img){
    return Swal.queue([{
        title: 'Embed on Website',
        //confirmButtonText: 'Show my public IP',
        //text: 'Your public IP will be received ' + 'via AJAX request',
        input: 'textarea',
        inputValue : '<div><a target="_blank" href="'+m+'" style="height: 200px;width : 200px; overflow : hidden"><img style="height: 100%; width: 100%" src="'+img+'" /></a> </div>',

    }])
}
function notifySuccess(m, t){
    Swal.fire({
        position: 'bottom-left',
        //type : 'success',
        html: '<span class="text-success">'+m+'</span>',
        showConfirmButton: false,
        showCloseButton: true,
        timer: (typeof t != "undefined") ? t:  8000
    })
}

function elem_fade_toggle(e){
    let d = $(e).data('elem');
    $(d).fadeToggle();
    $(e).toggleClass('active');
    return false;
}

function help_me_ideas(d){
    let text = $(d).val();
    $('.q-question-answer-wrapper.active .question-row-input input').val(text);
}


$(document).on('click','.add-more-answer',function(){
    let html = $('#a-one-pick').clone();

    //we are adding to the active question
    let aq = $('.q-question-answer-wrapper.active'); //active question
    let nidx = $(aq).data('id'); //questionindext
    //answer image
    let al = $(aq).find('.a-input-wrapper').length; //current asnwer length

    //remove that id
    $(html).attr('id','');
    let mal = parseInt(al) + 1; //my own length should be
    $(html).find('.answer-image-area input').attr('name','answer_image_'+nidx+'_'+mal);

    //answer text
    $(html).find('.answer-box-row-input').attr('name','answer_text_'+nidx+'_'+mal);

    //correct toggle for this question
    $(html).find('.switch input').attr('name','correct_'+nidx+'_'+mal);
    $(html).find('.switch input:first').val(0);
    $(html).find('.switch input:last').val(1);

    $('.answer-box-row').append(html.show());
    return true;
});

function readURL(input) {
    let parent = $(input).parent();
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            parent.find('img').attr('src', e.target.result);
            parent.find('img').fadeIn();
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('change','.image-file-input',function(){
    readURL(this);
});

$(function(){
    feather.replace();

    $(document).on('click','.answer-image-area svg, .question-image-area svg',function () {
      $(this).parent().find('input').click();
    });

    $(document).on('click','.remove-answer-box',function () {
      $(this).closest('.a-input-wrapper').remove();
      return false;
    });

    $(document).on('click', '.switch',function (e) {
        if (e.target.classList.contains('slider')) {
            $(this).find('.slider').removeClass('unselect');
            var checked = $(this).closest('.switch').find('input:checked');
            var notChecked = $(this).closest('.switch').find('input:not(:checked)');
            checked.attr('checked', false);
            notChecked.attr('checked', true);
            notChecked.click();
        }
    });
    $(document).on('click','.switch input', function (e) {
        if (e.originalEvent !== undefined) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    //share
    $(document).on('click','.share-action',function(){
       let obj = $(this);
       let t = obj.data('type');
       let url = $("#quiz-link-input").val();
       //mailto:?subject=Take%20My%20Quiz&body=Take%20my%20Quiz:%3CBR%3Ehttp%3A%2F%2Fwww.quizyourfriends.com/take-quiz.php?id=2002221301122793%26eml%26%3CBR%3E%3CBR%3ESee%20how%20well%20you%20can%20score!
       //let url = 'https://stackoverflow.com/questions/9120539/facebook-share-link-without-javascript';
       let title = $("#quiz-link-input").data('title');
       if(t == 'copy'){
           let success_msg = obj.data('msg');
           /* Get the text field */
           var copyText = document.getElementById("quiz-link-input");

           /* Select the text field */
           copyText.select();
           copyText.setSelectionRange(0, 99999); /*For mobile devices*/

           /* Copy the text inside the text field */
           document.execCommand("copy");

           notifySuccess('Link Copied');
       }else if(t == 'message'){
           return window.open('sms:&body='+ $('#content-to-share').val(), '_blank');
       }
       else if(t == 'email'){
           let sbj = obj.data('sub');
           return window.open('mailto:?subject='+sbj+'&body='+encodeURI($('#content-to-share').val()), '_blank');
       }
       else if(t == 'facebook'){
           return window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURI(url), title, 'width = 500, height = 500, scrollbars = yes')
       }
       else if(t == 'twitter'){
           return window.open('https://twitter.com/share?url='+encodeURI(url), title, 'width = 500, height = 500, scrollbars = yes')
       }
       else if(t == 'whatsapp'){
           //whatsapp://send?text=The text to share!
           return window.open('https://api.whatsapp.com/send?text='+ encodeURI($('#content-to-share').val()), title, 'width = 500, height = 500, scrollbars = yes')
       } else if(t == 'embed'){
           return show_iframe(url,obj.data('img'));
           return true;
       }
       return false;
    });
});


//Taking Question Next and Previous
$(document).on('click','.btn-start-action-next',function(){
    let obj = $(this);
    let submit_button = $('.btn-start-action-submit');
    let active_object = $('.question-each-box.active');
    let active_index = $(active_object).data('idx');
    let next_index = parseInt(active_index) + 1;
    let next_object = $('.question-each-box-index-'+next_index);
    let success = false;
    if(next_object.length){
        //Before moving to the next
        //check if the user have choose an answer
        active_object.find('.pretty').each(function(index){
            let elem = $(this);
            if(elem.find('input').prop('checked') === true){
                success = true;
                //return false;
            }
        });
        if(success){
            active_object.removeClass('active').hide();
            //next_object.addClass('active').slideToggle();
            next_object.addClass('active').fadeIn('fast');
            $('.q-start-count').html(next_index);
            //next next
            if(!$('.question-each-box-index-'+ (next_index + 1)).length){
                //there is no next qustion
                obj.hide();
                submit_button.fadeIn('fast');
            }
        }else{
            notifyError(obj.data('canswer'))
        }
    }
    //update the indext showing to user
    //console.log('alaye jor jor');
   return false;
});
//previous question
$(document).on('click','.btn-start-action-prev',function(){
    let obj = $(this);
    let next_button = $('.btn-start-action-next');
    let submit_button = $('.btn-start-action-submit');
    let active_object = $('.question-each-box.active');
    let active_index = $(active_object).data('idx');
    let prev_index = parseInt(active_index) - 1;
    let prev_object = $('.question-each-box-index-'+prev_index);
    if(prev_object.length){
        submit_button.hide();
        next_button.fadeIn('fast');
        active_object.removeClass('active').hide();
        //prev_object.addClass('active').slideToggle();
        prev_object.addClass('active').fadeIn('fast');
        $('.q-start-count').html(prev_index);
    }
    //update the indext showing to user
    console.log('alaye jor jor');
   return false;
});

//save question
$(document).on('click','.btn-start-action-submit',function(){
    let frm = $('#take-quiz-form');
    let loader = $('.form-loader');
    loader.fadeIn();
    frm.ajaxSubmit({
        url : frm.attr('action'),
        method : 'POST',
        success : function (data) {
            //console.log(data)
            let rsp = jQuery.parseJSON(data);
            if(rsp.status == 0){
                notifyError(rsp.message);
            }else{
                notifySuccess(rsp.message);
                Moquiz.redirect(rsp.url)
            }
            loader.hide();
        },

        error : function (data) {
            loader.hide();
            notifyError(this.general_error_message);
        }


    });
});







