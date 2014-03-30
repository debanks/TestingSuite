<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$settings = simplexml_load_file('../vars/settings.xml');
$position = filter_var($_GET['position'], FILTER_SANITIZE_NUMBER_INT);

foreach ($settings->sections->section as $section) {
    if ((string) $section['position'] == $position) {
        $execute = (string)$section->execute;
        $url = (string) $section->location;
    }
}

if($execute){
    file_get_contents($execute);
}

if ($url) {
    $xml = simplexml_load_file($url);
    echo '<div class="status" style="display:none" status="' . $xml->status . '"></div>';
    echo '<div class="result-container">';

    foreach ($xml->tests->test as $test) {
        echo '<div class="table" style="width:100%;">';
        echo '<div class="row">';

        if ((int) $test['status'] == 2)
            echo '<div class="cell bar green"></div>';
        if ((int) $test['status'] == 1)
            echo '<div class="cell bar yellow"></div>';
        if ((int) $test['status'] == 0)
            echo '<div class="cell bar red"></div>';

        echo '<div class="cell">';
        echo '<h3 style="text-align:left;margin-bottom:0;padding:5px 20px">' . $test->title . '</h3>';
        echo '<p>' . $test->description;
        if ($test->url) {
            echo '<br/><br/>URL: <a href="' . $test->url . '" target="_blank">' . $test->url . '</a></p>';
        } else {
            echo '</p>';
        }

        if ($test->error)
            echo '<p style="color:#990000">Web Service had an Error</p>';

        if ($test->table) {
            echo '<div class="table" style="width:90%;margin-left:5%;margin-bottom:20px;font-size:12px;font-weight:bold;">';
            foreach ($test->table->row as $row) {
                echo '<div class="row">';
                $values = array('', '', '');
                $status = array(2,2,2);
                $i=0;
                foreach ($row->cell as $cell) {
                    $values[$i] = (string)$cell;
                    $status[$i] = (int)$cell['status'];
                    $i++;
                }
                for($i=0;$i<3;$i++){
                    echo '<div class="cell" style="width:33%;padding:4px 0">';
                    if($status[$i]==2){
                        echo '<span style="color:#009900">'.$values[$i].'</span>';
                    } elseif($status[$i]==1){
                        echo '<span style="color:#999900">'.$values[$i].'</span>';
                    } else {
                        echo '<span style="color:#990000">'.$values[$i].'</span>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }

        echo '</div></div></div></div>';
    }
}
?>
