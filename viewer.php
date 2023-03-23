<?php
$base_url = str_replace('/viewer.php', '', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Example Scene</title>
    <script src="https://cdn.jsdelivr.net/gh/aframevr/aframe@master/dist/aframe-master.min.js"></script>
</head>
<body>
<a-scene debug="true" background="color:gray;">
    <a-camera position="0 0 0"  wasd-controls-enabled="false" look-controls="magicWindowTrackingEnabled: false"></a-camera>
    <a-entity light="type:directional; castShadow:true;" position="1 1 5"></a-entity>

    <a-entity
            messagetext front messagecontainer
            text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: Meine Zeitansage;negate:false; align:center; shader:msdf; color:#ff0000;opacity:0.9 ; side:double; wrapPixels:450 ; baseline:bottom"
            position="0 -0.05 -0.245"
            scale="0.5 0.5 0.5" rotation="0 0 0"
            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
            material="side:double"

    >
        <a-entity
                messagetext back
                text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value: Meine Zeitansage;negate:false; align:center; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:450 ; baseline:bottom"
                position="0.01 -0 -0.021"
                material="side:double"

        >
            <a-entity
                    authortext front
                    text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value:;negate:false; align:right; shader:msdf; color:#ff0000; opacity:0.9 ; side:double; wrapPixels:400"
                    position="0 -0.05 0" scale="0.5 0.5 0.5" rotation="0 0 0"
                    material="side:double"

            ></a-entity>
            <a-entity
                    authortext back
                    text="font:<?php echo $base_url; ?>/assets/Caveat-Bold-msdf.json; value:;negate:false; align:right; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:400"
                    position="0.01 -0.05 -0.005" scale="0.5 0.5 0.5" rotation="0 0 0"
                    material="side:double"

            ></a-entity>
        </a-entity>
    </a-entity>
    <a-image src="<?php echo $base_url; ?>/assets/background.jpg"
             position="0 0 -3.25" scale="5 3 4" width="2"
             height="2" rotation="0 0 0">
    </a-image>

</a-scene>

</body>
</html>
