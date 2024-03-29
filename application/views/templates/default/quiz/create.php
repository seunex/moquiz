<input type="hidden" value="<?php echo lang("something_went_wrong") ?>" id="sm-wrong"/>
<input type="hidden" value="<?php echo lang("question_text_or_photo_is_required") ?>" id="rq-question"/>
<input type="hidden" value="<?php echo lang("answer_text_or_photo_is_required") ?>" id="rq-answer"/>
<input type="hidden" value="<?php echo lang("choose_correct_answer") ?>" id="rq-correct"/>
<input type="hidden" value="<?php echo lang("add_minimum_x_question") ?>" id="min-question"/>
<input type="hidden" value="3" id="min-question-count"/>
<div class="user-home-content">
    <div class="create-quiz-wrapper">
        <div class="create-quiz-box">

             <?php echo form_open_multipart('quiz/create',array('id'=>'submit-quiz-form'));?>
            <div class="form-loader">
                <i class="loading-icon" data-feather="loader"></i>
            </div>
            <div class="quiz-title-wrapper" style="display: block">
                <div class="create-quiz-header">
                    <span> <?php echo lang('make_a_quiz') ?></span>
                    <span><?php echo lang('send_to_your_friends'); ?></span>
                    <span><?php echo lang('see_who_knows_you_best'); ?> </span>
                    <img src="<?php echo asset_url('default/img/emoticons/winking_eye.svg') ?>" alt="😜"/>
                </div>
                <input type="text"
                       data-errmsg="<?php echo lang("error_question_title_required"); ?>"
                       autocomplete="off" id="quiz-title-input" class="form-control form-control-lg quiz-title-input"
                       placeholder="<?php echo lang('your_quiz_title'); ?>" name="title"/>
                <button class="btn btn-info btn-lg submit-q-title" type="button" onclick="return Moquiz.saveQuestion()"
                        style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
                    <?php echo lang('add_questions') ?> <i data-feather="chevrons-right"></i>
                </button>
            </div>
            <div class="quiz-question-create-box" style="display: none;">
                <h4 class="quiz-title-dynamic"><?php echo lang('my_quiz') ?> </h4>
                <div class="quiz-question-row">
                    <span class="question-count" data-count="1"><?php echo lang('question') ?> <span
                                class="question-count-number">#1</span></span>

                    <div class="q-question-answer-wrapper-parent">
                        <div class="q-question-answer-wrapper active" id="q-a-1" data-id="1">
                            <div class="qq-input-and-image">
                                <div class="question-row-input">
                                    <input type="text" name="question_1"
                                           placeholder="<?php echo lang('write_a_question_for_your_friend') ?>"
                                           class="form-control"/>

                                    <span class="possible-questions">
                                <a href=""> <?php echo lang('need_a_hand'); ?> <i data-feather="sun"></i></a>
                                <span class="pqs">
                                    <?php $this->view("templates/default/snippets/qideas") ?>
                                </span>
                            </span>
                                </div>
                                <br/>
                                <button type="button" class="btn btn-secondary btn-sm" data-elem=".question-image-area"
                                        onclick="return elem_fade_toggle(this)"><i data-feather="image"></i> <?php echo lang('question_image') ?>
                                </button>
                                <div class="question-image-area">
                                    <i data-feather="upload"></i>
                                    <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
                                    <input type="file" name="qimage_1" class="image-file-input hidden"/>
                                    <img class="img hidden " src=""/>
                                </div>
                            </div>

                            <br/>
                            <div class="divider-with-text">
                                <span class="divider-with-text-line" style="background: <?php echo config('side-bar-color','#581E95') ?>"></span>
                                <span class="d-text" style="border-color :<?php echo config('side-bar-color','#581E95') ?> "> <b> <?php echo lang('answers'); ?> </b></span>
                            </div>

                            <br/>
                            <br/>
                            <div class="answer-box">
                                <div class="answer-box-row">

                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <h6> <?php echo lang('is_correct_answer') ?> </h6></div>
                                    </div>

                                    <div class="row a-input-wrapper">
                                        <div class="col-6 lhs">
                                            <div class="answer-image-area">
                                                <i data-feather="upload"></i>
                                                <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
                                                <input type="file" name="answer_image_1_1"
                                                       class="hidden image-file-input"/>
                                                <img class="img hidden" src=""/>
                                            </div>
                                            <input type="text" placeholder="<?php echo lang('answer_text') ?>"
                                                   class="form-control answer-box-row-input" name="answer_text_1_1"/>
                                        </div>
                                        <div class="col-6">
                                            <label class="switch">
                                                <input type="radio" name="correct_1_1" value="0" checked/>
                                                <input type="radio" name="correct_1_1" value="1"/>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row a-input-wrapper">
                                        <div class="col-6 lhs">
                                            <div class="answer-image-area">
                                                <i data-feather="upload"></i>
                                                <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
                                                <input type="file" name="answer_image_1_2"
                                                       class="hidden image-file-input"/>
                                                <img class="img hidden" src=""/>
                                            </div>
                                            <input type="text" placeholder="<?php echo lang('answer_text') ?>"
                                                   class="form-control answer-box-row-input" name="answer_text_1_2"/>
                                        </div>
                                        <div class="col-6">
                                            <label class="switch">
                                                <input type="radio" name="correct_1_2" value="0" checked/>
                                                <input type="radio" name="correct_1_2" value="1"/>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary add-more-answer"><i
                                                    data-feather="plus"></i> <?php echo lang('answer') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>
                    <div class="row col-sm-12">
                        <div class="col-sm-12 alert alert-info">
                            <div class="qq-btn-count centered bold">
                                <?php echo lang('question') ?> #1
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col quiz-buttons-submit-prev">
                            <button type="button" onclick="return Moquiz.prevQuestion(this)"
                                    class="btn btn-info submit-q-prev"
                                    style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
                                <i data-feather="chevrons-left"></i> <?php echo lang('prev_caps'); ?>
                            </button>
                            <button type="button" class="btn btn-info submit-q-next"
                                    onclick="return Moquiz.nextQuestion()"
                                    style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
                                <?php echo lang('add_question_caps') ?> <i data-feather="chevrons-right"></i>
                            </button>
                            <button type="button" class="btn btn-info submit-save-quiz"
                                    onclick="return Moquiz.saveQuiz()"
                                    style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
                                <?php echo lang('save_quiz_caps'); ?> <i data-feather="save"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
<!--single answer obj -->
<div class="row a-input-wrapper dynamic-ans" id="a-one-pick" style="display: none;">
    <div class="col-6 lhs">
        <a class="remove-answer-box" href=""><i data-feather="x-circle"></i></a>
        <div class="answer-image-area">
            <i data-feather="upload"></i>
            <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
            <input type="file" name="   answer[]" class="hidden image-file-input"/>
            <img class="img hidden" src=""/>
        </div>
        <input type="text" placeholder="<?php echo lang('answer_text') ?>" class="form-control answer-box-row-input" name="answer[]"/>
    </div>
    <div class="col-6">
        <label class="switch">
            <input type="radio" name="correct[]" value="0" checked/>
            <input type="radio" name="correct[]" value="1"/>
            <span class="slider round"></span>
        </label>
    </div>
</div>
<!-- single question and answer obj -->
<div class="q-question-answer-wrapper" id="q-a-0" data-id="0" style="display: none;">
    <div class="qq-input-and-image">
        <div class="question-row-input">
            <input type="text" name="question_1"
                   placeholder="<?php echo lang('write_a_question_for_your_friend') ?>"
                   class="form-control"/>

            <span class="possible-questions">
                                <a href=""> <?php echo lang('need_a_hand') ?> <i data-feather="sun"></i></a>
                                <span class="pqs">
                                    <?php $this->view("templates/default/snippets/qideas") ?>
                                </span>
                            </span>
        </div>
        <br/>
        <button type="button" class="btn btn-secondary btn-sm" data-elem=".question-image-area"
                onclick="return elem_fade_toggle(this)"><i data-feather="image"></i> <?php echo lang('question_image') ?>
        </button>
        <div class="question-image-area">
            <i data-feather="upload"></i>
            <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
            <input type="file" name="qimage_1" class="image-file-input hidden"/>
            <img class="img hidden " src=""/>
        </div>
    </div>

    <br/>
    <div class="divider-with-text">
        <span class="divider-with-text-line"></span>
        <span class="d-text"> <b> <?php echo lang('answers'); ?> </b></span>
    </div>

    <br/>
    <br/>
    <div class="answer-box">
        <div class="answer-box-row">

            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <h6> <?php echo lang('is_correct_answer'); ?> </h6></div>
            </div>

            <div class="row a-input-wrapper">
                <div class="col-6 lhs">
                    <div class="answer-image-area">
                        <i data-feather="upload"></i>
                        <span class="image-choose-text"><?php echo lang('choose_image'); ?></span>
                        <input type="file" name="answer_image_1_1"
                               class="hidden image-file-input"/>
                        <img class="img hidden" src=""/>
                    </div>
                    <input type="text" placeholder="<?php echo lang('answer_text') ?>"
                           class="form-control answer-box-row-input" name="answer_text_1_1"/>
                </div>
                <div class="col-6">
                    <label class="switch">
                        <input type="radio" name="correct_1_1" value="0" checked/>
                        <input type="radio" name="correct_1_1" value="1"/>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="row a-input-wrapper">
                <div class="col-6 lhs">
                    <div class="answer-image-area">
                        <i data-feather="upload"></i>
                        <span class="image-choose-text"><?php echo lang('choose_image') ?></span>
                        <input type="file" name="answer_image_1_2"
                               class="hidden image-file-input"/>
                        <img class="img hidden" src=""/>
                    </div>
                    <input type="text" placeholder="<?php echo lang('answer_text') ?>"
                           class="form-control answer-box-row-input" name="answer_text_1_2"/>
                </div>
                <div class="col-6">
                    <label class="switch">
                        <input type="radio" name="correct_1_2" value="0" checked/>
                        <input type="radio" name="correct_1_2" value="1"/>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-secondary add-more-answer"><i
                            data-feather="plus"></i> <?php echo lang('answer'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


