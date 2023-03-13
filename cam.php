<?php
$base_url = str_replace('/cam.php', '', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);

if (isset($_GET['model']) || isset($_GET['text'])) {

    if (isset($_GET['text_scale'])) {
        $scale = intval($_GET['text_scale']) * 5;
    } else {
        $scale = 5;
    }
    if (isset($_GET['font'])) {
        $font = $_GET['font'];
    } else {
        $font = 'PermanentMarker-Regular-msdf';
    }
    ?>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image.prod.js"></script>
        <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image-aframe.prod.js"></script>

    </head>
    <body>

    <a-scene mindar-image="imageTargetSrc:<?php echo $base_url; ?>/assets/targetvector.mind;" color-space="sRGB"
             renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false"
             device-orientation-permission-ui="enabled: false">
        <a-assets>
            <a-asset-item id="logo" src="<?php echo $base_url; ?>/assets/Jetzt-ist-die-Zeit.glb"></a-asset-item>
            -->
        </a-assets>
        <a-gltf-model logo src="#logo"
                      rotation="90 0 0 "
                      position="0 0 -3"
                      scale="0.01 0.01 0.01"
                      animation="property: position; to: 0 0 0; dur: 1000; easing: easeInOutQuad; loop:1"></a-gltf-model>
        <a-camera position="0 0 0" look-controls="enabled: false"></a-camera>
        <a-entity mindar-image-target="targetIndex: 0">
            <a-entity light="type:directional; castShadow:true;" position="1 1 8"></a-entity>
            <a-gltf-model logo src="#logo"
                          rotation="90 0 0 "
                          position="-5 5 -8"
                          scale="0.01 0.01 0.01"
                          visible="true"
                          animation="property: position; to: -0.5 1.2 -1; dur: 3000;delay:1000; easing: easeInOutQuad; loop:1; "
            ></a-gltf-model>

            <a-entity
                    fronttext

                    text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $_GET['text'] ?>;negate:false; align:center; shader:msdf; color:<?php echo $_GET['text_color'] ?>; width:1.5;opacity:0.8 ; side:double"
                    position="0 0 -0.245"
                    scale="<?php echo $scale . ' ' . $scale . ' ' . $scale ?>" rotation="0 0 0"
                    animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
                    material="side:double"

            ></a-entity>

            <a-entity
                    shadowtext

                    text="font:<?php echo $base_url; ?>/assets/<?php echo $font ?>.json; value: <?php echo $_GET['text'] ?>;negate:false; align:center; shader:msdf; color:#000; width:1.5;opacity:0.15 ; side:double"
                    position="0 0 -0.4"
                    scale="<?php echo $scale . ' ' . $scale . ' ' . $scale ?>" rotation="0 0 0"
                    animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
                    material="side:double"
            ></a-entity>


        </a-entity>

    </a-scene>


    </body>
    </html>

    <?php


}

?>
