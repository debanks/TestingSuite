<?php
$xml = simplexml_load_file('vars/settings.xml');
foreach ($xml->sections->section as $section) {
    $sections[] = array(
        'name' => $section->name,
        'description' => $section->description,
        'location' => $section->location,
        'position' => $section['position']
    );
}
?>
<html>
    <head>
        <title><?php echo $xml->title ?></title>
        <link rel="stylesheet" href="css/testingSuite.css" type="text/css" media="projection, screen" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="head">
                <div class="title"><a><?php echo $xml->title ?></a></div>
                <div class="status">
                    <div class="testText"></div>
                    <?php foreach ($sections as $i => $section) { ?>
                        <div class="load-row" section="<?php echo $i ?>">
                            <div class="load-cell">
                                <?php echo $section['name'] ?>
                            </div>
                            <div style="width:50px;text-align: right;padding:7px 0;vertical-align: middle">
                                <img src="img/loading.gif" class="loading" id="loading-<?php echo $i ?>"/>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="bottom">
                <div class="content table" style="width:90%;margin-left:5%">
                    <div class="row">
                        <div class="cell">
                            <div class="table content">
                                <?php foreach ($sections as $i => $section) { ?>
                                    <div class="row">
                                        <div class="cell section section-<?php echo $section['position']?>">
                                            <h2><?php echo $section['name']?></h2>
                                            <img class="refresh" src="img/refresh.png" section="<?php echo $section['position'] ?>"/>
                                            <p>
                                                <?php echo $section['description']?>
                                            </p>
                                            <div class="loading-<?php echo $i?> loading-div">
                                                <img align="center" src="img/loading.gif" class="loading"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell vertical-holder"></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="before-footer"></div>
            <?php if($xml->footer){?>
            <div class="footer">
                <div class="name"><?php echo $xml->footer->title?></div>
                <ul>
                    <?php foreach($xml->footer->links->link as $link){
                    echo '<li><a href="'.$link->url.'">'.$link->title.'</a></li>';
                    }?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.load-row').hover(function(){
                    $('.testText').text($(this).children('.load-cell').text());
                }, function(){
                    $('.testText').text('');
                });
                <?php foreach($sections as $i->$sections){?>
                $('.loading-<?php echo $section['position']?>').load('php/testXMLParser.php?position=<?php echo $section['position']?>',function(){
                    var status = parseInt($('.loading-<?php echo $section['position']?> .status').attr('status'));
                    if(status==0){
                        $('#loading-<?php echo $section['position']?>').attr('src','img/red-circle.png');
                    } else if(status==1){
                        $('#loading-<?php echo $section['position']?>').attr('src','img/yellow-circle.png');
                    } else if(status==2){
                        $('#loading-<?php echo $section['position']?>').attr('src','img/green-circle.png');
                    }
                });
                <?php } ?>
                
                $('.load-row').click(function() {
                    var _this = $(this);
                    var top = $('.section-'+$(_this).attr('section')).position();
                    $('html,body').animate({ scrollTop: top.top}, 200);

                    return false;

                    e.preventDefault();

                });
                $('.refresh').click(function(){
                    var _this = $(this);
                    var section = $(_this).attr('section');
                    <?php foreach($sections as $i=>$section){?>
                    if(section=='<?php echo $i?>'){
                        $('#loading-<?php echo $section['position']?>').attr('src','img/loading.gif');
                        $('.loading-<?php echo $section['position']?>').html('<img align="center" src="img/loading.gif" class="loading"/>');
                        $('.loading-<?php echo $section['position']?>').load('php/testXMLParser.php?position=<?php echo $section['position'] ?>',function(){
                            var status = parseInt($('.loading-<?php echo $i?> .status').attr('status'));
                            if(status==0){
                                $('#loading-<?php echo $section['position']?>').attr('src','img/red-circle.png');
                            } else if(status==1){
                                $('#loading-<?php echo $section['position']?>').attr('src','img/yellow-circle.png');
                            } else if(status==2){
                                $('#loading-<?php echo $section['position']?>').attr('src','img/green-circle.png');
                            }
                        });
                    }
                    <?php }?>
                });
            });
        </script>
    </body>
</html>