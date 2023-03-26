<?php

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image.prod.js"></script>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/hiukim/mind-ar-js@1.1.4/dist/mindar-image-aframe.prod.js"></script>
    <link rel="stylesheet" href="/wp-includes/css/dashicons.min.css">
    <link rel="stylesheet" href="css/cam.css">
    <script>

        AFRAME.registerComponent("logo", {
            init: function() {
                console.log('listen');
                 this.el.addEventListener("click", () => {
                    console.log('clicked');
                    parent.window.KtCube.currentscale = parent.window.KtCube.currentscale + 0.1
                    for (const fronttext of document.querySelectorAll('a-entity[messagecontainer]')) {
                        if (KtCube.currentscale > 0) {
                            let s= Ktparent.KtCube.currentscale;
                            fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);

                        }
                    }
                })
            }}
        );
    </script>
</head>
<body>

<?php
render_cam_scene('targets', 4  );
?>

</body>
</html>

<?php


function render_cam_scene($mindfilename, $targetindexes)
{
    $base_url = str_replace('/cam.php', '', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);

    /*
    if (isset($_GET['text'])) {
        $text = $_GET['text'];
    } else {
        $text = 'Meine Zeitansage';
    }

    if (isset($_GET['text_scale'])) {
        $scale = intval($_GET['text_scale'])* 3;
    } else {
        $scale = 3;
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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = '';
    }
    */
    $home_url = '' . $_SERVER['SERVER_NAME'] .'/';
    $arrow_class = isset($_GET['shuffle'])?'cam-ui-item':'hidden';
    ?>

    <div class="cam-container">

        <div id="cam-post-id" class="cam-ui-item">
            <?php echo $home_url; ?><span id="cam-id"></span>
        </div>

        <div class="cam-ui-toolbar-grid">
            <div class="<?php echo $arrow_class; ?> cam-left-arrow">
                <img src="<?php echo $base_url; ?>/assets/arrow-left.png">
            </div>
            <div class="ghost"></div>
            <div id="cam-share-screenshot" class="cam-ui-item">
                <svg height="40" viewBox="0 96 960 960" width="40"><path d="M479.667 792q73.333 0 123.5-50.167 50.166-50.166 50.166-123.5 0-73.333-50.166-123.166-50.167-49.833-123.5-49.833-73.334 0-123.167 49.833t-49.833 123.166q0 73.334 49.833 123.5Q406.333 792 479.667 792Zm0-66.666q-45.667 0-76-30.667-30.334-30.667-30.334-76.334 0-45.666 30.334-76Q434 512 479.667 512q45.666 0 76.333 30.333 30.667 30.334 30.667 76 0 45.667-30.667 76.334t-76.333 30.667ZM146.666 936q-27 0-46.833-19.833T80 869.334V367.333q0-26.333 19.833-46.5 19.833-20.166 46.833-20.166h140.001L360 216h240l73.333 84.667h140.001q26.333 0 46.499 20.166Q880 341 880 367.333v502.001q0 27-20.167 46.833Q839.667 936 813.334 936H146.666Zm666.668-66.666V367.333H642.667l-73-84.667H390.333l-73 84.667H146.666v502.001h666.668ZM480 618.667Z"/></svg>
            </div>
            <div id="cam-text-zoom-minus" class="cam-ui-item">
                <svg height="40" viewBox="0 96 960 960" width="40"><path d="m40 856 216.667-560h86.666L560 856h-82l-55-147.667H177L122 856H40Zm162.666-217.333h194.668L302 380.666h-4l-95.334 258.001Zm404.001-29.334v-66.666H920v66.666H606.667Z"/></svg>
            </div>
            <div id="cam-text-zoom-plus" class="cam-ui-item">
                <svg height="40" viewBox="0 96 960 960" width="40"><path d="m40 856 216.667-560h86.666L560 856h-82l-55-147.667H177L122 856H40Zm162.666-217.333h194.668L302 380.666h-4l-95.334 258.001ZM726.667 736V609.333H600v-66.666h126.667V416h66.666v126.667H920v66.666H793.333V736h-66.666Z"/></svg>
            </div>
            <div class="ghost"></div>
            <div class="<?php echo $arrow_class; ?> cam-right-arrow">
                <img src="<?php echo $base_url; ?>/assets/arrow-right.png">
            </div>
        </div>


        <a-scene mindar-image="imageTargetSrc:<?php echo $base_url; ?>/assets/<?php echo $mindfilename ?>.mind;"
                 color-space="sRGB"
                 renderer="colorManagement: true, physicallyCorrectLights" vr-mode-ui="enabled: false"
                 device-orientation-permission-ui="enabled: false">
            <a-assets>
                <a-asset-item id="logo" src="<?php echo $base_url; ?>/assets/Jetzt-ist-die-Zeit.glb"></a-asset-item>
            </a-assets>
            <a-gltf-model src="#logo"
                          rotation="90 0 0 "
                          position="0 0 -5"
                          scale="0.01 0.01 0.01"
                          animation="property: position; to: 0 0 -0.1; dur: 1000; easing: easeInOutQuad; loop:1"></a-gltf-model>
            <a-camera position="0 0 0" look-controls="enabled: false">
                <a-animation begin="click" attribute="camera.zoom" from="1" to="2" dur="10000"></a-animation>
            </a-camera>

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
                                text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: ...;negate:false; align:center; shader:msdf; color:#ffffff ;opacity:0.9 ; side:double; wrapPixels:450 ; baseline:bottom"
                                position="0 -1.2 0.1"
                                scale="0.5 0.5 0.5" rotation="0 0 0"
                                animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
                                material="side:double"

                        >
                            <a-entity
                                    messagetext back
                                    text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: ...;negate:false; align:center; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:450 ; baseline:bottom"
                                    position="0.01 -0 -0.021"
                                    material="side:double"
                            >

                                <?php
                                ?>
                                <a-entity
                                        authortext front
                                        text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: ;negate:false; align:right; shader:msdf; color:#ffffff ; opacity:0.9 ; side:double; wrapPixels:400"
                                        position="0 -0.05 0"
                                        scale="0.5 0.5 0.5"
                                        rotation="0 0 0"
                                        material="side:double"

                                ></a-entity>
                                <a-entity
                                        authortext back
                                        text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: ;negate:false; align:right; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:400"
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

                </a-entity>
                <?php
            }
            ?>


        </a-scene>

    </div>
    <?php

}

?>
