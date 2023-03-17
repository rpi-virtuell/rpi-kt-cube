<?php

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image.prod.js"></script>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image-aframe.prod.js"></script>

</head>
<body>

<?php
render_cam_scene('multi-targets', 3);
?>
</body>
</html>

<?php


function render_cam_scene($mindfilename, $targetindexes)
{
    $base_url = str_replace('/cam.php', '', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);


    if (isset($_GET['text'])) {
        $text = $_GET['text'];
    } else {
        $text = 'Meine Zeitansage';
    }

    if (isset($_GET['text_scale'])) {
        $scale = intval($_GET['text_scale']) * 2;
    } else {
        $scale = 5;
    }
    if (isset($_GET['font'])) {
        $font = $_GET['font'];
    } else {
        $font = 'Caveat-Bold-msdf';
    }
    if (isset($_GET['author'])) {
        $author = $_GET['author'];
    } else {
        $author = '';
    }
    ?>

    <a-scene mindar-image="imageTargetSrc:<?php echo $base_url; ?>/assets/<?php echo $mindfilename ?>.mind;"
             color-space="sRGB"
             renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false"
             device-orientation-permission-ui="enabled: false">
        <a-assets>
            <a-asset-item id="logo" src="<?php echo $base_url; ?>/assets/Jetzt-ist-die-Zeit.glb"></a-asset-item>
        </a-assets>
        <a-gltf-model logo src="#logo"
                      rotation="90 0 0 "
                      position="0 0 -3"
                      scale="0.01 0.01 0.01"
                      animation="property: position; to: 0 0 0; dur: 1000; easing: easeInOutQuad; loop:1"></a-gltf-model>
        <a-camera position="0 0 0" look-controls="enabled: false"></a-camera>

        <?php


        for ($i = 0;
             $i <= $targetindexes;
             $i++) {
            ?>
            <a-entity mindar-image-target="targetIndex: <?php echo $i ?>">
                <a-entity light="type:directional; castShadow:true;" position="1 1 8"></a-entity>
                <a-gltf-model logo src="#logo"
                              rotation="90 0 0"
                              position="0 0 0"
                              scale="0.006 0.006 0.006"
                              animation="property: scale; to: 0.005 0.005 0.005; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
                ></a-gltf-model>

                <a-entity container>

                    <a-entity
                            messagetext front messagecontainer
                            text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $text ?>;negate:false; align:center; shader:msdf; color:<?php echo $_GET['text_color'] ?> ;opacity:0.9 ; side:double; wrapPixels:450 ; baseline:bottom"
                            position="0 -1.2 0.1"
                            scale="<?php echo $scale . ' ' . $scale . ' ' . $scale ?>" rotation="0 0 0"
                            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
                            material="side:double"

                    >
                        <a-entity
                                messagetext back
                                text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $text ?>;negate:false; align:center; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:450 ; baseline:bottom"
                                position="0.01 -0 -0.021"
                                material="side:double"
                        >

                            <?php
                            ?>
                            <a-entity
                                    authortext front
                                    text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $author ?>;negate:false; align:right; shader:msdf; color:<?php echo $_GET['text_color'] ?>; opacity:0.9 ; side:double; wrapPixels:400"
                                    position="0 -0.05 0"
                                    scale="0.5 0.5 0.5"
                                    rotation="0 0 0"
                                    material="side:double"

                            ></a-entity>
                            <a-entity
                                    authortext back
                                    text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $author ?>;negate:false; align:right; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:400"
                                    position="0.01 -0.05 -0.005"
                                    scale="0.5 0.5 0.5"
                                    rotation="0 0 0"
                                    material="side:double"

                            ></a-entity>

                            <?php
                            ?>
                            <!--<a-entity geometry="primitive: circle" material="color:white; opacity:0.3" position="0 0.2 -0" width="2"
                                      heigth="3">

                            </a-entity>-->
                        </a-entity>


                    </a-entity>

                </a-entity>

                <a-image visible="true" class="clickable cam-left-arrow"
                         src="<?php echo $base_url; ?>/assets/arrow-left.png" position="-0 0 0" height="0.15"
                         width="1" material="" geometry=""></a-image>
                <a-image visible="true" class="clickable cam-right-arrow"
                         src="<?php echo $base_url; ?>/assets/arrow-right.png" position="0 0 0" height="0.15"
                         width="1" material="" geometry=""></a-image>
            </a-entity>
            <?php
        }
        ?>


    </a-scene>

    <?php

}

?>
