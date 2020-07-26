<div class="title-noquiz-wrapper mt-0 text-left">
    <div class="row dashboard-index p-3">

        <div class="col-4 dashboard-index__box p-2 pt-3">
            <div class="row p-0">
                <div class="col-4">
                    <span class="dashboard-index__icon-wrapper"><i data-feather="user"></i></span>
                </div>
                <div class="col-8">
                    <span class="dashboard-index__title d-block"><?php echo lang('total-users') ?></span>
                    <span class="dashboard-index__count d-block"><?php echo get_statistics('user'); ?></span>
                </div>
            </div>
        </div>

        <div class="col-4 dashboard-index__box p-2 pt-3 bg-dark">
            <div class="row p-0">
                <div class="col-4">
                    <span class="dashboard-index__icon-wrapper"><i data-feather="airplay"></i></span>
                </div>
                <div class="col-8">
                    <span class="dashboard-index__title d-block"><?php echo lang('total-quiz'); ?></span>
                    <span class="dashboard-index__count d-block"><?php echo get_statistics('quiz') ?></span>
                </div>
            </div>
        </div>
        <div class="col-4 dashboard-index__box p-2 pt-3 bg-primary">
            <div class="row p-0">
                <div class="col-4">
                    <span class="dashboard-index__icon-wrapper"><i data-feather="users"></i></span>
                </div>
                <div class="col-8">
                    <span class="dashboard-index__title d-block"><?php echo lang('total-participants'); ?></span>
                    <span class="dashboard-index__count d-block"><?php echo get_statistics('participants') ?></span>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="graph-container">
        <canvas id="canvas-user"></canvas>
    </div>
    <div class="graph-container">
        <canvas id="canvas-quiz"></canvas>
    </div>
    <div class="graph-container">
        <canvas id="canvas-part"></canvas>
    </div>
    <?php
    $months = get_months();
    $user_graph = array(
        "months" => $months,
        "title"=> lang('user-statistics'),
        "color"=>'#FC015B',
        "label"=>lang('user'),
        "data" => get_graph_data('user'),
        "cid" => 'canvas-user',
    );
    $quiz_graph = array(
        "months" => $months,
        "title"=> lang('quiz-statistics'),
        "color"=>'#333A41',
        "label"=>lang('quiz'),
        "data" => get_graph_data('quiz'),
        "cid" => 'canvas-quiz',
    );

    $p_graph = array(
        "months" => $months,
        "title"=> lang('participants-statistics'),
        "color"=>'#006CFF',
        "label"=>lang('participants'),
        "data" => get_graph_data('participants'),
        "cid" => 'canvas-part',
    );
    ?>
    <input type="hidden" id="g-user" value='<?php echo json_encode($user_graph) ?>'>
    <input type="hidden" id="g-quiz" value='<?php echo json_encode($quiz_graph) ?>'>
    <input type="hidden" id="g-part" value='<?php echo json_encode($p_graph) ?>'>
</div>